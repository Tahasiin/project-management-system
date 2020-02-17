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

$query = "SELECT COUNT(id) FROM `registration`";
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
            table{
                text-align: center;
                width: 100%
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
            <a href="students.php" class="active"><i class="fa fa-fw fa-user"></i> Students</a>
            <a href="teams.php"><i class="fa fa-fw fa-users"></i>Teams</a>
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
                            <th colspan="2">
                                Registered Students[<span style="color:red"><?php echo $count ?></span>]
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <input id="myInput" type="text" placeholder="Search..." list="serial">
                                <datalist id="serial">
                                    <?php
                                    $sql = "SELECT student_id FROM `registration`";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option><?php echo $row['student_id'] ?></option>
                                            <?php
                                        }
                                    } else {
                                        
                                    }
                                    ?>

                                </datalist>
                            </th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Student ID</th>
                        </tr>
                        <tbody id="myTable">
                            <?php
                            $i = 1;
                            $sql = "SELECT student_id FROM `registration`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" value="<?php echo $row['student_id'] ?>" name="studentID">
                                        <button type="submit" name="search"><?php echo $row['student_id'] ?></button>
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
                <div class="col-sm-2"></div>
                <?php
                if (isset($_POST['search'])) {

                    $studentID = $_POST['studentID'];

                    $sql = "SELECT *FROM `registration` WHERE student_id = '$studentID'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-sm-4">
                                <center>
                                    <div class="profile">

                                        <span style="color:blue">Name:</span>
                                        <p><?php echo $row['student_name'] ?></p>
                                        <span style="color:blue">Student ID:</span>
                                        <p><?php echo $row['student_id'] ?></p>
                                        <span style="color:blue">Email:</span>
                                        <p><?php echo $row['email'] ?></p>
                                        <span style="color:blue">Contact:</span>
                                        <p><?php echo $row['contact'] ?></p>
                                        <br>
                                        <button class="btn btn-dark">Update</button>
                                        <button class="btn btn-danger">Delete</button>
                                        <br>
                                    </div>
                                </center>
                            </div>
                            <?php
                        }
                    } else {
                        echo '0 result';
                    }
                }
                ?>

            </div>

    </body>
</html> 
<?php
$conn->close();
?>