<?php
// 1. เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูลของคุณ 
require_once 'connect.php'; 
// หมายเหตุ: โค้ดด้านล่างนี้สมมติว่าตัวแปรเชื่อมต่อ Database ของคุณชื่อ $conn นะครับ

// 2. ตรวจสอบว่ามีการกดปุ่ม "บันทึก" เพื่ออัปเดตสิทธิ์หรือไม่ 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $target_user_id = $_POST['user_id'];
    $new_role_id = $_POST['role_id'];
    
    // คำสั่ง SQL สำหรับอัปเดต role_id ของ user คนนั้น
    $sql = "UPDATE users SET role_id = :role_id WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':role_id' => $new_role_id, ':user_id' => $target_user_id]);
    
    echo "<script>alert('อัปเดตสิทธิ์ผู้ใช้งานสำเร็จ!');</script>";
}

// 3. ดึงข้อมูล User และ Role ทั้งหมดมาแสดงผลในตาราง 
$users_query = $conn->query("SELECT id, username, role_id FROM user");
$users = $users_query->fetchAll(PDO::FETCH_ASSOC);

$roles_query = $conn->query("SELECT id, role_name FROM roles");
$roles = $roles_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการสิทธิ์ผู้ใช้งาน</title>
</head>
<body>
    <h2>จัดการสิทธิ์ผู้ใช้งาน (Role Management)</h2>
    <table border="1" cellpadding="8" style="border-collapse: collapse;">
        <tr style="background-color: #f2f2f2;">
            <th>รหัสผู้ใช้</th>
            <th>ชื่อผู้ใช้</th>
            <th>ตั้งค่าสิทธิ์</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td>
                <form method="POST" style="margin: 0;">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    
                    <select name="role_id">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role['id'] ?>" <?= ($user['role_id'] == $role['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role['role_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="update_role">บันทึก</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>