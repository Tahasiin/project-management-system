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
                min-height: 300px;
                overflow: auto;

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
            input{
                width: 100%;
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
                <a href="team.php"  class="active"><i class="fa fa-fw fa-users"></i>Team</a>
                <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a>

            <?php } else { ?>
                <a href="requests.php"><i class="fa fa-fw fa-envelope"></i>Requests[<span id="count"></span>]</a>
                <a href="invite.php" > <i class="fa fa-fw fa-phone"></i>Invite</a>
                <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a>

            <?php } ?>
        </div>



        <div class="main">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="text-align: center;"><u>PROJECT MANAGEMENT SYSTEM</u><br></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="data-table">
                        <br>
                        <br>
                        <br>
                        <h5><u style="color:blueviolet">Your Team </u></h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php
                                $i = 1;
                                $sql = "SELECT `request_id` FROM `registration` WHERE student_id = '$id' AND status = '1' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($rows = $result->fetch_assoc()) {
                                        $request_id = $rows['request_id'];
                                        $get = "SELECT `student_name`, `student_id`,`type`FROM `registration` WHERE request_id = '$request_id' ";
                                        $output = $conn->query($get);
                                        if ($output->num_rows > 0) {
                                            while ($row = $output->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++ ?>
                                                    </td>
                                                    <td><?php echo $row['student_id'] ?></td>
                                                    <td><?php echo $row['student_name'] ?></td>
                                                    <td><?php echo $row['type'] ?></td>
                                                    <td>
                                                        <form method="POST" action="">
                                                            <input type="hidden" value="<?php echo $row['id'] ?>" name="id"/>
                                                            <a href="#ex1" rel="modal:open"><button name="profile">Profile</button></a>
                                                        </form>
                                                    </td>
                                                </tr>

                                            <div id="ex1" class="modal" style="height: 400px;width: 20%;text-align: center">
                                                <h4>Student Profile</h4>
                                                <br>
                                                <?php
                                                $sid = $row['student_id'];
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
                                        echo '<tr><td style="color:red;text-align:center" colspan="5">No data found!</td></tr>';
                                    }
                                }
                            } else {
                                echo '<tr><td style="color:red;text-align:center" colspan="5">No data found!</td></tr>';
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12">
                    <?php
                    $sql = "SELECT `project_id` FROM `teams` WHERE student_id = '$id' ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        ?>

                        <center>
                            <h3 style="color:green">Request Received.<button onclick="window.location.href = 'data.php';">Click</button> to check.</h3>
                        </center>

                        <?php
                    } else {
                        ?>
                        <center><h1><u>Apply For Project</u></h1></center>

                        <form method="POST" action="" autocomplete="off">

                            <?php
                            $check = "SELECT `type` FROM `registration` WHERE student_id = '$id' AND status = '1' ";
                            $outcome = $conn->query($check);
                            if ($outcome->num_rows > 0) {
                                while ($row = $outcome->fetch_assoc()) {
                                    if ($row['type'] === 'leader') {
                                        ?>
                                        <h5><u style="color:blueviolet">Application Table</u><br><small style="color:red">edit only 1st row.</small></h5>
                                        <table class="">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Student ID</th>
                                                    <th>Supervisor 1</th>
                                                    <th>Supervisor 2</th>
                                                    <th>Supervisor 3</th>
                                                    <th>Project Title</th>
                                                    <th>Project Area</th>
                                                    <th>Shift</th>
                                                    <th>Project/Intern</th>
                                                </tr>

                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                $lastid = "";
                                                $last = "SELECT serial_no FROM teams ORDER BY id DESC limit 1";
                                                $outcome = $conn->query($last);

                                                if ($outcome->num_rows > 0) {
                                                    while ($rows = $outcome->fetch_assoc()) {
                                                        $lastid = $rows['serial_no'];
                                                    }
                                                } else {
                                                    $lastid = 0;
                                                }

                                                $x = $lastid;
                                                $i = 1;
                                                $sql = "SELECT `request_id` FROM `registration` WHERE student_id = '$id' AND status = '1' ";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($rows = $result->fetch_assoc()) {
                                                        $request_id = $rows['request_id'];
                                                        $get = "SELECT *FROM `registration` WHERE request_id = '$request_id'";
                                                        $output = $conn->query($get);
                                                        if ($output->num_rows > 0) {
                                                            while ($row = $output->fetch_assoc()) {
                                                                ?>
                                                            <input type="hidden" name="name[]" value="<?php echo $row['student_name'] ?>" required>
                                                            <input type="hidden" name="email[]"value="<?php echo $row['email'] ?>" required>
                                                            <input type="hidden" name="contact[]" value="<?php echo $row['contact'] ?>" required>
                                                            <input type="hidden" name="memberType[]" value="<?php echo $row['type'] ?>" required>
                                                            <input type="hidden" name="serial[]" value="<?php echo $x + 1 ?>" required>
                                                            <tr>
                                                                <td><?php echo $i++ ?></td>
                                                                <?php
                                                                $readonly = '';
                                                                if ($i != '2') {
                                                                    $readonly = 'readonly';
                                                                }
                                                                ?>
                                                                <td><input value="<?php echo $row['student_id'] ?>" name="sid[]" readonly required></td>
                                                                <td><input value="" name="supervisor1[]" placeholder="Choice 1" id="supervisor_<?php echo $i ?>" list="supervisor" <?php echo $readonly ?> required></td>
                                                                <td><input value="" name="supervisor2[]" placeholder="Choice 2" id="supervisor_<?php echo $i ?>3" list="supervisor" <?php echo $readonly ?> required></td>
                                                                <td><input value="" name="supervisor3[]" placeholder="Choice 3" id="supervisor_<?php echo $i ?>4" list="supervisor" <?php echo $readonly ?> required></td>
                                                                <td><input name="title[]" placeholder="Enter project title" id="field_<?php echo $i ?>"  <?php echo $readonly ?> required></td>
                                                                <td><input name="interest[]" placeholder="Enter intersested in.." id="area_<?php echo $i ?>"  <?php echo $readonly ?> required></td>
                                                                <td><input name="shift[]" list="shift" placeholder="Enter shift" id="shift_<?php echo $i ?>"  <?php echo $readonly ?> required></td>
                                                                <td><input name="type[]" list="type" placeholder="Enter type" id="type_<?php echo $i ?>"  <?php echo $readonly ?> required></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo '<tr><td style="color:red;text-align:center" colspan="9">No data found!</td></tr>';
                                                    }
                                                }
                                            } else {
                                                echo '<tr><td style="color:red;text-align:center" colspan="9">No data found!</td></tr>';
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="9">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck1" checked required>
                                                        <label class="custom-control-label" for="customCheck1">I agree with all <a href="#">terms and policies.</a></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="9"><input type="submit" name="submit" value="Apply" class="btn-dark" onclick="confirm('Are you sure to submit?')"></td>
                                            </tr>
                                            <datalist id="shift">
                                                <option>Day</option>
                                                <option>Evening</option>
                                            </datalist>
                                            <datalist id="type">
                                                <option>Project</option>
                                                <option>Intern</option>
                                            </datalist>
                                            <datalist id="supervisor">
                                                <?php
                                                $sql = "SELECT *FROM supervisor";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?php echo $row['supervisor_code'] ?>"><?php echo $row['supervisor_name'] ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    echo '<option>HEllo</option>';
                                                }
                                                ?>
                                            </datalist>
                                            </tbody>
                                        </table>

                                        <?php
                                    } else {
                                        ?>
                                        <center><h4 style="color:red;margin: 5%">Only Leader has the right.</h4></center>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo ' <center><h1>Nothing to do.</h1></center>';
                                }
                            }
                            ?>
                    </form>
                </div>


            </div>
        </div>
        <script>
            $(function () {
                var $field1 = $('#field_2');
                var $field2 = $('#field_3');
                var $field3 = $('#field_4');
                function onChange() {
                    $field2.val($field1.val());
                    $field3.val($field1.val());
                }
                ;
                $('#field_2')
                        .change(onChange)
                        .keyup(onChange);
                $('#field_4')
                        .change(onChange)
                        .keyup(onChange);
            });
        </script>
        <script>
            $(function () {
                var $shift1 = $('#shift_2');
                var $shift2 = $('#shift_3');
                var $shift3 = $('#shift_4');
                function onChange() {
                    $shift2.val($shift1.val());
                    $shift3.val($shift1.val());
                }
                ;
                $('#shift_2')
                        .change(onChange)
                        .keyup(onChange);
                $('#shift_4')
                        .change(onChange)
                        .keyup(onChange);
            });
        </script>
        <script>
            $(function () {
                var $type1 = $('#type_2');
                var $type2 = $('#type_3');
                var $type3 = $('#type_4');
                function onChange() {
                    $type2.val($type1.val());
                    $type3.val($type1.val());
                }
                ;
                $('#type_2')
                        .change(onChange)
                        .keyup(onChange);
                $('#type_4')
                        .change(onChange)
                        .keyup(onChange);
            });
        </script>
        <script>
            $(function () {
                var $area1 = $('#area_2');
                var $area2 = $('#area_3');
                var $area3 = $('#area_4');
                function onChange() {
                    $area2.val($area1.val());
                    $area3.val($area1.val());
                }
                ;
                $('#area_2')
                        .change(onChange)
                        .keyup(onChange);
                $('#area_4')
                        .change(onChange)
                        .keyup(onChange);
            });
        </script>
        <script>
            $(function () {
                var $supervisor1 = $('#supervisor_2');
                var $supervisor2 = $('#supervisor_3');
                var $supervisor3 = $('#supervisor_4');
                function onChange() {
                    $supervisor2.val($supervisor1.val());
                    $supervisor3.val($supervisor1.val());
                }
                ;
                $('#supervisor_2')
                        .change(onChange)
                        .keyup(onChange);
                $('#supervisor_4')
                        .change(onChange)
                        .keyup(onChange);
            });
        </script>
        <script>
            $(function () {
                var $supervisor1 = $('#supervisor_23');
                var $supervisor2 = $('#supervisor_33');
                var $supervisor3 = $('#supervisor_43');
                function onChange() {
                    $supervisor2.val($supervisor1.val());
                    $supervisor3.val($supervisor1.val());
                }
                ;
                $('#supervisor_23')
                        .change(onChange)
                        .keyup(onChange);
                $('#supervisor_43')
                        .change(onChange)
                        .keyup(onChange);
            });
        </script>
        <script>
            $(function () {
                var $supervisor1 = $('#supervisor_24');
                var $supervisor2 = $('#supervisor_34');
                var $supervisor3 = $('#supervisor_44');
                function onChange() {
                    $supervisor2.val($supervisor1.val());
                    $supervisor3.val($supervisor1.val());
                }
                ;
                $('#supervisor_24')
                        .change(onChange)
                        .keyup(onChange);
                $('#supervisor_44')
                        .change(onChange)
                        .keyup(onChange);
            });
        </script>
    </body>
</html> 
<?php
if (isset($_POST["submit"])) {


    $last = "SELECT project_id FROM teams ORDER BY id DESC limit 1";
    $outcome = $conn->query($last);

    if ($outcome->num_rows > 0) {
        // output data of each row
        while ($rows = $outcome->fetch_assoc()) {
            $lastPid = $rows['project_id'];
            $lastdigit = substr($lastPid, 7, 8);
        }
    } else {
        
    }

    $add = $lastdigit + 1;

    foreach ($_POST["sid"] as $rec => $value) {

        $sid = $_POST["sid"][$rec];
        $supervisor1 = $_POST["supervisor1"][$rec];
        $supervisor2 = $_POST["supervisor2"][$rec];
        $supervisor3 = $_POST["supervisor3"][$rec];
        $name = $_POST["name"][$rec];
        $email = $_POST["email"][$rec];
        $contact = $_POST["contact"][$rec];
        $title = $_POST["title"][$rec];
        $interest = $_POST["interest"][$rec];
        $shift = $_POST["shift"][$rec];
        $type = $_POST["type"][$rec];
        $type = $_POST["type"][$rec];
        $serial = $_POST["serial"][$rec];
        $memberType = $_POST["memberType"][$rec];

        if ($shift == 'Day') {
            $pid = 'FALL19D' . $add;
        } else {
            $pid = 'FALL19E' . $add;
        }


        $sql = "INSERT INTO `teams`(`student_id`,`supervisor1`,`supervisor2`,`supervisor3`, `student_name`, `student_email`, `student_phone`, `project_id`, `project_title`, `interested_area`, `shift`, `type`,`serial_no`, `member_type`) "
                . "VALUES ('$sid','$supervisor1','$supervisor2','$supervisor3','$name','$email','$contact','$pid','$title','$interest','$shift','$type','$serial','$memberType')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href = 'data.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>



