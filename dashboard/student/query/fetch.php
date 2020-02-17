<?php

require '../../../database/connection.php';
session_start();
$id = $_SESSION['student_id'];

$query = "SELECT COUNT(id) FROM `requests` WHERE request_from = '$id' AND status = '1'";
$result = mysqli_query($conn, $query);
$rows = mysqli_fetch_row($result);
echo $rows[0];
