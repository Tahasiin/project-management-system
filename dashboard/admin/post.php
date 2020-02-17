<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
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
        <script src="js/scripts.js"></script>
        <script src="ckeditor/ckeditor.js"></script>
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


            .heading{
                text-align: center
            }
            ::-webkit-scrollbar {
                display: none;
            }

            .active{
                color: red !important
            }
            img{
                width:100%;
                margin-left:-5px 
            }
        </style>
    </head>
    <body>

        <div class="sidebar">
            <a><img src="../../gallery/logo.png"></a>
            <a href="index.php" ><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="students.php"><i class="fa fa-fw fa-user"></i> Students</a>
            <a href="teams.php"><i class="fa fa-fw fa-users"></i>Teams</a>
            <a href="data.php"><i class="fa fa-fw fa-file"></i>Applications</a>
            <a href="post.php" class="active"><i class="fa fa-fw fa-edit"></i>Post</a>
            <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </div>



        <div class="main">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="text-align: center;"><u>PROJECT MANAGEMENT SYSTEM</u></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">

                    <div>
                        <h2 style="text-align: center">Admin Post</h2>
                    </div>
                    <form method="post" data-form-title="CREATE A POST" enctype="multipart/form-data" autocomplete="nope">
                        <input type="hidden" name="posted_by" value="ADMIN">
                        <div class="form-group">
                            <input type="text" class="form-control" name="post_subject" placeholder="Post Subject*" required="">
                        </div>
                        <div class="form-group">
                            <textarea name="post_description" id="editor1" rows="10" cols="80"></textarea>
                            <script>
                                CKEDITOR.replace('editor1');
                            </script>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="post_link"  placeholder="Link*">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="post_file" placeholder="File*" autocomplete="off" >
                        </div>
                        <div>
                            <input type="submit" value="POST" name="post" class="btn btn-lg btn-dark" style="height: 50px;width: 100%">
                        </div>
                    </form>
                   
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
        <img src="../uploads/"
</body>
</html> 
 <?php
            if (isset($_POST['post'])) {
               
                $subject = $_POST['post_subject'];
                $description = $_POST['post_description'];
                $link = empty($_POST['post_link']) ? 'null' : $_POST['post_link'];
                $posted_by = $_POST['posted_by'];
                
                $date = date_default_timezone_set('Asia/Dhaka');
                $date = date('d-m-Y');

                $time = date_default_timezone_set('Asia/Dhaka');
                $time = date("h:i:sa");


                $directory = '../uploads/';
                $file = $directory . basename($_FILES['post_file']['name']);
                move_uploaded_file($_FILES['post_file']['tmp_name'], $file);



                $sql = "INSERT INTO `posts`(`post_subject`, `post_description`, `post_link`, `post_file`, `posted_by`,`post_date`, `post_time`) VALUES ('$subject','$description','$link','$file','$posted_by','$date','$time')";
                if ($conn->query($sql) === TRUE) {
                    $success = "Posted Successfully !";
                    echo "<script type='text/javascript'>alert('$success');</script>";
                    echo"<script>document.location=''post.php'';</script>";
                } else {
                    $message = "Sorry ! Something went wrong !";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    echo"<script>document.location=''post.php'';</script>";
                }
            }
            ?>



        </html>
   
<?php
$conn->close();
?>
