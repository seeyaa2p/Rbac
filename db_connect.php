<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db.secOps";

    // Create Connection
    $open_connect = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$open_connect) {
        die("Connection failed" . mysqli_connect_error());
    } 

?>