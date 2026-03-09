<?php
require_once 'db_connect.php';

// 1. ดึงข้อมูลจากตาราง audit_logs (อ้างอิงจากโครงสร้างตารางในรูปของคุณ)
$sql = "SELECT log_id, user_id, action, timestamp FROM audit_logs ORDER BY log_id DESC";
$result = $conn->query($sql);

$logs = [];
if ($result && $result->num_rows > 0) {
    $logs = $result->fetch_all(MYSQLI_ASSOC);
}

// 2. ตั้งค่า Header เพื่อบังคับให้ดาวน์โหลดไฟล์
header('Content-Type: application/json; charset=utf-8');
// ตั้งชื่อไฟล์ที่จะดาวน์โหลด โดยต่อท้ายด้วยวันที่และเวลาปัจจุบัน
header('Content-Disposition: attachment; filename="audit_logs_' . date('Ymd_His') . '.json"');

// 3. แปลง Array เป็น JSON และพิมพ์ออกมา
// - JSON_UNESCAPED_UNICODE: ป้องกันไม่ให้ภาษาไทยกลายเป็นตัวอักษรแปลกๆ
// - JSON_PRETTY_PRINT: จัดย่อหน้า JSON ให้สวยงามและอ่านง่ายเวลาเปิดไฟล์
echo json_encode($logs, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit; // หยุดการทำงานของ PHP ทันทีเพื่อไม่ให้มีเว้นวรรคหรือโค้ด HTML อื่นหลุดเข้าไปในไฟล์
?>