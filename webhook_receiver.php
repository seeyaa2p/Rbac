<?php
require_once 'db_connect.php';

// รับ raw JSON จาก Google SecOps
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    http_response_code(400);
    exit('Invalid JSON');
}

// ดึงข้อมูลจาก payload (ปรับ field ตาม format ที่ Google SecOps ส่งมา)
$message   = $data['description'] ?? $data['message'] ?? $data['name'] ?? json_encode($data);
$severity  = strtolower($data['severity'] ?? $data['type'] ?? 'info');

// Map severity → type
$type = match($severity) {
    'critical', 'high'   => 'danger',
    'medium', 'warning'  => 'warning',
    'low', 'informational', 'info' => 'info',
    default => 'info'
};

// บันทึกลง DB
$stmt = $conn->prepare("INSERT INTO notices (message, type, is_active) VALUES (?, ?, 1)");
$stmt->bind_param("ss", $message, $type);
$stmt->execute();

http_response_code(200);
echo json_encode(['status' => 'ok']);