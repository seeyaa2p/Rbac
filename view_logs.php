<?php
// 1. เชื่อมต่อฐานข้อมูล
require_once 'db_connect.php';

// 2. ดึงข้อมูล Log พร้อม JOIN เพื่อเอาชื่อ "ผู้กระทำ" และ "ผู้ถูกกระทำ"
// u1 = ผู้กระทำ (admin), u2 = ผู้ถูกกระทำ (target)
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
    <style>
        body { font-family: 'Tahoma', sans-serif; background-color: #f8f9fa; padding: 20px; }
        .container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 1100px; margin: auto; }
        h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 20px; }
        
        /* ปุ่มย้อนกลับด้านบน 🔝 */
        .btn-back { 
            display: inline-block; 
            padding: 10px 20px; 
            background-color: #6c757d; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            transition: 0.3s; 
        }
        .btn-back:hover { background-color: #5a6268; }

        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; color: white; font-weight: bold; }
        .UPDATE { background-color: #ffc107; color: #212529; }
        .DELETE { background-color: #dc3545; }
        .CREATE { background-color: #28a745; }
    </style>
</head>
<body>

<div class="container">
    <h2> ประวัติการใช้งานระบบ </h2>

    <a href="admin.php" class="btn-back">⬅ ย้อนกลับไปหน้าหลักแอดมิน</a>
    
    <table>
        <thead>
            <tr>
                <th>วัน-เวลา </th>
                <th>ผู้กระทำ </th>
                <th>ประเภท </th>
                <th>รายละเอียด </th>
                <th>ผู้ถูกกระทำ (Target) </th>
                <th>IP Address </th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['timestamp']; ?></td>
                    <td><strong><?php echo htmlspecialchars($row['admin_name'] ?? 'System'); ?></strong></td>
                    <td><span class="badge <?php echo $row['action_type']; ?>"><?php echo $row['action_type']; ?></span></td>
                    <td><?php echo htmlspecialchars($row['action']); ?></td>
                    <td><?php echo htmlspecialchars($row['target_name'] ?? '-'); ?></td>
                    <td><small><?php echo $row['ip_address']; ?></small></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">ยังไม่มีบันทึกข้อมูล</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>