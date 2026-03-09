<?php
session_start();
require_once 'db_connect.php';

// 1. ตรวจสอบสิทธิ์ (ป้องกันคนนอกแอบมาโหลด)
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

// 2. ดึงข้อมูล Log ทั้งหมด
$sql = "SELECT a.timestamp, 
               u1.username AS admin_name, 
               a.action_type, 
               a.action, 
               u2.username AS target_name, 
               a.ip_address 
        FROM audit_logs a 
        LEFT JOIN user u1 ON a.user_id = u1.user_id 
        LEFT JOIN user u2 ON a.target_id = u2.user_id 
        ORDER BY a.timestamp DESC";

$result = $conn->query($sql);

// สร้าง Array ว่างๆ เพื่อเตรียมรับข้อมูล
$logs_array = array();

if ($result && $result->num_rows > 0) {
    // วนลูปนำข้อมูลแต่ละบรรทัด ยัดใส่เข้าไปใน Array
    while($row = $result->fetch_assoc()) {
        $logs_array[] = $row;
    }
}

// 3. แปลง Array เป็นรูปแบบ JSON
// JSON_UNESCAPED_UNICODE ช่วยให้ภาษาไทยไม่กลายเป็นตัวยึกยือ
// JSON_PRETTY_PRINT ช่วยจัดบรรทัดให้อ่านง่าย
$json_data = json_encode($logs_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// 4. สั่งให้เบราว์เซอร์ดาวน์โหลดไฟล์
header('Content-Type: application/json; charset=utf-8');
header('Content-Disposition: attachment; filename="audit_logs.json"');

// พิมพ์ข้อมูล JSON ออกมา (ซึ่งจะถูกบันทึกลงในไฟล์ที่โหลด)
echo $json_data;
exit();
?>