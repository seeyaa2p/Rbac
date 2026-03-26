<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connect.php';

// SOAR Cloud config (เอาจาก URL ที่ใช้เปิด SOAR UI)
$soar_host = "https://d7pv5.siemplify-soar.com/v1alpha/projects/582001996409/locations/asia-southeast1/instances/204c70d8-15c8-42b2-a53b-e7a9c952ce33/webhooks/6d00c1d6-a134-4eb7-9350-07e6088f0f92/6d00c1d6-a134-4eb7-9350-07e6088f0f92:ingest?apiKey=**************************
";
$api_key   = "YOUR_ACTUAL_SOAR_API_KEY";  // เอาจาก Settings → API Key

// ดึง Cases
$ch = curl_init("$soar_host/api/external/v1/cases/GetCasesByFilter");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "filterCondition" => 0,  // 0 = All
    "statuses"        => [1], // 1 = Open
    "pageSize"        => 50,
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "AppKey: " . $api_key,
    "Content-Type: application/json",
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    die(" SOAR API Error $httpCode: $response");
}

$data     = json_decode($response, true);
$cases    = $data['cases'] ?? [];
$inserted = 0;

foreach ($cases as $case) {
    $message  = $case['title'] ?? $case['name'] ?? json_encode($case);
    $severity = strtolower($case['priority'] ?? 'info');

    if (str_contains($severity, 'critical') || str_contains($severity, 'high')) {
        $type = 'danger';
    } elseif (str_contains($severity, 'medium')) {
        $type = 'warning';
    } else {
        $type = 'info';
    }

    // กัน duplicate
    $chk = $conn->prepare("SELECT id FROM notices WHERE message = ? LIMIT 1");
    $chk->bind_param("s", $message);
    $chk->execute();
    if ($chk->get_result()->num_rows > 0) continue;

    $stmt = $conn->prepare("INSERT INTO notices (message, type, is_active) VALUES (?, ?, 1)");
    $stmt->bind_param("ss", $message, $type);
    $stmt->execute();
    $inserted++;
}

echo json_encode([
    'status'   => 'ok',
    'inserted' => $inserted,
    'total'    => count($cases),
]);