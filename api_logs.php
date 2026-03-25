<?php
/**
 * api_logs.php
 * RBAC API Log Endpoint
 * รองรับทั้ง Browser (GET) และ SOAR Integration (POST)
 */

require_once 'db_connect.php';

// ============================================================
// 1. CORS & Response Headers
// ============================================================
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Content-Type: application/json; charset=utf-8');

// Handle Preflight Request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ============================================================
// 2. API Key Authentication (รองรับทั้ง SOAR และ Browser)
// ============================================================
define('API_KEY', 'your-secret-key-here'); // ⚠️ เปลี่ยนเป็น key จริงก่อน deploy

$headers     = getallheaders();
$auth_header = $headers['Authorization'] ?? '';
$is_api_call = str_starts_with($auth_header, 'Bearer ');

if ($is_api_call) {
    // SOAR / API Client — ตรวจสอบ Bearer Token
    if ($auth_header !== 'Bearer ' . API_KEY) {
        http_response_code(401);
        echo json_encode([
            "status"  => "error",
            "message" => "Unauthorized: Invalid API Key"
        ]);
        exit;
    }
} else {
    // Browser — ตรวจสอบ Session (Admin เท่านั้น)
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role_account'] !== 'admin') {
        http_response_code(403);
        echo json_encode([
            "status"  => "error",
            "message" => "Access Denied: Admin only"
        ]);
        exit;
    }
}

// ============================================================
// 3. POST — รับ Event / Alert จาก SOAR แล้วบันทึก Log
// ============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $body = json_decode(file_get_contents('php://input'), true);

    // ตรวจสอบ required fields
    if (empty($body['event_type'])) {
        http_response_code(400);
        echo json_encode([
            "status"  => "error",
            "message" => "Bad Request: event_type is required"
        ]);
        exit;
    }

    // ดึงค่าจาก SOAR payload
    $user_id     = $body['user_id']     ?? 'SOAR';
    $action_type = $body['event_type']  ?? 'alert';
    $action      = $body['severity']    ?? 'unknown';
    $target_name = $body['target_name'] ?? '';
    $ip_address  = $body['ip_address']  ?? $_SERVER['REMOTE_ADDR'];
    $run_id      = $body['run_id']      ?? null; // Idempotency key จาก SOAR

    // ป้องกัน Duplicate Event ด้วย run_id
    if ($run_id) {
        $check = $conn->prepare("SELECT log_id FROM audit_logs WHERE run_id = ? LIMIT 1");
        $check->bind_param("s", $run_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            http_response_code(200);
            echo json_encode([
                "status"  => "duplicate",
                "message" => "Event already recorded",
                "run_id"  => $run_id
            ]);
            exit;
        }
    }

    // บันทึกลงฐานข้อมูล
    $stmt = $conn->prepare("
        INSERT INTO audit_logs 
            (user_id, action_type, action, target_name, ip_address, run_id, timestamp, source)
        VALUES 
            (?, ?, ?, ?, ?, ?, NOW(), 'SOAR')
    ");
    $stmt->bind_param("ssssss", $user_id, $action_type, $action, $target_name, $ip_address, $run_id);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode([
            "status"     => "success",
            "message"    => "Log recorded successfully",
            "event_id"   => $conn->insert_id,
            "run_id"     => $run_id,
            "timestamp"  => date('Y-m-d H:i:s')
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status"  => "error",
            "message" => "Database error: " . $stmt->error
        ]);
    }

    exit;
}

// ============================================================
// 4. GET — ดึงข้อมูล Log แสดงผล (โค้ดเดิม)
// ============================================================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Optional filters จาก query string
    $where    = [];
    $params   = [];
    $types    = '';

    if (!empty($_GET['action_type'])) {
        $where[]  = "a.action_type = ?";
        $params[] = $_GET['action_type'];
        $types   .= 's';
    }

    if (!empty($_GET['from'])) {
        $where[]  = "a.timestamp >= ?";
        $params[] = $_GET['from'];
        $types   .= 's';
    }

    if (!empty($_GET['to'])) {
        $where[]  = "a.timestamp <= ?";
        $params[] = $_GET['to'];
        $types   .= 's';
    }

    $where_sql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    $sql = "SELECT 
                a.log_id,
                a.timestamp, 
                u1.username  AS admin_name, 
                a.action_type, 
                a.action, 
                a.target_name, 
                a.ip_address,
                a.source
            FROM audit_logs a 
            LEFT JOIN user u1 ON a.user_id = u1.user_id 
            $where_sql
            ORDER BY a.timestamp DESC
            LIMIT 1000";

    if ($params) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query($sql);
    }

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode([
        "status" => "success",
        "count"  => count($data),
        "data"   => $data
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    exit;
}

// ============================================================
// 5. Method ไม่รองรับ
// ============================================================
http_response_code(405);
echo json_encode([
    "status"  => "error",
    "message" => "Method Not Allowed"
]);