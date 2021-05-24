<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Innovation System - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <?php require('./config/connection.php') ?>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">

            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <h4 class="m-0 font-weight-bold text-primary" style="text-align: center;">NEW ERA INNOVATION CENTER</h4>
                            <br>
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Join Us!</h1>
                            </div>
                            <form class="user" name='student_form' method="POST" action="register.php">
                                <div id='first_step'>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="school_name" name="school_name" placeholder="School Name">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="first_name" name="first_name" placeholder="First Name">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-user" id="middle_initial" name="middle_initial" placeholder="M.I.">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-user" id="last_name" name="last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" class="form-control form-control-user" id="phone_number" name="phone_number" placeholder="Phone Number">
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="city" placeholder="City" name="city">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="province" placeholder="Province" name="province">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="country" placeholder="Country" name="country">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="zip_code" placeholder="Zip Code" name="zip_code">
                                        </div>
                                    </div>
                                    <a onclick="getStudentData()" class="btn btn-primary btn-user btn-block">
                                        Continue
                                    </a>
                                </div>

                                <div id='second_step' style="display:none">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" placeholder="Email Address" name='email'>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name='password'>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user" id="confirm_password" placeholder="Repeat Password" name='confirm_password'>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-user btn-block">
                                            Join
                                        </button>
                                        <a onclick="goToPrevious()" class="btn btn-primary btn-user btn-block">
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </form>
                            <br/>
                            <span class="small">
                                Already have an account?&nbsp;
                            </span>
                            <a href='index.php' class="small">
                                Login here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/validator/13.6.0/validator.min.js"></script>
    <script>
        var studentData = {};

        function getStudentData() {
            const first_name = $("#first_name").val();
            const last_name = $("#last_name").val();
            const middle_initial = $("#middle_initial").val();
            const city = $("#city").val();
            const province = $("#province").val();
            const country = $("#country").val();
            const zip_code = $("#zip_code").val();
            const phone_number = $("#phone_number").val();
            const school_name = $("#school_name").val();
            studentData = {
                first_name,
                last_name,
                middle_initial,
                city,
                province,
                country,
                zip_code,
                phone_number,
                school_name
            }
            $("#first_step").hide();
            $("#second_step").show();
        }

        function goToPrevious() {
            $("#first_step").show();
            $("#second_step").hide();
        }
    </script>
    <?php
    if (isset($_POST['email'])) {
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($conn, $email);

        $password = stripslashes($_POST['password']);
        $confirm_password = stripslashes($_POST['confirm_password']);

        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match. Please Try Again!');</script>";
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Email Invalid!');</script>";
            exit();
        }

        $password = mysqli_real_escape_string($conn, $password);

        $query = "INSERT into `user` (email, password,role) VALUES('$email','" . md5($password) . "','APPLICANT')";
        $result = mysqli_query($conn, $query);
        $user_id = mysqli_insert_id($conn);

        $school_name = $_POST['school_name'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $middle_initial = $_POST['middle_initial'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $country = $_POST['country'];
        $zip_code = $_POST['zip_code'];
        $phone_number = $_POST['phone_number'];

        $student_query =  "INSERT into `student` (`first_name`, `middle_initial`, `last_name`, `city`, `province`, `country`, `zip_code`, `phone_number`, `school_name`, `user_id`) VALUES('$first_name','$middle_initial','$last_name','$city','$province','$city','$zip_code','$phone_number','$school_name',$user_id)";
        $result = mysqli_query($conn, $student_query);
        if ($result) {
            echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
        }
    }
    ?>

</body>

</html>