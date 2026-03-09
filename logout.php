<?php 
    session_start();
    require_once 'db_connect.php'; 

    if(isset($_SESSION['user_id'])) {
        // บันทึก Log ก่อนล้าง Session
        log_action($conn, $_SESSION['user_id'], 'ออกจากระบบ', 'LOGOUT');
    }

    session_unset();
    session_destroy();
    header('location: login.php');
?>