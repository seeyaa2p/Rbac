<?php
session_start(); 
require_once 'db_connect.php'; 
// 1. ตรวจสอบสิทธิ์ (Security Check)
$feedback = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $message = trim($_POST['message']);
        $type    = $_POST['type'];
        if ($message !== '') {
            $pdo->prepare("INSERT INTO notices (message, type, is_active) VALUES (?, ?, 1)")
                ->execute([$message, $type]);
            $feedback = ' เพิ่มข้อความแจ้งเตือนสำเร็จ';
        } else {
            $feedback = ' กรุณากรอกข้อความ';
        }
    } elseif ($_POST['action'] === 'toggle') {
        $new = ((int)$_POST['current']) ? 0 : 1;
        $pdo->prepare("UPDATE notices SET is_active = ? WHERE id = ?")->execute([$new, (int)$_POST['id']]);
    } elseif ($_POST['action'] === 'delete') {
        $pdo->prepare("DELETE FROM notices WHERE id = ?")->execute([(int)$_POST['id']]);
        $feedback = ' ลบข้อความเรียบร้อย';
    }
}

$notices = $pdo->query("SELECT * FROM notices ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
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

  <!-- ฟอร์มเพิ่ม -->
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

  <!-- รายการ -->
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
            <!-- Toggle -->
            <form method="POST" style="display:inline">
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= $n['id'] ?>">
              <input type="hidden" name="current" value="<?= $n['is_active'] ?>">
              <input type="submit" value="<?= $n['is_active'] ? '🔕 ปิด' : '🔔 เปิด' ?>">
            </form>
            <!-- Delete -->
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