<?php
session_start();
require('db_connect.php');

// 1. ตรวจสอบว่าล็อกอินหรือยัง
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

// ระบบ Logout
if(isset($_GET['logout'])){ 
    session_destroy();
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. ดึงข้อมูลส่วนตัวของผู้ใช้ปัจจุบัน
$query_user = "SELECT * FROM user WHERE user_id = '$user_id'";
$res_user = mysqli_query($conn, $query_user);
$user_data = mysqli_fetch_assoc($res_user);

// 3. ดึงประวัติ "เฉพาะที่เกี่ยวกับเรา" (target_id = ตัวเรา)
// เราจะ JOIN เพื่อดูว่า Admin คนไหนเป็นคนจัดการข้อมูลให้เรา
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
    <style>
        body { font-family: 'Tahoma', sans-serif; background-color: #f0f2f5; padding: 20px; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 900px; margin: auto; }
        .user-header { border-bottom: 2px solid #007bff; padding-bottom: 15px; margin-bottom: 20px; position: relative; }
        .logout-link { position: absolute; top: 0; right: 0; color: #dc3545; text-decoration: none; font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: left; }
        th { background-color: #e9ecef; color: #495057; }
        tr:hover { background-color: #f8f9fa; }
        
        .status-tag { padding: 4px 10px; border-radius: 20px; font-size: 0.85em; background: #007bff; color: white; }
    </style>
</head>
<body>

<div class="card">
    <div class="user-header">
        <a href="index.php?logout=1" class="logout-link"> ออกจากระบบ</a>
        <h2>สวัสดีคุณ <strong><?php echo htmlspecialchars($user_data['name']); ?></strong> </h2>
        <p>คุณกำลังใช้งานในสิทธิ์: <span class="status-tag"><?php echo $user_data['m_level']; ?></span></p>
    </div>

    <h3> ประวัติการดำเนินการกับบัญชีของคุณ</h3>
    <p><small>* แสดงเฉพาะข้อมูลที่ผู้ดูแลระบบดำเนินการกับบัญชีของคุณเท่านั้น</small></p>

    <table>
        <thead>
            <tr>
                <th>วัน-เวลา </th>
                <th>ดำเนินการโดย </th>
                <th>รายละเอียดกิจกรรม </th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result_logs) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result_logs)): ?>
                <tr>
                    <td><?php echo $row['timestamp']; ?></td>
                    <td><strong><?php echo htmlspecialchars($row['admin_name'] ?? 'System'); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['action']); ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center; padding: 30px; color: #6c757d;">
                        ยังไม่มีประวัติการดำเนินการในบัญชีของคุณ
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>