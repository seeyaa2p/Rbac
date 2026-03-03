<?php
require('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // หมายเหตุ: เช็คในฐานข้อมูลด้วยนะครับว่าคอลัมน์ ID ของคุณชื่อ id_account หรือ id เฉยๆ
    $sql = "SELECT id_account, username, password, m_level FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // เก็บค่าลง Session เพื่อยืนยันตัวตน
            $_SESSION['id_account'] = $row['id_account'];
            $_SESSION['role_account'] = $row['m_level']; 
            $_SESSION['username'] = $row['username'];

            header("Location: index.php");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>รหัสผ่านไม่ถูกต้อง</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>ไม่พบชื่อผู้ใช้นี้</p>";
    }
}
?>