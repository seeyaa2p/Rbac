<?php
session_start();
$conn = 1;
require('db_connect.php');

if(!isset($_SESSION['id_account']) || !isset($_SESSION['role_account'])){//ถ้าไม่มีเซสชัน id_account หรือเซสชัน role_account จะถูกส่งไปหน้า login
    die(header('Location: login.php'));
}elseif(isset($_GET['logout'])){ //ถ้ามีการกดปุ่มออกจากระบบให้ทำการทำลายเซสชันและส่งไปหน้า login
    session_destroy();
    die(header('Location: login.php'));
}else{
    $id_account = $_SESSION['id_account'];
    $query_show = "SELECT * FROM user WHERE username = '$id_account'";
    $call_back_show = mysqli_query($conn, $query_show);
    $result_show = mysqli_fetch_assoc($call_back_show);
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <title>index</title>
</head>
<body>
    <form action="index.php" method="POST">
    <table>
    <center>
        <h1>ยินดีต้อนรับคุณ <?php echo $result_show['username_account']; ?> ในฐานะ <?php echo $result_show['role_account']; ?></h1>
        <h2><a href="index.php?logout=1">ออกจากระบบ</a></h2>
    </center>
    </table>
</body>
</html>

