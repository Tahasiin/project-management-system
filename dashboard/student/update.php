<?php

if (!isset($_SERVER['HTTP_REFERER'])) {
    header("location:logout.php");
    exit;
}
require '../../database/connection.php';
session_start();

if (!isset($_SESSION["student_id"])) {
    header("location:logout.php");
}

$id = $_SESSION['student_id'];

$sql = "DELETE FROM `requests` WHERE request_to = '$id' AND status='0' OR request_from='$id' AND status='0'";

if ($conn->query($sql) === TRUE) {

    $sql = "UPDATE `registration` SET `request_id`='$id',`type`='leader',`status`='1' WHERE student_id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href = 'team.php';</script>";
    } else {
        echo "Error updating registration: " . $conn->error;
    }
} else {
    echo "Error deleting record: " . $conn->error;
}