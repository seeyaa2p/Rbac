<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role_account'] !== 'admin') {
    header("location: index.php");
    exit;
}

// ดึง notices ทั้งหมด (active)
$result_notices = $conn->query("SELECT * FROM notices WHERE is_active = 1 ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>SecOps Alerts</title>
</head>
<body bgcolor="#f8f9fa">

<br>

<div align="center">
    <h2><font color="#333333">การแจ้งเตือนจาก Google SecOps</font></h2>

    <table border="0" width="90%">
        <tr>
            <td align="left">
                <a href="admin.php"><button type="button"><h3>Back</h3></button></a>
            </td>
        </tr>
    </table>

    <br>

    <table border="1" width="90%" cellpadding="10" cellspacing="0" bgcolor="#ffffff">
        <thead>
            <tr bgcolor="#ffc107">
                <th width="10%"><font color="#333">ประเภท</font></th>
                <th width="65%"><font color="#333">ข้อความแจ้งเตือน</font></th>
                <th width="25%"><font color="#333">วัน-เวลา</font></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_notices && $result_notices->num_rows > 0): ?>
                <?php $i = 0; while($n = $result_notices->fetch_assoc()): $i++; ?>
                <tr <?php echo ($i % 2 === 0) ? 'bgcolor="#f2f2f2"' : ''; ?>>
                    <td align="center">
                        <?php
                        $color = match($n['type']) {
                            'error'   => '#dc3545',
                            'success' => '#28a745',
                            'info'    => '#17a2b8',
                            default   => '#ff3300',
                        };
                        ?>
                        <font color="<?php echo $color; ?>"><b><?php echo htmlspecialchars(strtoupper($n['type'])); ?></b></font>
                    </td>
                    <td align="left"><?php echo htmlspecialchars($n['message']); ?></td>
                    <td><?php echo $n['created_at']; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" align="center"><font color="#666">ไม่มีการแจ้งเตือน</font></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<br>

</body>
</html>