<?php

//constructing database connection
require '../database/connection.php';
session_start();

if (isset($_SESSION["student_id"])) {
    header("location:../dashboard/student/index.php");
}
$warning = '';
//login function
if (isset($_POST['login'])) {

    $id = $_POST['studentID'];
    $password = $_POST['password'];

    $sql = "SELECT `student_id`,`password` FROM `registration` WHERE student_id = '$id' AND password = '$password'";
    $result = $conn->query($sql);
//        if login details are correct
    if ($result->num_rows > 0) {
        $_SESSION['student_id'] = $id;
        header('location: ../dashboard/student/index.php');
    } else {
        $warning = "<b>SORRY ! INCORRECT LOGIN DETAILS!</b>";
    }
}
?>