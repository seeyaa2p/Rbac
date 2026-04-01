<?php
session_start();
require_once 'db_connect.php';

// 1. ตรวจสอบว่าเข้าสู่ระบบหรือยัง 
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

// 2. ดึงรหัสผู้ใช้งานปัจจุบันจาก Session
$current_user_id = $_SESSION['user_id'];

// 3. ค้นหาข้อมูลของผู้ใช้งานคนนี้จากฐานข้อมูล 
$sql = "SELECT user_id, username, name, m_level FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

// นำข้อมูลมาเก็บไว้ในตัวแปร $user_data
$user_data = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าแรก - โปรไฟล์ส่วนตัว</title>
</head>
<body bgcolor="#f8f9fa">

    <table border="0" width="100%" bgcolor="#333333" cellpadding="15" cellspacing="0">
        <tr>
            <td align="left" width="50%">
                <font color="#ffffff"><b>Rbac</b></font>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php if ($_SESSION['role_account'] === 'admin'): ?>
                    <a href="admin.php"><font color="#ffffff"><b>Admin Page</b></font></a> 
                <?php endif; ?>
            </td>
            
            <td align="right" width="50%">
                <a href="logout.php" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่?')">
                    <b><font color="#ff0000">ออกจากระบบ</font></b>
                </a>
            </td>
        </tr>
    </table>

    <br>

    <div align="center">
        <h2><font color="#333333">ยินดีต้อนรับ, <?php echo htmlspecialchars($user_data['name']); ?></font></h2>
        <h3>ข้อมูลส่วนตัวของคุณ</h3>

        <table border="1" cellpadding="15" cellspacing="0" width="60%" bgcolor="#ffffff">
            <tr bgcolor="#007bff">
                <th width="30%"><font color="#ffffff">หัวข้อ</font></th>
                <th width="70%"><font color="#ffffff">รายละเอียด</font></th>
            </tr>
            <tr>
                <td align="right"><b>รหัสประจำตัว (ID):</b></td>
                <td><font size="4"><?php echo $user_data['user_id']; ?></font></td>
            </tr>
            <tr bgcolor="#f2f2f2">
                <td align="right"><b>ชื่อผู้ใช้ (Username):</b></td>
                <td><font size="4"><?php echo htmlspecialchars($user_data['username']); ?></font></td>
            </tr>
            <tr>
                <td align="right"><b>ชื่อ-นามสกุล:</b></td>
                <td><font size="4"><?php echo htmlspecialchars($user_data['name']); ?></font></td>
            </tr>
            <tr bgcolor="#f2f2f2">
                <td align="right"><b>สถานะ/สิทธิ์การใช้งาน:</b></td>
                <td>
                    <b>
                    <?php if ($user_data['m_level'] === 'admin'): ?>
                        <font color="#130103" size="4">Admin</font>
                    <?php else: ?>
                        <font color="#000000" size="4">User</font>
                    <?php endif; ?>
                    </b>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>