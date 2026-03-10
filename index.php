<?php
session_start();
require('db_connect.php');

// 1. ตรวจสอบว่าล็อกอินหรือยัง
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. ดึงข้อมูลส่วนตัวของผู้ใช้ปัจจุบัน
$query_user = "SELECT * FROM user WHERE user_id = '$user_id'";
$res_user = mysqli_query($conn, $query_user);
$user_data = mysqli_fetch_assoc($res_user);

// 3. ดึงประวัติ "เฉพาะที่เกี่ยวกับเรา" (target_id = ตัวเรา)
$query_logs = "SELECT a.*, u.username AS admin_name 
               FROM audit_logs a 
               LEFT JOIN user u ON a.user_id = u.user_id 
               WHERE a.target_id = '$user_id' 
               ORDER BY a.timestamp DESC";
$result_logs = mysqli_query($conn, $query_logs);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>หน้าแรก - ข้อมูลผู้ใช้งาน</title>
</head>
<body bgcolor="#f0f2f5">

<div align="center">
    <br>
    <table border="0" width="80%" bgcolor="#ffffff" cellpadding="20" cellspacing="0">
        <tr>
            <td>
                <table border="0" width="100%">
                    <tr>
                        <td align="left">
                            <h2><font color="#333333">สวัสดีคุณ <b><?php echo htmlspecialchars($user_data['name']); ?></b></font></h2>
                            <p><font color="#333333">คุณกำลังใช้งานในสิทธิ์: <font color="#007bff"><b><?php echo $user_data['m_level']; ?></b></font></font></p>
                        </td>
                        <td align="right" valign="top">
                            <?php if ($user_data['m_level'] === 'admin'): ?>
                                <a href="admin.php"><font color="#28a745" size="4"><b>จัดการระบบ (Admin)</b></font></a> &nbsp;&nbsp;|&nbsp;&nbsp;
                            <?php endif; ?>
                            
                            <a href="logout.php"><font color="#dc3545" size="4"><b>ออกจากระบบ</b></font></a>
                        </td>
                    </tr>
                </table>
                
                <hr color="#007bff" size="2">

                <h3><font color="#333333">ประวัติการดำเนินการกับบัญชีของคุณ</font></h3>
                <p><font size="2" color="#6c757d">* แสดงเฉพาะข้อมูลที่ผู้ดูแลระบบดำเนินการกับบัญชีของคุณเท่านั้น</font></p>

                <table border="1" width="100%" cellpadding="12" cellspacing="0" bordercolor="#dee2e6">
                    <tr bgcolor="#e9ecef">
                        <th align="left"><font color="#495057">วัน-เวลา</font></th>
                        <th align="left"><font color="#495057">ดำเนินการโดย</font></th>
                        <th align="left"><font color="#495057">รายละเอียดกิจกรรม</font></th>
                    </tr>
                    <?php if (mysqli_num_rows($result_logs) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_logs)): ?>
                        <tr bgcolor="#ffffff">
                            <td><?php echo $row['timestamp']; ?></td>
                            <td><b><?php echo htmlspecialchars($row['admin_name'] ?? 'System'); ?></b></td>
                            <td><?php echo htmlspecialchars($row['action']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr bgcolor="#ffffff">
                            <td colspan="3" align="center">
                                <br><br>
                                <font color="#6c757d">ยังไม่มีประวัติการดำเนินการในบัญชีของคุณ</font>
                                <br><br>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>

            </td>
        </tr>
    </table>
</div>

</body>
</html>