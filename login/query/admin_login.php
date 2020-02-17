<?php

//constructing database connection
require '../database/connection.php';
session_start();

if (isset($_SESSION["admin_id"])) {
    header("location:../dashboard/admin/index.php");
}

$warning = '';
//login function
if (isset($_POST['login'])) {

    $id = $_POST['adminID'];
    $password = $_POST['password'];

    $sql = "SELECT `admin_id`,`password` FROM `admin` WHERE admin_id = '$id' AND password = '$password'";
    $result = $conn->query($sql);
//        if login details are correct
    if ($result->num_rows > 0) {
        $_SESSION['admin_id'] = $id;
        header('location: ../dashboard/admin/index.php');
    } else {
        $warning = "<b>SORRY ! INCORRECT LOGIN DETAILS!</b>";
    }
}
?>