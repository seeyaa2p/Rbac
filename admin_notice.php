<?php
session_start(); 
require_once 'db_connect.php'; 

// ฟังก์ชันส่ง Webhook ไป SecOps
function sendSecOpsWebhook($event, $data) {
    $webhook_url = "https://d7pv5.siemplify-soar.com/v1alpha/projects/582001996409/locations/asia-southeast1/instances/204c70d8-15c8-42b2-a53b-e7a9c952ce33/webhooks/6d00c1d6-a134-4eb7-9350-07e6088f0f92:ingest?apiKey=00924396-e904-4c4a-a288-1265d2815858";
    
    $payload = [
        "event"     => $event,
        "timestamp" => date('Y-m-d H:i:s'),
        "data"      => $data
    ];

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    curl_close($ch);
}

$feedback = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $message = trim($_POST['message']);
        $type    = $_POST['type'];
        if ($message !== '') {
            $stmt = $conn->prepare("INSERT INTO notices (message, type, is_active) VALUES (?, ?, 1)");
            $stmt->bind_param("ss", $message, $type);
            $stmt->execute();
            $feedback = ' เพิ่มข้อความแจ้งเตือนสำเร็จ';

            // ส่ง Webhook
            sendSecOpsWebhook('notice_added', [
                'message' => $message,
                'type'    => $type
            ]);

        } else {
            $feedback = ' กรุณากรอกข้อความ';
        }
    } elseif ($_POST['action'] === 'toggle') {
        $new = ((int)$_POST['current']) ? 0 : 1;
        $id  = (int)$_POST['id'];
        $stmt = $conn->prepare("UPDATE notices SET is_active = ? WHERE id = ?");
        $stmt->bind_param("ii", $new, $id);
        $stmt->execute();

        // ส่ง Webhook
        sendSecOpsWebhook('notice_toggled', [
            'id'     => $id,
            'status' => $new ? 'enabled' : 'disabled'
        ]);

    } elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        $stmt = $conn->prepare("DELETE FROM notices WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $feedback = ' ลบข้อความเรียบร้อย';

        // ส่ง Webhook
        sendSecOpsWebhook('notice_deleted', [
            'id' => $id
        ]);
    }
}

$notices = $conn->query("SELECT * FROM notices ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Admin — Notice Manager</title>
</head>
<body>

  <h1>🔔 Notice Manager (Admin)</h1>
  <hr>

  <?php if ($feedback): ?>
    <p><b><?= $feedback ?></b></p>
    <hr>
  <?php endif; ?>

  <h2>➕ เพิ่มข้อความแจ้งเตือนใหม่</h2>
  <form method="POST">
    <input type="hidden" name="action" value="add">
    <p>
      <label>ข้อความ :<br>
        <textarea name="message" rows="3" cols="60" placeholder="พิมพ์ข้อความ..." required></textarea>
      </label>
    </p>
    <p>
      <label>ประเภท :
        <select name="type">
          <option value="info">ℹ️ Info</option>
          <option value="warning">⚠️ Warning</option>
          <option value="danger">🚨 Danger</option>
          <option value="success">✅ Success</option>
        </select>
      </label>
    </p>
    <p><input type="submit" value="📢 เพิ่มแจ้งเตือน"></p>
  </form>

  <hr>

  <h2>📋 รายการทั้งหมด</h2>

  <?php if (empty($notices)): ?>
    <p>ยังไม่มีข้อความแจ้งเตือน</p>
  <?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>#</th>
          <th>ข้อความ</th>
          <th>ประเภท</th>
          <th>สถานะ</th>
          <th>วันที่</th>
          <th>จัดการ</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($notices as $n): ?>
        <tr>
          <td><?= $n['id'] ?></td>
          <td><?= htmlspecialchars($n['message']) ?></td>
          <td><?= $n['type'] ?></td>
          <td><?= $n['is_active'] ? '🟢 เปิด' : '⚫ ปิด' ?></td>
          <td><?= date('d/m/y H:i', strtotime($n['created_at'])) ?></td>
          <td>
            <form method="POST" style="display:inline">
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= $n['id'] ?>">
              <input type="hidden" name="current" value="<?= $n['is_active'] ?>">
              <input type="submit" value="<?= $n['is_active'] ? '🔕 ปิด' : '🔔 เปิด' ?>">
            </form>
            <form method="POST" style="display:inline" onsubmit="return confirm('ยืนยันลบ?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= $n['id'] ?>">
              <input type="submit" value="🗑️ ลบ">
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

</body>
</html>