<?php
$servername = "sqlXXX.epizy.com";   
$username   = "epiz_12345678";      
$password   = "yourpassword";       
$dbname     = "epiz_12345678_db";   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
