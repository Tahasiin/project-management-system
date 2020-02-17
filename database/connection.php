<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "pms";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

mysqli_query($conn,'SET CHARACTER SET utf8'); 
mysqli_query($conn,"SET SESSION collation_connection ='utf8_general_ci'");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>
