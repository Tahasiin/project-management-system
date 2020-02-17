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

if (isset($_POST['accept'])) {

    $request_to = $_SESSION['student_id'];
    $request_from = $_POST['studentID'];

    $sql = "UPDATE `requests` SET `status`='1' WHERE request_to = '$request_to' AND request_from = '$request_from'";

    if ($conn->query($sql) === TRUE) {
        $sql = "DELETE FROM `requests` WHERE request_to = '$request_to' AND status = '0' OR request_from='$request_to' ";

        if ($conn->query($sql) === TRUE) {

            $sql = "UPDATE `registration` SET `request_id`='$request_from',`type`='member',`status`='1' WHERE student_id = '$request_to'";
            if ($conn->query($sql) === TRUE) {
                $sql = "UPDATE `registration` SET `request_id`='$request_from',`type`='leader' WHERE student_id = '$request_from'";
                if ($conn->query($sql) === TRUE) {

                    $sql = "UPDATE `registration` SET `request_id`='$request_from',`type`='member',`status`='1' WHERE request_id = '$request_to' AND type='member'";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>window.location.href = 'team.php';</script>";
                    } else {
                        echo "Error updating registration: " . $conn->error;
                    }
                    
                } else {
                    echo "Error updating registration: " . $conn->error;
                }
            } else {
                echo "Error updating registration: " . $conn->error;
            }
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

if (isset($_POST['delete'])) {
    $rowid = $_POST['id'];
    $sql = "DELETE FROM `requests` WHERE id = '$rowid' ";

    if ($conn->query($sql) === TRUE) {
        header('location:requests.php');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


$query = "SELECT COUNT(id) FROM `registration` WHERE request_id = '$id' AND status = '1'";
$result = mysqli_query($conn, $query);
$rows = mysqli_fetch_row($result);
$count = $rows[0];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../gallery/logo.png" type="image/png"/>
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
                overflow: auto
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

            button[name="profile"]{
                background: none;outline: none;border:none;color:blue;
            }
            button[name="accept"]{
                background: none;outline: none;border:none;color:green;
            }
            button[name="delete"]{
                background: none;outline: none;border:none;color:red;
            }

            span{
                color:yellow
            }
            h5{
                text-align: center;

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
                <a href="requests.php"  class="active"><i class="fa fa-fw fa-envelope"></i>Requests[<span id="count"></span>]</a>
                <a href="invite.php"><i class="fa fa-fw fa-phone"></i>Invite</a>
                <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a>

            <?php } ?>
        </div>

        <?php
        $redirect = "";
        if ($count >= 2) {
            $sql = "UPDATE `requests` SET `status`='1' WHERE request_to = '$id' ";

            if ($conn->query($sql) === TRUE) {
                $sql = "DELETE FROM `requests` WHERE request_to = '$id' AND status = '0' OR request_from='$id' AND status ='0'";

                if ($conn->query($sql) === TRUE) {

                    $sql = "UPDATE `registration` SET `status`='1' WHERE student_id = '$id'";
                    if ($conn->query($sql) === TRUE) {
                        $redirect = '<h4 style="text-align: center;color:blue">Your team has been built.You will be redirected in...<div id="countdown" style="color:red"></div></h4>';
                    } else {
                        echo "Error updating registration: " . $conn->error;
                    }
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        ?>

        <div class="main">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="text-align: center;"><u>PROJECT MANAGEMENT SYSTEM</u></h3>
                    <?php
                    echo $redirect;

                    if ($count === '1') {
                        echo '<center><h4 style="color:red">You have got one team member. <a href="update.php" onclick="return alert(this);">Create</a> 2 membered team?</h4></center>';
                    } else {
                        
                    }
                    ?>
                    <script type="text/javascript">
                        function alert(node) {
                            return confirm("#NOTICE: ARE YOY SURE? IF YOU CLICK OK, YOU WON'T BE ABLE TO ADD ANY OTHER MEMBER IN YOUR TEAM ANYMORE. AND IT CAN'T BE UNDONE!");
                        }
                    </script>
                </div>
            </div>
            <p>
                <span style="color:green"><?php echo $success; ?></span>
                <span style="color:red"><?php echo $warning; ?></span>
                <span style="color:red"><?php echo $alert; ?></span>
            </p>

            <div class="row">
                <div class="col-sm-6">
                    <div class="data-table">
                        <br>
                        <br>
                        <br>
                        <h5><u>Received Requests </u>[ <a href="requests.php">Refresh</a> ]</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Request Form</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php
                                $i = 1;
                                $sql = "SELECT `id`,`request_from` FROM `requests` WHERE request_to = '$id' AND status = '0' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $row['request_from'] ?></td>
                                            <td>
                                                <form method="POST" action="">
                                                    <input type="hidden" value="<?php echo $row['request_from'] ?>" name="studentID"/>
                                                    <input type="hidden" value="<?php echo $row['id'] ?>" name="id"/>
                                                    <a href="#ex1" rel="modal:open"><button name="profile">Profile</button></a>||<button type="submit" name="accept" onclick="return confirm('Are you sure?')">Accept</button>||<button type="submit" name="delete" onclick="return confirm('Are you sure?')">Cancel</button>
                                                </form>
                                            </td>
                                        </tr>

                                    <div id="ex1" class="modal" style="height: 400px;width: 20%;text-align: center">
                                        <h4>Student Profile</h4>
                                        <br>
                                        <?php
                                        $sid = $row['request_from'];
                                        $sql2 = "SELECT *FROM `registration` WHERE student_id = '$sid' ";
                                        $result2 = $conn->query($sql2);
                                        if ($result2->num_rows > 0) {
                                            while ($rows = $result2->fetch_assoc()) {
                                                ?>
                                                <span style="color:blue">Name:</span>
                                                <p><?php echo $rows['student_name'] ?></p>
                                                <span style="color:blue">Student ID:</span>
                                                <p><?php echo $rows['student_id'] ?></p>
                                                <span style="color:blue">Email:</span>
                                                <p><?php echo $rows['email'] ?></p>
                                                <span style="color:blue">Contact:</span>
                                                <p><?php echo $rows['contact'] ?></p>
                                                <br>
                                                <a href="#" rel="modal:close" style="color: red">Close</a>
                                                <?php
                                            }
                                        } else {
                                            
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<tr><td style="color:red;text-align:center" colspan="3">No received request found!</td></tr>';
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="data-table">
                        <br>
                        <br>
                        <br>
                        <h5><u>Sent Requests</u>[ <a href="requests.php">Refresh</a> ]</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Request To</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php
                                $i = 1;
                                $sql = "SELECT `id`,`request_to`,`status` FROM `requests` WHERE request_from = '$id'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php
                                                echo $i++
                                                ?></td>
                                            <td><?php echo $row['request_to'] ?></td>
                                            <td>
                                                <?php
                                                if ($row['status'] === '0') {
                                                    echo '<span style="color:red">Not Accepted!</span>';
                                                } else {
                                                    echo '<span style="color:green">Accepted</span>';
                                                }
                                                ?>

                                            </td>
                                            <td>
                                                <form method="POST" action="">
                                                    <input type="hidden" value="<?php echo $row['request_to'] ?>" name="studentID"/>
                                                    <input type="hidden" value="<?php echo $row['id'] ?>" name="id"/>
                                                    <a href="#ex1" rel="modal:open"><button name="profile">Profile</button></a><?php
                                                    if ($row['status'] === '0') {
                                                        echo'|| <button type="submit" name="delete">Remove</button>';
                                                    } else {
                                                        
                                                    }
                                                    ?>
                                                </form>
                                            </td>
                                        </tr>
                                    <div id="ex1" class="modal" style="height: 400px;width: 20%;text-align: center">
                                        <h4>Student Profile</h4>
                                        <br>
                                        <?php
                                        $sid = $row['request_to'];
                                        $sql2 = "SELECT *FROM `registration` WHERE student_id = '$sid' ";
                                        $result2 = $conn->query($sql2);
                                        if ($result2->num_rows > 0) {
                                            while ($rows = $result2->fetch_assoc()) {
                                                ?>
                                                <span style="color:blue">Name:</span>
                                                <p><?php echo $rows['student_name'] ?></p>
                                                <span style="color:blue">Student ID:</span>
                                                <p><?php echo $rows['student_id'] ?></p>
                                                <span style="color:blue">Email:</span>
                                                <p><?php echo $rows['email'] ?></p>
                                                <span style="color:blue">Contact:</span>
                                                <p><?php echo $rows['contact'] ?></p>
                                                <br>
                                                <a href="#" rel="modal:close" style="color: red">Close</a>
                                                <?php
                                            }
                                        } else {
                                            
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<tr><td style="color:red;text-align:center" colspan="4">No Sent/Pending Request Found !</td></tr>';
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var timeleft = 20;
            var downloadTimer = setInterval(function () {
                document.getElementById("countdown").innerHTML = timeleft + " seconds.";
                timeleft -= 1;
                if (timeleft <= 0) {
                    clearInterval(downloadTimer);
                    window.location.href = 'update.php';
                }
            }, 1000);
        </script>

    </body>
</html> 
