<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db.secOps";

    // Create Connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed" . mysqli_connect_error());
    } 

    function log_action($conn, $user_id, $action, $target_id = null, $status = 'success') {
    // ดึง IP Address และข้อมูล Browser ของผู้ใช้อัตโนมัติ
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
    
    $sql = "INSERT INTO audit_logs (user_id, action, target_id, ip_address, user_agent, status) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    // i = integer, s = string
    $stmt->bind_param("isssss", $user_id, $action, $target_id, $ip_address, $user_agent, $status);
    $stmt->execute();
}

?>

