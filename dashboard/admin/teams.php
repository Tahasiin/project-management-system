<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header("location:logout.php");
    ;
    exit;
}
require '../../database/connection.php';
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}
$id = $_SESSION['admin_id'];

$query = "SELECT COUNT(id) FROM `teams` WHERE member_type = 'leader' ";
$result = mysqli_query($conn, $query);
$rows = mysqli_fetch_row($result);
$count = $rows[0];
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

            .col-sm-4{
                font-family: 'Cairo', sans-serif;
            }


            .notice{
                margin: 5% auto;
            }
            .notice p{
                text-align: center
            }

            img{
                width:100%;
                margin-left:-5px 
            }
            .heading{
                text-align: center
            }
            ::-webkit-scrollbar {
                display: none;
            }

            .active{
                color: red !important
            }
            span{
                color:yellow
            }
            .profile{
                margin-top: 15%;
                height: 350px;
                width: 80%;
                border:1px solid;
                text-align: center

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
            input{
                text-align: center
            }

        </style>
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
    </head>
    <body>

        <div class="sidebar">
            <a><img src="../../gallery/logo.png"></a>
            <a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="students.php" ><i class="fa fa-fw fa-user"></i> Students</a>
            <a href="teams.php" class="active"><i class="fa fa-fw fa-users"></i>Teams</a>
            <a href="data.php"><i class="fa fa-fw fa-file"></i>Applications</a>
            <a href="post.php"><i class="fa fa-fw fa-edit"></i>Post</a>
            <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </div>




        <div class="main">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="text-align: center;"><u>PROJECT MANAGEMENT SYSTEM</u></h3>
                </div>
            </div>
            <h4 class="heading"><u>PROFILE</u></h4>
            <div class="row">
                <div class="col-sm-2" style="margin-top: 5%;height: 500px;border-bottom: 1px solid;overflow: auto">

                    <table class="table-bordered">
                        <tr>
                            <th colspan="2"  style="background: none">
                                Registered Teams [<span style="color:red"><?php echo $count ?></span>]
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" style="background: none">
                                <input id="myInput" type="text" placeholder="Search..." list="serial">
                                <datalist id="serial">
                                    <?php
                                    $sql = "SELECT project_id FROM `teams` GROUP BY project_id";
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
                            </th>
                        </tr>
                        <tr>
                            <th  style="background: none">No</th>
                            <th  style="background: none">Project ID</th>
                        </tr>
                        <tbody id="myTable">
                            <?php
                            $i = 1;
                            $sql = "SELECT project_id FROM `teams`GROUP BY project_id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>

                                        <td>
                                            <form method="POST" action="">
                                                <input type="hidden" value="<?php echo $row['project_id'] ?>" name="projectID">
                                                <button type="submit" name="search"><?php echo $row['project_id'] ?></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="2" style="color:red">No Data Found!</td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>

                </div>
                <div class="col-sm-10">
                    <?php
                    if (isset($_POST['search'])) {

                        $projectID = $_POST['projectID'];

                        $sql = "SELECT *FROM `teams` WHERE project_id = '$projectID'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <table class="table-bordered table-dark" style="margin-top: 6%">
                                    <thead>
                                        <tr>
                                            <th  style="background: whitesmoke;color: red" colspan="9">Data Table For Team:&nbsp;<?php echo $row['project_id'] ?></th>
                                        </tr>
                                        <tr>
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

                                        $sql = "SELECT *FROM `teams` WHERE project_id = '$projectID'";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $project_id = $row['project_id'];
                                                ?>
                                                <tr>
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
                                            echo '<tr><td style="color:red;text-align:center" colspan="12">No Request Found!</td></tr>';
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="9" style="background:">
                                                <form method="POST" action="">
                                                    <input type="hidden" value="<?php echo $project_id ?>" name="projectID" />
                                                    <button class="btn-danger" name="delete">Delete</button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                            }
                        } else {
                            echo '0 result';
                        }
                    }
                    ?>

                </div>
            </div>
    </body>
</html> 
<?php
$conn->close();
?>