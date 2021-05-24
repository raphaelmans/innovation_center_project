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
                                <h1 class="h4 text-gray-900 mb-4">Login!</h1>
                            </div>
                            <form class="user" name='student_form' method="POST" action="login.php">
                                <div id='second_step'>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" placeholder="Email Address" name='email'>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name='password'>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-user btn-block">
                                            Login
                                        </button>
                                    </div>
                            </form>
                            <span class="small">
                                Don't have an account?&nbsp;
                            </span>
                            <a href="register.php" class="small">
                                Register here
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
    <?php
    if (isset($_POST['email'])) {
        $email = stripslashes($_POST['email']);

        $password = stripslashes($_POST['password']);
        $query = "SELECT * FROM `user` WHERE email='$email'
        and password='" . md5($password) . "'";

        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $row['role'];
            if ($row['role'] == 'APPLICANT') {
                header("Location: applicant_profile.php");
            } elseif ($row['role'] == 'SPECIALIST') {
                $spec_query = "SELECT * FROM specialist WHERE user_id=$user_id";
                $spec_result =  mysqli_query($conn, $spec_query);
                $spec = mysqli_fetch_assoc($spec_result);
                $_SESSION['specialist_id'] = $spec['specialist_id'];
                $_SESSION['specialization'] = $spec['specialization'];
                header("Location: applications.php");
            } elseif($row['role'] == 'STAFF'){
                $staff_query = "SELECT * FROM staff WHERE user_id=$user_id";
                $staff_result =  mysqli_query($conn, $staff_query);
                $staff = mysqli_fetch_assoc($staff_result);
                $_SESSION['staff_id'] = $staff['staff_id'];
                header("Location: applications.php");
            } 
            else {
                header("Location: applications.php");
            }
        } else {
            echo "<script>alert('Invalid credentials!');</script>";
        }
    }
    ?>

</body>

</html>