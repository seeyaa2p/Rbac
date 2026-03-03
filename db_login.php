<?php
require('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // ดึงข้อมูลจากฐานข้อมูล
    $sql = "SELECT user_id, username, password, m_level FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // เก็บ Session 
            $_SESSION['user_id'] = $row['user_id']; 
            $_SESSION['role_account'] = $row['m_level']; 
            $_SESSION['username'] = $row['username'];

            //  ตรวจสอบสิทธิ์เพื่อแยกหน้า Landing Page
            if ($row['m_level'] === 'admin') {
                header("Location: admin.php"); // ถ้าเป็น admin ให้พาไปหน้าจัดการหลังบ้าน
            } else {
                header("Location: index.php"); // ถ้าเป็นสิทธิ์อื่นๆ (user) ให้พาไปหน้าแรกปกติ
            }
            exit();
        } else {
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('ไม่พบชื่อผู้ใช้นี้'); window.history.back();</script>";
    }
}
?>