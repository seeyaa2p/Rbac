<?php
session_start();
require('db_connect.php');

// เช็คว่ามี Session user_id หรือไม่
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

if(isset($_GET['logout'])){ 
    session_destroy();
    header('Location: login.php');
    exit();
}

// รับค่าจาก Session
$user_id = $_SESSION['user_id'];

// ค้นหาโดยใช้ WHERE user_id
$query_show = "SELECT * FROM user WHERE user_id = '$user_id'";
$call_back_show = mysqli_query($conn, $query_show);
$result_show = mysqli_fetch_assoc($call_back_show);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>หน้าแรก</title>
</head>
<body>
    <center>
        <h1>ยินดีต้อนรับคุณ <?php echo $result_show['name']; ?> ในฐานะ <?php echo $result_show['m_level']; ?></h1>
        <h2><a href="admin.php?logout=1">ออกจากระบบ</a></h2>
    </center>
</body>
</html>