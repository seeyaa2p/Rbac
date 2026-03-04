<?php
session_start();
require('db_connect.php');

// ตรวจสอบสิทธิ์: ต้องล็อกอิน และต้องมีระดับเป็น 'admin' เท่านั้น 
if (!isset($_SESSION['user_id']) || $_SESSION['role_account'] !== 'admin') {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้'); window.location.href='index.php';</script>";
    exit();
}

// ดึงข้อมูลประวัติทั้งหมด เรียงจากล่าสุดไปเก่าสุด
$sql = "SELECT * FROM audit_logs ORDER BY timestamp DESC"; 
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard - Audit Logs</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        .btn-container { text-align: center; margin-bottom: 20px; }
        .btn { padding: 10px 15px; color: white; text-decoration: none; border-radius: 5px; margin: 0 5px; }
        .btn-logout { background-color: #ff4d4d; }
        .btn-export { background-color: #4CAF50; }
    </style>
</head>
<body>
    <h1 style="text-align: center;">ระบบจัดการหลังบ้าน (Audit Logs)</h1>
    
    <div class="btn-container">
        <a href="index.php?logout=1" class="btn btn-logout"> ออกจากระบบ</a>
        <a href="export_logs.php" class="btn btn-export"> Export to JSON</a>
    </div>

    <table>
        <tr>
            <th>Log ID</th>
            <th>User ID</th>
            <th>รายละเอียด (Action)</th>
            <th>เวลา (Timestamp)</th>
        </tr>
        
        <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['log_id'] . "</td>"; 
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['action'] . "</td>";
                echo "<td>" . $row['timestamp'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>ยังไม่มีข้อมูลประวัติการใช้งาน</td></tr>";
        }
        ?>
    </table>
</body>
</html>