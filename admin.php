<?php
session_start(); 
require_once 'db_connect.php'; 

// 1. ตรวจสอบสิทธิ์ (Security Check)
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

$current_logged_in_user = $_SESSION['user_id'];
$current_username = $_SESSION['username'] ?? 'Admin';

// 2. จัดการการลบผู้ใช้งาน  (ส่วนที่เพิ่มเข้ามาใหม่)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $target_delete_id = $_POST['delete_id'];
    
    // ป้องกันแอดมินเผลอลบบัญชีของตัวเอง
    if ($target_delete_id != $current_logged_in_user) {
        $sql_delete = "DELETE FROM user WHERE user_id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $target_delete_id); 
        
        if ($stmt_delete->execute()) {
            $action_detail = "ลบผู้ใช้งานรหัส $target_delete_id";
            
            // บันทึกประวัติลง audit_logs
            log_action($conn, $current_logged_in_user, $action_detail, 'DELETE', $target_delete_id, 'success');
            
            echo "<script>alert('ลบผู้ใช้งานสำเร็จ!'); window.location.href='admin.php';</script>";
            exit;
        }
    }
}

// 3. จัดการการอัปเดตสิทธิ์
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $target_user_id = $_POST['user_id'];
    $new_m_level = $_POST['m_level']; 
    
    $sql = "UPDATE user SET m_level = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_m_level, $target_user_id); 
    
    if ($stmt->execute()) {
        $action_detail = "เปลี่ยนสิทธิ์ผู้ใช้รหัส $target_user_id เป็น $new_m_level";
        log_action($conn, $current_logged_in_user, $action_detail, 'UPDATE', $target_user_id, 'success');
        
        echo "<script>alert('อัปเดตสิทธิ์สำเร็จ!'); window.location.href='admin.php';</script>";
        exit;
    }
}

// 4. ดึงข้อมูลผู้ใช้ (ยกเว้นตัวเอง)
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
</head>
<body bgcolor="#f8f9fa">

    <table border="0" width="100%" bgcolor="#333333" cellpadding="15" cellspacing="0">
    <tr>
        <td align="left" width="33%">
            <a href="index.php"><font color="#ffffff">Home Page</font></a> &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="view_logs.php"><font color="#ffffff">History Page</font></a>
        </td>
        <td align="right" width="33%">
            <a href="logout.php" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่?')">
                <b><font color="#ff5252">Logout</font></b>
            </a>
        </td>
    </tr>
    </table>

    <br>

    <table border="0" width="95%" align="center">
        <tr>
            <td>
                <h2><font color="#333333">จัดการสิทธิ์และผู้ใช้งาน</font></h2>
                <h3><p><font color="#333333">สวัสดีคุณ: <b><?= htmlspecialchars($current_username) ?></b></font></p></h3>

                <table border="1" cellpadding="10" cellspacing="0" width="100%" bgcolor="#ffffff">
                    <tr bgcolor="#eeeeee">
                        <th width="10%"><font color="#333333">รหัส</font></th>
                        <th width="12%"><font color="#333333">ชื่อผู้ใช้</font></th>
                        <th width="15%"><font color="#333333">ชื่อ-สกุล</font></th>
                        <th width="12%"><font color="#333333">สิทธิ์ปัจจุบัน</font></th>
                        <th width="15%"><font color="#333333">แก้ไขสิทธิ์</font></th>
                        <th width="10%"><font color="#333333">จัดการ</font></th> </tr>
                    
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td align="center"><font size="4"><?= $u['user_id'] ?></font></td>
                        <td><font size="4"><?= htmlspecialchars($u['username']) ?></font></td>
                        <td><font size="4"><?= htmlspecialchars($u['name']) ?></font></td>
                        <td align="center"><b><font size="4" color="#040404"><?= htmlspecialchars($u['m_level']) ?></font></b></td>
                        
                        <td align="center">
                            <form method="POST">
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
                        
                        <td align="center">
                            <form method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบผู้ใช้งาน <?= htmlspecialchars($u['username']) ?> ?\nข้อมูลที่ถูกลบจะไม่สามารถกู้คืนได้!');">
                                <input type="hidden" name="delete_id" value="<?= $u['user_id'] ?>">
                                <button type="submit" name="delete_user"><font color="#dc3545"><b>ลบ</b></font></button>
                            </form>
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>