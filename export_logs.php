<?php
session_start();
require('db_connect.php');

// 1. ตรวจสอบสิทธิ์อีกครั้งเพื่อความปลอดภัย! (ห้ามลืมเด็ดขาด) 🛡️
if (!isset($_SESSION['user_id']) || $_SESSION['role_account'] !== 'admin') {
    die(json_encode(["error" => "Unauthorized access"]));
}

// 2. ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM audit_logs ORDER BY timestamp DESC";
$result = mysqli_query($conn, $sql);

$logs_array = array();

// 3. นำข้อมูลแต่ละแถวมาเก็บสะสมไว้ใน Array
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $logs_array[] = $row;
    }
}

// 4. ตั้งค่า Header เพื่อบังคับให้เบราว์เซอร์ดาวน์โหลดไฟล์ .json
header('Content-Type: application/json; charset=utf-8');
header('Content-Disposition: attachment; filename="audit_logs_' . date('Ymd_His') . '.json"');

// 5. แปลง Array เป็น JSON แล้วแสดงผลออกมา (ซึ่งจะถูกดาวน์โหลดลงเครื่อง)
// ใช้ JSON_UNESCAPED_UNICODE เพื่อให้ภาษาไทยแสดงผลได้ถูกต้อง ไม่กลายเป็นรหัส
echo json_encode($logs_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
?>