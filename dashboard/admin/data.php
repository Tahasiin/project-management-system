<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    // redirect them to your desired location
    header("location:logout.php");
    exit;
}
require '../../database/connection.php';

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

$id = $_SESSION['admin_id'];
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

            .sidebar {
                height: 100%;
                width: 160px;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: #111;
                overflow-x: hidden;
                padding-top: 16px;
            }

            .sidebar a {
                padding: 6px 8px 6px 16px;
                text-decoration: none;
                font-size: 20px;
                color: #818181;
                display: block;
            }

            .sidebar a:hover {
                color: #f1f1f1;
            }

            .main {
                margin-left: 200px;
                padding: 1px 16px;


            }
            @media screen and (max-width: 700px) {
                .sidebar {
                    width: 100%;
                    height: auto;
                    position: relative;
                }
                .sidebar a {float: left;}
                .main {margin-left: 0;}
            }

            @media screen and (max-width: 400px) {
                .sidebar a {
                    text-align: center;
                    float: none;
                }
            }

            .active{
                color: red !important
            }
            .data-table{
                height: 230px;
                overflow: auto;


            }
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

            img{
                width:100%;
                margin-left:-5px 
            }

            ::-webkit-scrollbar {
                display: none;
            }

            button{
                background: none;outline: none;border:none;color:blue;
            }
            span{
                color:yellow
            }
            h4{
                text-align: center
            }
            @media print {
                #printPageButton {
                    display: none;
                }
            }


            @media print {
                #downloadPageButton {
                    display: none;
                }
            }

            @media print 
            {
                a[href]:after { content: none !important; }
                img[src]:after { content: none !important; }
            }
            @media print { .no_print { display: none; }
            
            @page { size: auto;  margin: 0mm; }
            </style>
        </head>
        <body>

            <div class="container-fluid">
                <center>
                    <img src="../../gallery/logo.png" style="height: 100px;width: 100px"/>
                </center>
                <div class="row">
                    <div class="col-sm-12">
                        <h3 style="text-align: center;"><u>PROJECT MANAGEMENT SYSTEM</u></h3>
                    </div>
                </div>
                <center class="no_print">
                    <form method="post" action="../../team-data.php">
                        <input type="submit" name="export" class="btn btn-success" value="GENERATE EXEL" />
                        <button type="button" class="btn btn-primary" onClick="window.print();"><i class="fa fa-print"></i>PRINT</button>
                    </form>
                </center>
                <div class="row">
                    <div class="col-sm-12">
                        <br>
                        <br>
                        <h4><u>Team Data Table</u>&nbsp;<a href="" class="no_print">Refresh</a></h4>
                        <center class="no_print"><p><input id="myInput" type="text" placeholder="Search.." list="serial"></p></center>
                        <center><small style="color: red">Scroll on the table to show more data. </small></center>
                        <datalist id="serial">
                            <?php
                            $sql = "SELECT project_id FROM `teams`GROUP BY project_id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option><?php echo $row['project_id'] ?></option>
                                    <?php
                                }
                            } else {
                                
                            }
                            ?>

                        </datalist>
                        <div class="data-table">
                            <table class="table-bordered table-dark" id="example">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    <?php
                                    $i = 1;

                                    $sql = "SELECT *FROM `teams`";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['serial_no'] ?></td>
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
                                                <td><?php echo $row['member_type'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td style="color:red;text-align:center" colspan="15">No Request Found!</td></tr>';
                                    }
                                    ?>

                                </tbody>
                            </table>

                        </div>
                        <center class="no_print">
                            <h3><u><b><a href="index.php" style="color:green">RETURN TO DASHBOARD</a></b></u></h3>
                            <h3><u><b><a href="logout.php" style="color:red">Logout &nbsp;<i class="fa fa-sign-out"></i></a></b></u></h3>
                        </center>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#example').DataTable();
                });
            </script>
        </body>
    </html> 
    <?php
    $conn->close();
    ?>

