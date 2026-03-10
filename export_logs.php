<?php
session_start();
require_once 'db_connect.php';

// 1. ตรวจสอบสิทธิ์ว่าเป็น admin หรือไม่ 
if (!isset($_SESSION['user_id']) || $_SESSION['role_account'] !== 'admin') {
    header("location: index.php");
    exit;
}

// 2. ตรวจสอบว่ามาจากการกดปุ่มคำว่า "download_json" จริงๆ ใช่ไหม 
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['download_json'])) {
    // ถ้าไม่ได้กดปุ่มมา (เช่น แอบเอา URL ไปวางบนเบราว์เซอร์) ให้เด้งกลับไปหน้าประวัติ
    header("location: view_logs.php");
    exit;
}

// 3. ดึงข้อมูล Log ทั้งหมด
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

$logs_array = array();

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $logs_array[] = $row;
    }
}

// 4. แปลง Array เป็นรูปแบบ JSON
$json_data = json_encode($logs_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// 5. สั่งให้เบราว์เซอร์ดาวน์โหลดไฟล์
header('Content-Type: application/json; charset=utf-8');
header('Content-Disposition: attachment; filename="audit_logs.json"');

echo $json_data;
exit();
?>