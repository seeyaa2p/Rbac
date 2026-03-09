<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db.secOps";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed" . mysqli_connect_error());
    } 

    // ปรับให้รับค่า $action_type เพื่อลงตารางได้ตรงช่อง
    function log_action($conn, $user_id, $action, $action_type, $target_id = null, $status = 'success') {
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        
        $sql = "INSERT INTO audit_logs (user_id, action, action_type, target_id, ip_address, user_agent, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        // "issssss" คือประเภทข้อมูล: int, string, string, string, string, string, string
        $stmt->bind_param("issssss", $user_id, $action, $action_type, $target_id, $ip_address, $user_agent, $status);
        $stmt->execute();
    }
?>