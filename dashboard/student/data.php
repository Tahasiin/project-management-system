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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../gallery/logo.png" type="image/png"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <script src="js/scripts.js"></script>
        <script>
            $(document).ready(function () {
                $("#myInput").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>
        <script>
            history.pushState(null, null, null);
            window.addEventListener('popstate', function () {
                history.pushState(null, null, null);
            });
        </script>
        <style>
            body {font-family: 'Cairo', sans-serif;}

            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                font-family: 'Cairo', sans-serif;


            }

            th{
                background: blueviolet;
            }
            td, th {
                border: 1px solid #dddddd;
                height: 25px;
                text-align: center !important
            }


            ::-webkit-scrollbar {
                display: none;
            }


        </style>
    </head>
    <body>
        <div class="container">
            <center>
                <img src="../../gallery/logo.png" style="height: 100px;width: 100px"/>
            </center>
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="text-align: center;"><u>PROJECT MANAGEMENT SYSTEM</u><br></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    $sql = "SELECT `project_id` FROM `teams` WHERE student_id = '$id' ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $project_id = $row['project_id'];
                            $sql = "SELECT *FROM `teams` WHERE project_id = '$project_id' ";

                            $result = $conn->query($sql);
                            ?>

                            <table class="table-bordered table-dark">
                                <h4 style="text-align: center;color:blue;margin-top: 5%"><u>Team Project Data</u></h4>
                                <thead>
                                    <tr>
                                        <th>Project ID</th>
                                        <th>Supervisor1</th>
                                        <th>Supervisor2</th>
                                        <th>Supervisor3</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Cell</th>
                                        <th>Project_Title</th>
                                        <th>Project Area</th>
                                        <th>Shift</th>
                                        <th>Project/Intern</th>
                                    </tr>

                                </thead>
                                <tbody id="myTable">
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['project_id'] ?></td>
                                                <td><?php echo $row['supervisor1'] ?></td>
                                                <td><?php echo $row['supervisor2'] ?></td>
                                                <td><?php echo $row['supervisor3'] ?></td>
                                                <td><?php echo $row['student_id'] ?></td>
                                                <td><?php echo $row['student_name'] ?></td>
                                                <td><?php echo $row['student_email'] ?></td>
                                                <td><?php echo $row['student_phone'] ?></td>
                                                <td><?php echo $row['project_title'] ?></td>
                                                <td><?php echo $row['interested_area'] ?></td>
                                                <td><?php echo $row['shift'] ?></td>
                                                <td><?php echo $row['type'] ?></td>
                                            </tr>

                                            <?php
                                        }
                                    } else {
                                        echo '<center><h1 style="color:red">NO REQUEST RECEIVED YET!</h1></center>';
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <center style="margin-top: 15%">
                                <h3><u><b><a href="index.php" style="color:green">RETURN TO DASHBOARD</a></b></u></h3>
                                <h3><u><b><a href="logout.php" style="color:red">Logout &nbsp;<i class="fa fa-sign-out"></i></a></b></u></h3>
                            </center>

                            <?php
                        }
                    } else {
                        echo '<center><h1 style="color:red">NO DATA FOUND!</h1></center>';
                        echo '<center>
                                 <h4><u><b><a href="index.php" style="color:red">RETURN TO DASHBOARD</a></b></u></h4>
                              </center>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </body>
</html> 




