<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    // redirect them to your desired location
    header("location:../login/student.php");
    exit;
}
require '../database/connection.php';

$success = '';
$alert = '';
$warning = '';
$invalid = '';
if (isset($_POST['submit'])) {
    $name = $_POST['student_name'];
    $id = $_POST['student_id'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];



    if (substr($id, 0, 4) === '161-') {
        $sql = "SELECT `student_id` FROM `registration` WHERE student_id = '$id' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $alert = 'Sorry! You are already registered! <a href="">Forgot password?</a>';
        } else {

            $sql = "INSERT INTO `registration`(`student_name`, `student_id`,`email`, `contact`,`password`) VALUES ('$name','$id','$email','$contact','$password')";

            if ($conn->query($sql) === TRUE) {
                $success = "Registration Process Completed Successfully !    <br>";
            } else {
                $alert = 'SORRY!!! An error occured ! <br> ';
            }
        }
    } else {
        $invalid = 'The ID format is not valid';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PROJECT MANAGEMENT SYSTEM</title>
        <link rel="icon" href="../gallery/logo.png" type="image/png"/>
        <!--custom styling-->
        <link rel="stylesheet" href="../css/registration.css" />
        <!--bootstrap-->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
        <!--fonts-->
        <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Grenze&display=swap" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            var check = function () {
                if (document.getElementById('password').value ==
                        document.getElementById('confirm_password').value) {
                    document.getElementById('message').style.color = 'green';
                    document.getElementById('message').innerHTML = 'Password matched';
                } else {
                    document.getElementById('message').style.color = 'red';
                    document.getElementById('message').innerHTML = 'not matching';
                }
            }
        </script>
        <script>
            function validate() {

                var a = document.getElementById("password").value;
                var b = document.getElementById("confirm_password").value;
                if (a != b) {
                    alert("Passwords do no match");
                    return false;
                }
            }
        </script>
        <style>
            ::-webkit-scrollbar {
                display: none;
            }

            input{text-align: center}

            input:valid {
                color: green;
            }
            input:invalid {
                color: red;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-6">
                <h3 style="text-align: center"><u>PROJECT MANAGEMENT SYSTEM</u></h3>
            </div>
            <div class="col-sm-4">
                <h4><a href="../login/student.php"><i class="fa fa-sign-in">SIGN-IN</i></a></h4>
            </div>
            <div class="col-sm-1"></div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!--registration form-->
                    <div class="form">
                        <div class="head">
                            Student<br>
                            <h3><b>Registration Form</b></h3>
                            <h4 style="color:green"><?php echo $success ?></h4>
                            <h4 style="color:red"><?php echo $alert ?></h4>
                            <h4 style="color:red"><?php echo $invalid ?></h4>
                        </div>
                        <br>

                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" onSubmit="return validate();">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div>
                                        <label>Student Name</label>
                                        <input placeholder="Enter Your Name"  type="text"  name="student_name" required>
                                    </div><br/>
                                    <div>
                                        <label>Student ID</label>
                                        <input placeholder="Enter Your ID" type="text"  name="student_id"  required>
                                    </div><br/>
                                    <div>
                                        <label>Email Address</label>
                                        <input placeholder="Enter Email Address"  type="email"  name="email" required autocomplete="off">
                                    </div><br/>
                                    <div>
                                        <label>Contact Number [<span style="color:blue"> 11 digits.</span> ]</label>
                                        <input placeholder="Enter Contact Number"  id="pin" type="number" pattern="\d{11}" min="0" maxlength="11" minlength="11" name="contact" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                    </div><br/>
                                    <div>
                                        <label>Password [<span style="color:blue">at least 6 characters</span> ] </label>
                                        <input placeholder="Enter Your Password" pattern=".{6,}"  name="password" id="password" autocomplete="new-password" type="password" title="AT least 6 number" required="">
                                    </div><br/>
                                    <div>
                                        <label>Confirm Password </label>
                                        <input placeholder="Retype Your Password" name="confirm_password"  id="confirm_password"  onkeyup='check();'  type="password" required="">
                                        <span id='message'></span>
                                    </div><br/>
                                    <input type="submit" name="submit" class="btn btn-dark"/>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <br>
                            <center>

                            </center>
                        </form>
                    </div>
                    <!--end registration form-->
                </div>
            </div>
        </div>
        <script>
            history.pushState(null, null, null);
            window.addEventListener('popstate', function () {
                history.pushState(null, null, null);
            });
        </script>

    </body>
</html>

