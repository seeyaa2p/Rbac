<?php
session_start();
$open_connect = 1;
require('db_connect.php');

$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$m_level = $_POST['m_level'];

if (!empty($username) && !empty($password) && !empty($name) && !empty($m_level)) {
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT username FROM user WHERE username = ? LIMIT 1";
     $INSERT = "INSERT INTO user (username, password, name, m_level) VALUES (?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $username);
     $stmt->execute();
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssss", $username, $hashedPassword, $name, $m_level);
      $stmt->execute();
      echo "บันทึกข้อมูลเรียบร้อย";
     } else {
      echo "ชื่อผู้ใช้นี้ถูกใช้งานแล้ว!!";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All fields are required";
 die();
}
?>