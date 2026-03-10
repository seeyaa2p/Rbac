<?php
session_start();
require_once 'db_connect.php';

// 1. ตรวจสอบสิทธิ์ admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_account'] !== 'admin') {
    header("location: index.php");
    exit;
}

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
                <a href="admin.php"><button type="button"><h3>Back</h3></button></a>
                <form action="export_logs.php" method="POST" style="display:inline;">
                    <button type="submit" name="download_json"><h3>Download (JSON)</h3></button>
                </form>
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
                
                <?php 
                    $display_target = $row['target_name']; // ดึงชื่อมาจากฐานข้อมูลก่อน
                    $display_action = $row['action'];      // ดึงข้อความรายละเอียดมาก่อน

                    //  กรณี "เปลี่ยนสิทธิ์" (UPDATE)
                    if ($row['action_type'] === 'UPDATE' && !empty($display_target)) {
                        $display_action = preg_replace('/รหัส\s*\d+/', 'ชื่อ ' . $display_target, $display_action);
                    }
                    
                    //  กรณี "ลบผู้ใช้" (DELETE)
                    if ($row['action_type'] === 'DELETE' && empty($display_target)) {
                        if (preg_match('/ลบผู้ใช้งานชื่อ:\s*(.*)/', $display_action, $matches)) {
                            $display_target = $matches[1];
                        } elseif (preg_match('/ลบผู้ใช้งาน(รหัส\s*\d+)/', $display_action, $matches)) {
                            $display_target = $matches[1];
                        }
                    }

                    //  กรณี "สมัครสมาชิกใหม่" (CREATE) - ดักจับเอาชื่อมาใส่ Target!
                    if ($row['action_type'] === 'CREATE' && empty($display_target)) {
                        // ค้นหาข้อความที่อยู่หลังคำว่า "สมัครสมาชิกใหม่ชื่อ: "
                        if (preg_match('/สมัครสมาชิกใหม่ชื่อ:\s*(.*)/', $display_action, $matches)) {
                            $display_target = $matches[1];
                        }
                    }

                    // จัดการกรณีที่หาข้อมูลใครไม่ได้เลยจริงๆ ให้เป็นขีด -
                    if (empty($display_target)) {
                        $display_target = '-';
                    }
                ?>

                <tr>
                    <td><?php echo $row['timestamp']; ?></td>
                    <td><font size="4"><?php echo htmlspecialchars($row['admin_name'] ?? 'System'); ?></font></td>
                    <td><font size="3" color="black"><?php echo htmlspecialchars($row['action_type']); ?></font></td>
                    
                    <td><?php echo htmlspecialchars($display_action); ?></td>
                    
                    <td><font size="4"><?php echo htmlspecialchars($display_target); ?></font></td>
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