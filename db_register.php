<?php
require('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. รับค่าจากฟอร์มและใช้ trim() เพื่อป้องกันการเผลอกดเว้นวรรค
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    
    // 2. กำหนดสิทธิ์เริ่มต้นให้เป็น 'user' เสมอ
    $m_level = 'user'; 

    // 3. เช็คเฉพาะ 3 ช่องที่รับมาจากฟอร์มว่าต้องไม่เป็นค่าว่าง
    if (!empty($username) && !empty($password) && !empty($name)) { 
        $SELECT = "SELECT username FROM user WHERE username = ? LIMIT 1";
        $INSERT = "INSERT INTO user (username, password, name, m_level) VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 0) {
            $stmt->close();
            // เข้ารหัสผ่านก่อนบันทึก
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare($INSERT);
            
            // ส่งค่าทั้ง 4 ตัวแปร (รวมถึง $m_level ที่ตั้งเป็น 'user') ลงฐานข้อมูล
            $stmt->bind_param("ssss", $username, $hashedPassword, $name, $m_level);
            
            if ($stmt->execute()) {
                //  ดึง ID ของผู้ใช้งานที่เพิ่งสร้างเสร็จเมื่อกี้
                $new_user_id = $conn->insert_id;
                
                //  กำหนดข้อความรายละเอียด
                $action_detail = "สมัครสมาชิกใหม่ชื่อ: " . $username;
                
                //  เรียกใช้ฟังก์ชันบันทึก Log 
                // กำหนด user_id เป็นของคนสมัครเอง, action_type เป็น 'CREATE' และส่งชื่อไปเก็บใน target_name
                log_action($conn, $new_user_id, $action_detail, 'CREATE', null, $username, 'success');

                echo "<script>alert('สมัครสมาชิกเรียบร้อยแล้ว!'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('ชื่อผู้ใช้นี้ถูกใช้งานแล้ว!!'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
    }
}
?>