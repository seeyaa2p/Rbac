<?php
require('db_connect.php');

// เช็คว่ามีการกดปุ่ม Submit ส่งค่าแบบ POST มาหรือยัง
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    if (!empty($username) && !empty($password) && !empty($name) && !empty($m_level)) {
        $SELECT = "SELECT username FROM user WHERE username = ? LIMIT 1";
        $INSERT = "INSERT INTO user (username, password, name) VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 0) {
            $stmt->close();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $username, $hashedPassword, $name);
            if ($stmt->execute()) {
                // สมัครเสร็จแล้วแจ้งเตือนและเด้งไปหน้า Login
                echo "<script>alert('บันทึกข้อมูลเรียบร้อย'); window.location.href='login.php';</script>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>ชื่อผู้ใช้นี้ถูกใช้งานแล้ว!!</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color:red; text-align:center;'>กรุณากรอกข้อมูลให้ครบถ้วน</p>";
    }
}
?>