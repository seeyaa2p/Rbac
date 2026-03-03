<?php
session_start();
require('db_connect.php');

// ถ้าไม่มี Session ให้กลับไปหน้า Login
if(!isset($_SESSION['id_account'])){
    header('Location: login.php');
    exit();
}

// ถ้ามีการกดออกจากระบบ
if(isset($_GET['logout'])){ 
    session_destroy();
    header('Location: login.php');
    exit();
}

$id_account = $_SESSION['id_account'];
$query_show = "SELECT * FROM user WHERE id_account = '$id_account'";
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
        <h2><a href="index.php?logout=1">ออกจากระบบ</a></h2>
    </center>
</body>
</html>