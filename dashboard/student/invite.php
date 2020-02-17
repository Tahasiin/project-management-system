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

$success = "";
$warning = "";
$alert = "";

if (isset($_POST['invite'])) {
    $request_to = $_POST['studentID'];
    $request_from = $_SESSION['student_id'];

    $check = "SELECT `request_from`, `request_to` FROM `requests` WHERE request_from = '$request_from' AND request_to = '$request_to'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $alert = "You have already sent a request to him/her!";
    } else {
        $sql = "INSERT INTO `requests`(`request_from`, `request_to`) VALUES ('$request_from','$request_to')";

        if ($conn->query($sql) === TRUE) {
            $success = "Your request submitted successfully!";
        } else {
            $warning = "Sorry! Request can't be sent!";
        }
    }
}
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
                height: 500px;
                overflow: auto;
                margin-right: 4%;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                font-family: 'Cairo', sans-serif;

            }

            th{
                background: #dddddd;
            }
            td, th {
                border: 1px solid #dddddd;
                height: 25px;
                text-align: center !important
            }

            tr:nth-child(even) {
                background-color: #dddddd;
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
            h5{
                text-align: center
            }
        </style>
    </head>
    <body>

        <div class="sidebar">
            <a><img src="../../gallery/logo.png"></a>
            <a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            <?php
            $sql = "SELECT `id` FROM `registration` WHERE student_id = '$id' AND status = '1' ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                ?>
                <a href="team.php"><i class="fa fa-fw fa-users"></i>Team</a>
                <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a>

            <?php } else { ?>
                <a href="requests.php"><i class="fa fa-fw fa-envelope"></i>Requests[<span id="count"></span>]</a>
                <a href="invite.php"  class="active"> <i class="fa fa-fw fa-phone"></i>Invite</a>
                <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a>

            <?php } ?>
        </div>



        <div class="main">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="text-align: center;"><u>PROJECT MANAGEMENT SYSTEM</u><br>
                        <a href="update.php" onclick="return alert(this);" style="color:red">Create individual project?</a>
                    </h3>
                </div>
            </div>
            <script type="text/javascript">
                function alert(node) {
                    return confirm("#NOTICE: ARE YOY SURE? IF YOU CLICK OK, YOU CAN'T BUILD OR JOIN A TEAM ANYMORE. AND IT CAN'T BE UNDONE!");
                }
            </script>
            <div class="row">
                <div class="col-sm-12">
                    <div class="data-table">
                        <br>
                        <br>
                        <p><input id="myInput" type="text" placeholder="Search..">
                            <span style="color:green"><?php echo $success; ?></span><span style="color:red"><?php
                                echo $warning;
                                echo $alert;
                                ?></span>
                        </p>
                        <br>
                        <h5><u>Available Student Table </u>[ <a href="invite.php">Refresh</a> ]</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php
                                $i = 1;

                                $sql = "SELECT `student_name`, `student_id`, `email`, `contact` FROM `registration` WHERE student_id != '$id' AND status != '1' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php
                                                echo $i++
                                                ?></td>
                                            <td><?php echo $row['student_id'] ?></td>
                                            <td><?php echo $row['student_name'] ?></td>
                                            <td>
                                                <form method="POST" action="">
                                                    <input type="hidden" value="<?php echo $row['student_id'] ?>" name="studentID"/>
                                                    <a href="#ex1" rel="modal:open"><button>Profile</button></a>||
                                                    <?php
                                                    $request_to = $row['student_id'];
                                                    $check = "SELECT `request_from` FROM `requests` WHERE request_from='$id' AND request_to='$request_to' ";
                                                    $output = $conn->query($check);
                                                    if ($output->num_rows > 0) {
                                                        echo '<button disabled style="color:red">Requested</button>';
                                                    } else {
                                                        echo '<button type="submit" name="invite">Request</button>';
                                                    }
                                                    ?>

                                                </form>
                                            </td>
                                        </tr>

                                    <div id="ex1" class="modal" style="height: 400px;width: 20%;text-align: center">
                                        <h4>Student Profile</h4>
                                        <br>
                                        <span style="color:blue">Name:</span>
                                        <p><?php echo $row['student_name'] ?></p>
                                        <span style="color:blue">Student ID:</span>
                                        <p><?php echo $row['student_id'] ?></p>
                                        <span style="color:blue">Email:</span>
                                        <p><?php echo $row['email'] ?></p>
                                        <span style="color:blue">Contact:</span>
                                        <p><?php echo $row['contact'] ?></p>
                                        <br>
                                        <a href="#" rel="modal:close" style="color: red">Close</a>
                                    </div>

                                    <?php
                                }
                            } else {
                                echo '<tr><td style="color:red;text-align:center" colspan="4">No Registered Student Found!</td></tr>';
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>



            </div>
        </div>

    </body>
</html> 
<?php
$conn->close();
?>

