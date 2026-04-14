<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require('db_connect.php');

/**
 * บันทึก failed login ลง audit_logs
 */
function log_failed_login($conn, $user_id, $username, $ip_address, $reason = 'Login failed')
{
    $user_id = (int)$user_id;
    $username = trim((string)$username);
    $ip_address = trim((string)$ip_address);

    $stmt = $conn->prepare("
        INSERT INTO `audit_logs`
            (user_id, action, action_type, ip_address, target_name, status, source)
        VALUES
            (?, ?, 'LOGIN_FAILED', ?, ?, 'failed', 'application')
    ");

    $stmt->bind_param("isss", $user_id, $reason, $ip_address, $username);
    $stmt->execute();
}

/**
 * ปลดล็อกอัตโนมัติถ้าเวลาหมดแล้ว
 */
function unlock_if_expired($conn, $user_id)
{
    $stmt = $conn->prepare("
        UPDATE `user`
        SET status = NULL,
            locked_until = NULL,
            lock_reason = NULL
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    if ($username === '' || $password === '') {
        http_response_code(400);
        echo "<script>alert('กรุณากรอกชื่อผู้ใช้และรหัสผ่าน'); window.history.back();</script>";
        exit();
    }

    $sql = "
        SELECT
            user_id,
            username,
            password,
            m_level,
            status,
            locked_until
        FROM `user`
        WHERE username = ?
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        // เช็กว่าถูกล็อกชั่วคราวอยู่หรือไม่
        if (!empty($row['status']) && $row['status'] === 'temporary_locked') {
            if (!empty($row['locked_until']) && strtotime($row['locked_until']) > time()) {
                http_response_code(403);
                echo "<script>alert('บัญชีถูกระงับชั่วคราว กรุณาลองใหม่ภายหลัง'); window.history.back();</script>";
                exit();
            } else {
                // หมดเวลาล็อกแล้ว ปลดล็อกอัตโนมัติ
                unlock_if_expired($conn, (int)$row['user_id']);
            }
        }

        // ตรวจรหัสผ่าน
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role_account'] = $row['m_level'];
            $_SESSION['username'] = $row['username'];

            // log success (ใช้ฟังก์ชันเดิมของคุณ)
            if (function_exists('log_action')) {
                log_action($conn, $row['user_id'], 'เข้าสู่ระบบสำเร็จ', 'LOGIN');
            }

            http_response_code(200);
            header("Location: index.php");
            exit();
        } else {
            // รหัสผ่านผิด -> log failed พร้อม username จริง
            log_failed_login(
                $conn,
                (int)$row['user_id'],
                $row['username'],
                $ip_address,
                'Wrong password'
            );

            http_response_code(401);
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.history.back();</script>";
            exit();
        }

    } else {
        // ไม่พบ username -> log failed ไว้ด้วย
        log_failed_login(
            $conn,
            0,
            $username,
            $ip_address,
            'Unknown username'
        );

        http_response_code(404);
        echo "<script>alert('ไม่พบชื่อผู้ใช้นี้'); window.history.back();</script>";
        exit();
    }
}
?>