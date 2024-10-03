<?php
$hostname = "4.242.16.222"; 
$username = "Gio"; 
$password = "Gio123"; 
$database = "sensor_db"; 

$conn = mysqli_connect($hostname, $username, $password, $database, 3306);

if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error()); 
} 
?>
