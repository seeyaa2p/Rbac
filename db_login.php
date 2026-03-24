<?php
require('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT user_id, username, password, m_level FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id']; 
            $_SESSION['role_account'] = $row['m_level']; 
            $_SESSION['username'] = $row['username'];

            // เรียกใช้ฟังก์ชันบันทึกการ Login
            log_action($conn, $row['user_id'], 'เข้าสู่ระบบสำเร็จ', 'LOGIN');

            // ส่งทุกคนไปที่หน้า index.php
            http_response_code(200);
            header("Location: index.php");
            exit();
        } else {
            http_response_code(401);
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.history.back();</script>";
        }
    } else {
        http_response_code(404);
        echo "<script>alert('ไม่พบชื่อผู้ใช้นี้'); window.history.back();</script>";
    }
}
?>