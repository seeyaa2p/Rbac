<?php
session_start();
require_once 'db_connect.php';

// 1. ตรวจสอบสิทธิ์ (Security Check) 
// เราจะอนุญาตให้เฉพาะ Admin ที่ล็อกอินอยู่เท่านั้นที่เข้าหน้านี้ได้
if (!isset($_SESSION['user_id']) || $_SESSION['m_level'] !== 'admin') {
    die("Access Denied: คุณไม่มีสิทธิ์เข้าถึงหน้านี้");
}

// 2. ตั้งค่า Header เพื่อแสดงผลเป็น JSON 
// บรรทัดนี้สำคัญมาก เพราะจะบอก Browser ว่านี่ไม่ใช่หน้าเว็บปกติ แต่เป็นข้อมูล JSON
header('Content-Type: application/json; charset=utf-8');

// 3. ดึงข้อมูลจากฐานข้อมูล 
$sql = "SELECT a.*, u1.username AS admin_name, u2.username AS target_name 
        FROM audit_logs a 
        LEFT JOIN user u1 ON a.user_id = u1.user_id 
        LEFT JOIN user u2 ON a.target_id = u2.user_id 
        ORDER BY a.timestamp DESC";

$result = $conn->query($sql);
$data = array();

if ($result) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// 4. แปลง Array เป็น JSON และแสดงผล 
// JSON_PRETTY_PRINT จะช่วยจัดบรรทัดให้สวยงามอ่านง่าย
// JSON_UNESCAPED_UNICODE จะช่วยให้ภาษาไทยแสดงผลได้อย่างถูกต้อง
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;