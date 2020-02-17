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
            form{
                padding-left: 3%
            }
        </style>
    </head>
    <body>

        <div class="sidebar">
            <a><img src="../../gallery/logo.png"></a>
            <a href="index.php" class="active"><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="data.php"><i class="fa fa-fw fa-file"></i>Applications</a>
            <a href="post.php"><i class="fa fa-fw fa-edit"></i>Post</a>
            <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a>


        </div>



        <div class="main">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="text-align: center;"><u>PROJECT MANAGEMENT SYSTEM</u></h3>
                </div>
            </div><br><br>
            <h4 class="heading"><u>NOTICE</u></h4><?php
            $sql = "SELECT *FROM posts ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($post = $result->fetch_assoc()) {
                    ?>

                    <div style="margin: 5% auto; border: 1px solid;min-height: 200px;padding: 2%">
                        <legend style="color:blue"><?php echo $post['post_subject'] ?>
                            <small style="text-transform:lowercase;color: black;font-size: 13px">
                                <?php echo $post['posted_by'] ?>[ <?php echo $post['post_date'] ?> / <?php echo $post['post_time'] ?> ]
                            </small>
                        </legend>
                        <h5><?php echo $post['post_description'] ?></h5>
                        <br/>


                        <?php if ($post['post_link'] == 'null') { ?>
                            <?php
                        } else {
                            ?>
                            <h5><b>Visit the Link:</b><a href="<?php echo $post['post_link'] ?>" target="_blank">Click</a></h5>
                        <?php } ?>



                        <?php if ($post['post_file'] == '../uploads/') { ?>
                            <?php
                        } else {
                            ?>
                            <h5><b>Download Link:</b><a href="<?php echo $post['post_file'] ?>" target="_blank">Click to download.</a></h5>
                        <?php } ?>
                        <hr/>
                        <!--delete data form-->
                        <form method="POST" action="">
                            <input value="<?php echo $post['id'] ?>" type="hidden" name="id"/>
                            <button style="margin-left: 90%" class="btn-danger" title="Delete" type="submit" onclick="return confirm('Are you sure you want to delete this post?');">
                                DELETE
                            </button>

                        </form>
                        <!--end delete data form-->

                        <!--delete data funcion-->
                        <?php
                        if (isset($_POST['id'])) {

                            $id = $_POST['id'];

                            $sql = "DELETE FROM posts WHERE id='$id'";

                            if ($conn->query($sql) === true) {
                                $success = "Post Deleted !";
                                echo "<script type='text/javascript'>alert('$success');</script>";
                                echo"<script>document.location='';</script>";
                            } else {
                                $warning = "Sorry ! Something went wrong!";
                                echo "<script type='text/javascript'>alert('$warning');</script>";
                                echo"<script>document.location='';</script>";
                            }
                        }
                        ?>

                    </div>

                    <?php
                }
            } else {
                ?>
            <fieldset style="text-align: center">
                    <legend style="color:red">NO NOTICE FOUND</legend>
                </fieldset>
            <?php }
            ?>



        </div>

    </body>
</html> 

<?php
$conn->close();
?>
