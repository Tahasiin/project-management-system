<!--//Including Login Function-->
<?php include './query/student_login.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PROJECT MANAGEMENT SYSTEM</title>
        <link rel="icon" href="../gallery/logo.png" type="image/png"/>
        <link rel="stylesheet" href="../css/login.css" />
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <script>
            history.pushState(null, null, null);
            window.addEventListener('popstate', function () {
                history.pushState(null, null, null);
            });
        </script>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-4">
                <h3 style="text-align: center"><u>PROJECT MANAGEMENT SYSTEM</u></h3>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <h4 style="text-align: center"><a href="student.php" class="active">Student Login</a>&emsp;||&emsp;<a href="admin.php">Admin Login</a></h4>
            </div>
        </div>
        <div class="container">

            <div class="form" style="box-shadow: 5px 10px 18px #888888">
                <div class="row">
                    <div class="col-sm-4" style="border-right: 1px solid;">
                        <center>
                             <img src="../gallery/logo.png" height="120" width="120" style="margin-top: 50%"/>
                        </center>
                    </div>
                    <div class="col-sm-8" >
                        <div class="head">Student<br><h3><b>Sign in</b></h3></div>
                        <br/>
                        <form method="POST" action="" autocomplete="off">
                            <input placeholder="Enter Student ID" name="studentID" type="text" required="" autocomplete="off"><br/><br/>
                            <input placeholder="Enter Password" type="password" name="password" required="" autocomplete="new-password"><br/><br/>
                            <div class="bottom"><h6>No account? <a href="../registration/student.php">REGISTRATION</a></h6></div>
                            <input type="submit" name="login" class="submit btn-dark"  value="Sign In"><br><br>
                            <h6 style="color:red"><?php echo $warning ?></h6>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
