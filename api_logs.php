<?php
session_start();
require_once 'db_connect.php';

// 1. ตรวจสอบสิทธิ์ (Security Check) 
// เราต้องเช็คว่าคนที่เรียกใช้คือ Admin ใช่ไหม?
if (!isset($_SESSION['user_id']) || $_SESSION['role_account'] !== 'admin') {
    // ถ้าไม่ใช่ Admin เราจะส่งรหัสข้อผิดพลาดกลับไป
    http_response_code(403);
    echo json_encode(["error" => "Access Denied"]);
    exit;
}

// 2. ตั้งค่า Header ให้เป็น JSON 
header('Content-Type: application/json; charset=utf-8');

// 3. ดึงข้อมูลจากฐานข้อมูล 
// นำคำสั่ง SQL ที่เราคุยกันไว้มาใส่ตรงนี้ครับ
$sql = "SELECT 
            a.timestamp, 
            u1.username AS admin_name, 
            a.action_type, 
            a.action, 
            a.target_name, 
            a.ip_address 
        FROM audit_logs a 
        LEFT JOIN user u1 ON a.user_id = u1.user_id 
        ORDER BY a.timestamp DESC";

$result = $conn->query($sql);
$data = array();

if ($result) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// 4. ส่งข้อมูลออกไปเป็นรูปแบบ JSON 
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);