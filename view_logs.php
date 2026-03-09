<?php
// 1. เชื่อมต่อฐานข้อมูล
require_once 'db_connect.php';

// 2. ดึงข้อมูล Log
$sql = "SELECT a.*, 
               u1.username AS admin_name, 
               u2.username AS target_name 
        FROM audit_logs a 
        LEFT JOIN user u1 ON a.user_id = u1.user_id 
        LEFT JOIN user u2 ON a.target_id = u2.user_id 
        ORDER BY a.timestamp DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการใช้งานระบบ</title>
</head>
<body bgcolor="#f8f9fa">

<div align="center">
    <h2><font color="#333333">ประวัติการใช้งานระบบ</font></h2>

    <table border="0" width="90%">
        <tr>
            <td align="left">
                <a href="admin.php"><button><h3>ย้อนกลับไปหน้าหลักแอดมิน</h3></button></a>
            </td>
        </tr>
    </table>
    <br>
    
    <table border="1" width="90%" cellpadding="10" cellspacing="0" bgcolor="#ffffff">
        <thead>
            <tr bgcolor="#007bff">
                <th width="15%"><font color="#ffffff">วัน-เวลา</font></th>
                <th width="15%"><font color="#ffffff">ผู้กระทำ</font></th>
                <th width="15%"><font color="#ffffff">ประเภท</font></th>
                <th width="15%"><font color="#ffffff">รายละเอียด</font></th>
                <th width="15%"><font color="#ffffff">Target</font></th>
                <th width="15%"><font color="#ffffff">IP Address</font></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['timestamp']; ?></td>
                    <td><font size="4"><?php echo htmlspecialchars($row['admin_name'] ?? 'System'); ?></font></td>
                    
                    <td><font size="3" color="black"><?php echo htmlspecialchars($row['action_type']); ?></font></td>
                    
                    <td><?php echo htmlspecialchars($row['action']); ?></td>
                    <td><font size="4"><?php echo htmlspecialchars($row['target_name'] ?? '-'); ?></font></td>
                    <td><small><?php echo $row['ip_address']; ?></small></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" align="center">ยังไม่มีบันทึกข้อมูล</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>