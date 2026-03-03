<?php
    session_start();
    // คัดลอก 3 บรรทัดนี้ไปวางครับ
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require('db_login.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <div style="text-align: center;">
                <h1>Login</h1>
                <table border="1" style="margin: 0 auto; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 10px;">Username:</td>
                        <td style="padding: 10px;"><input type="text" name="username" required></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Password:</td>
                        <td style="padding: 10px;"><input type="password" name="password" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 10px; text-align: center;"><input type="submit" value="Login"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 10px; text-align: center;"><input type="button" value="Register" onclick="window.location.href='register.php'"></td>
                    </tr>
                </table>
            </div>
        </div>
    </form> 
</body>
</html>