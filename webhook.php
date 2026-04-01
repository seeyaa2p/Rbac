<?php
session_start();
header('Content-Type: application/json');

$env = parse_ini_file(__DIR__ . '/config.env');
define('WH_SECRET', $env['WEBHOOK_SECRET'] ?? '');

require_once 'db_connect.php';


$received = $_SERVER['HTTP_X_WEBHOOK_SECRET'] ?? '';
if ($received !== WH_SECRET) {
    http_response_code(403);
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

$payload = json_decode(file_get_contents('php://input'), true);
if (!$payload) {
    echo json_encode(['status' => 'success', 'message' => 'pong']);
    exit;
}

$action = $payload['action'] ?? '';
$p      = $payload['params'] ?? [];

switch ($action) {

    case 'get_user':
        $stmt = $conn->prepare("SELECT u.user_id, u.username, u.name, u.m_level, u.time, r.admin, r.user AS role_user FROM `user` u LEFT JOIN `roles` r ON u.user_id = r.user_id WHERE u.username = ?");
        $stmt->bind_param("s", $p['username']);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $result = $row ? ['status' => 'success', 'data' => $row] : ['status' => 'not_found'];
        break;

    case 'get_audit_logs':
        $user_id = (int)($p['user_id'] ?? 0);
        $limit   = (int)($p['limit']   ?? 50);
        $stmt = $conn->prepare("SELECT log_id, action, action_type, timestamp, ip_address, target_name, status, source FROM `audit_logs` WHERE user_id = ? ORDER BY timestamp DESC LIMIT ?");
        $stmt->bind_param("ii", $user_id, $limit);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $result = ['status' => 'success', 'count' => count($rows), 'logs' => $rows];
        break;

    case 'get_logs_by_type':
        $action_type = $p['action_type'] ?? 'LOGIN';
        $limit       = (int)($p['limit'] ?? 100);
        $stmt = $conn->prepare("SELECT l.log_id, l.user_id, u.username, l.action, l.timestamp, l.ip_address, l.status, l.source FROM `audit_logs` l LEFT JOIN `user` u ON l.user_id = u.user_id WHERE l.action_type = ? ORDER BY l.timestamp DESC LIMIT ?");
        $stmt->bind_param("si", $action_type, $limit);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $result = ['status' => 'success', 'count' => count($rows), 'logs' => $rows];
        break;

    case 'get_logs_by_ip':
        $ip = $p['ip_address'] ?? '';
        $stmt = $conn->prepare("SELECT l.log_id, l.user_id, u.username, l.action, l.action_type, l.timestamp, l.status FROM `audit_logs` l LEFT JOIN `user` u ON l.user_id = u.user_id WHERE l.ip_address = ? ORDER BY l.timestamp DESC LIMIT 200");
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $result = ['status' => 'success', 'ip' => $ip, 'count' => count($rows), 'logs' => $rows];
        break;

    case 'create_notice':
        $message = $p['message'] ?? '';
        $type    = $p['type']    ?? 'info';
        if (!$message) {
            $result = ['status' => 'error', 'message' => 'message is required'];
            break;
        }
        $stmt = $conn->prepare("INSERT INTO `notices` (message, type, is_active, created_at) VALUES (?, ?, 1, NOW())");
        $stmt->bind_param("ss", $message, $type);
        $stmt->execute();
        $result = ['status' => 'success', 'notice_id' => $conn->insert_id, 'message' => $message, 'type' => $type];
        break;

    case 'dismiss_notice':
        $notice_id = (int)($p['notice_id'] ?? 0);
        $stmt = $conn->prepare("UPDATE `notices` SET is_active = 0 WHERE id = ?");
        $stmt->bind_param("i", $notice_id);
        $stmt->execute();
        $result = ['status' => 'success', 'dismissed_id' => $notice_id];
        break;

    case 'set_user_role':
        $user_id = (int)($p['user_id'] ?? 0);
        $m_level = $p['m_level'] ?? '';
        $stmt = $conn->prepare("UPDATE `user` SET m_level = ? WHERE user_id = ?");
        $stmt->bind_param("si", $m_level, $user_id);
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE `roles` SET m_level = ? WHERE user_id = ?");
        $stmt->bind_param("si", $m_level, $user_id);
        $stmt->execute();
        $stmt = $conn->prepare("INSERT INTO `audit_logs` (user_id, action, action_type, ip_address, target_id, target_name, status, source) VALUES (?, 'Role changed by SecOps', 'UPDATE', 'secops-agent', ?, 'user', 'success', 'secops')");
        $stmt->bind_param("ii", $user_id, $user_id);
        $stmt->execute();
        $result = ['status' => 'success', 'user_id' => $user_id, 'new_role' => $m_level];
        break;

    case 'log_secops_action':
        $user_id     = (int)($p['user_id']     ?? 0);
        $act         = $p['action']             ?? 'SecOps action';
        $action_type = $p['action_type']        ?? 'UPDATE';
        $ip          = $p['ip']                 ?? 'secops-agent';
        $target_name = $p['target_name']        ?? '';
        $run_id      = $p['run_id']             ?? '';
        $stmt = $conn->prepare("INSERT INTO `audit_logs` (user_id, action, action_type, ip_address, target_name, status, run_id, source) VALUES (?, ?, ?, ?, ?, 'success', ?, 'secops')");
        $stmt->bind_param("isssss", $user_id, $act, $action_type, $ip, $target_name, $run_id);
        $stmt->execute();
        $result = ['status' => 'success', 'log_id' => $conn->insert_id];
        break;

    default:
        http_response_code(400);
        $result = ['status' => 'unknown_action', 'action' => $action];
        break;
}

echo json_encode($result);