<?php
session_start(); 
require_once 'db_connect.php'; 

// 1. ตรวจสอบสิทธิ์ (Security Check)
// ถ้าไม่ได้ Login ให้เด้งไปหน้า login
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

// 2. จัดการการอัปเดตสิทธิ์และบันทึก Log
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $target_user_id = $_POST['user_id'];
    $new_m_level = $_POST['m_level']; 
    
    $sql = "UPDATE user SET m_level = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_m_level, $target_user_id); 
    
    if ($stmt->execute()) {
        $current_logged_in_user = $_SESSION['user_id']; 
        $action_detail = "เปลี่ยนสิทธิ์ผู้ใช้รหัส $target_user_id เป็น $new_m_level";
        
        // บันทึกประวัติ (ฟังก์ชันอยู่ใน db_connect.php)
        log_action($conn, $current_logged_in_user, $action_detail, $target_user_id, 'success');
        
        echo "<script>alert('อัปเดตสิทธิ์สำเร็จ!'); window.location.href='admin.php';</script>";
        exit;
    }
}

// 3. ดึงข้อมูลผู้ใช้ (ยกเว้นตัวเอง)
$current_logged_in_user = $_SESSION['user_id'];
$current_username = $_SESSION['username'] ?? 'Admin';

$sql_users = "SELECT user_id, username, name, m_level FROM user WHERE user_id != ?";
$stmt_users = $conn->prepare($sql_users);
$stmt_users->bind_param("i", $current_logged_in_user); 
$stmt_users->execute();
$result = $stmt_users->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

$roles_options = ['admin', 'user'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบจัดการหลังบ้าน</title>
    <style>
        .nav-bar { background: #333; color: white; padding: 15px; margin-bottom: 20px; }
        .nav-bar a { color: white; text-decoration: none; margin-right: 20px; }
        .nav-bar a:hover { color: #ffca28; }
        .logout-btn { color: #ff5252 !important; font-weight: bold; }
    </style>
</head>
<body>

    <div class="nav-bar">
        <a href="admin.php"> หน้าหลักแอดมิน</a>
        <a href="view_logs.php"> ดูประวัติการใช้งาน</a>
        <a href="export_logs.php"> ดาวน์โหลด JSON</a>
        <a href="logout.php" class="logout-btn" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่?')"> ออกจากระบบ</a>
    </div>

    <div style="padding: 0 20px;">
        <h2>จัดการสิทธิ์ผู้ใช้งาน </h2>
        <p>สวัสดีคุณ: <strong><?= htmlspecialchars($current_username) ?></strong></p>

        <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
            <tr style="background-color: #eee;">
                <th>รหัส</th>
                <th>ชื่อผู้ใช้</th>
                <th>ชื่อ-สกุล</th>
                <th>สิทธิ์ปัจจุบัน</th>
                <th>แก้ไขสิทธิ์</th>
            </tr>
            
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['user_id'] ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><strong><?= htmlspecialchars($u['m_level']) ?></strong></td>
                <td>
                    <form method="POST" style="margin: 0;">
                        <input type="hidden" name="user_id" value="<?= $u['user_id'] ?>">
                        <select name="m_level">
                            <?php foreach ($roles_options as $role): ?>
                                <option value="<?= $role ?>" <?= ($u['m_level'] == $role) ? 'selected' : '' ?>>
                                    <?= ucfirst($role) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="update_role">บันทึก</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>