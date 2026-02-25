<?php
ob_start();
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  $host = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "website";

  // Create connection
  $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
  
  // Check connection
  if ($conn->connect_error) {
    die('Connect Error: ' . $conn->connect_error);
  }

  // ค้นหาผู้ใช้ในฐานข้อมูล (ใช้ Prepared Statement)
  $sql = "SELECT username, password FROM user WHERE username = ?";
  $stmt = $conn->prepare($sql);
  
  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }
  
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    // ผู้ใช้พบในฐานข้อมูล
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

      // ตรวจสอบรหัสผ่าน
      if (password_verify($password, $hashed_password)) {
        // รหัสผ่านถูกต้อง
        $_SESSION['username'] = $username;

        ob_end_clean();
        header("Location: index.html");
        exit();
    } else {
      // รหัสผ่านไม่ถูกต้อง
      echo "Invalid password.";
    }
  } else {
    // ไม่พบผู้ใช้ในฐานข้อมูล
    echo "No user found with that username.";
  }

  $stmt->close();
  $conn->close();

}
?>