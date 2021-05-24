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
    <link href="css/styles.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <?php require('./config/connection.php') ?>
    <?php
    $user_id = $_SESSION['user_id'];
    if (!$user_id) {
        header("Location: index.php");
    }
    $student_query = "SELECT * FROM student WHERE user_id = $user_id";
    $student_result = mysqli_query($conn, $student_query);
    if (!$student_result) {
        header("Location: index.php");
    }
    $student = mysqli_fetch_assoc($student_result);
    $school_name = $student['school_name'];
    $first_name = $student['first_name'];
    $middle_initial = $student['middle_initial'];
    $last_name = $student['last_name'];
    $phone_number = $student['phone_number'];
    $city = $student['city'];
    $province = $student['province'];
    $country = $student['country'];
    $zip_code = $student['zip_code'];
    $student_id = $student['student_id'];

    $app_query = "SELECT * FROM `application` WHERE student_id = $student_id";
    $app_result = mysqli_query($conn, $app_query);
    $app_exist = false;
    if ($app_result->num_rows > 0) {
        $app_exist = true;
        $application = mysqli_fetch_assoc($app_result);
    }
    ?>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">

            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <a href="logout.php" class='float-right m-3'>
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    Logout
                </a>
                <div class="row">
                    <div class="col-lg-5">
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </div>
                    <div class="col-lg-7 p-3">
                        <h4 class="m-0 font-weight-bold text-primary p-3" style="text-align: center;">NEW ERA INNOVATION CENTER</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <label class='text-info'>School Name</label>
                                <p class='font-weight-bold'><?php echo $school_name; ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class='text-info'>First Name</label>
                                <p class='font-weight-bold'><?php echo $first_name; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label class='text-info'>M.I.</label>
                                <p class='font-weight-bold'><?php echo $middle_initial; ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class='text-info'>Last Name</label>
                                <p class='font-weight-bold'><?php echo $last_name; ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Phone Number</label>
                                <p class='font-weight-bold'><?php echo $phone_number; ?></p>
                            </div>
                            <div class="col-md-12">
                                <hr />
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>City</label>
                                <p class='font-weight-bold'><?php echo $city; ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Province</label>
                                <p class='font-weight-bold'><?php echo $province; ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Country</label>
                                <p class='font-weight-bold'><?php echo $country; ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class='text-info'>Zip Code</label>
                                <p class='font-weight-bold'><?php echo $zip_code; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr />
                            </div>
                            <?php
                            if (!$app_exist) {
                                echo ' <div class="col-md-6"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applicationModal">
                                        Create Application
                                    </button></div>';
                            } else {
                                $app_id = $application['application_id'];
                                echo '<div class="col-md-12">
                                        <p class="font-weight-bold text-primary"> APPLICATION ' . $application['status'] . '</p></div>';

                                $already_req = "SELECT * FROM `membership_extension` WHERE application_id=$app_id";
                                $check_result = mysqli_query($conn,$already_req);
                                if ($application['status'] == 'ACTIVE'){
                                    if($check_result->num_rows  == 0){
                                        echo '<div class="col-md-12">
                                        <form method="POST" action="request_extension.php">
                                            <button type="submit" class="btn btn-dark" name="application_id" value="' . $app_id . '">
                                                REQUEST EXTENSION
                                            </button>
                                            </form>
                                        </div>';
                                    }else{
                                        echo '<div class="col-md-12">
                                            <p class="text-success" name="application_id">
                                                EXTENSION REQUESTED
                                            </p>
                                        </div>';
                                    }
                               
                                }
                             
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- application modal -->
        <div class="modal fade" id="applicationModal" tabindex="-1" role="dialog" aria-labelledby="applicationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method='POST' action='applicant_profile.php'>
                        <div class="modal-header">
                            <h5 class="modal-title" id="applicationModalLabel">Create Application</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class='font-weight-bold' for="gwa">GWA</label>
                                <input type="number" class="form-control" id="gwa" name="gwa" placeholder="GWA" step='.01' min='1.00' max='5.00'>
                            </div>
                            <div class="form-group">
                                <label class='font-weight-bold' for="specialization">Specialization</label>
                                <select class="browser-default custom-select form-control" id="specialization" name="specialization" >
                                    <option selected>Specialization</option>
                                    <option value="ROBOTICS">ROBOTICS</option>
                                    <option value="BIOENGINEERING">BIOENGINEERING</option>
                                    <option value="PHYSICS">PHYSICS</option>
                                    <option value="ARTIFICIAL INTELLIGENCE">ARTIFICIAL INTELLIGENCE</option>
                                </select>
                            </div>
                            <!-- academic honors  -->
                            <div class="form-group" id='academic-honors-group'>
                                <label class='font-weight-bold' for="academic_honors">Academic Honors</label>
                                <input type="text" class="form-control mb-1" id="academic_honors" name="academic_honors[]" placeholder="Academic Honors">
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button type='button' onclick="addHonors()" class="btn btn-success btn-circle"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type='button' onclick="removeHonors()" class="btn btn-danger btn-circle"><i class="fa fa-minus" aria-hidden="true"></i></button>
                            </div>
                            <!-- extracurricular  -->
                            <div class="form-group" id='extra_curricular-group'>
                                <label class='font-weight-bold' for="extracurricular_activities">Extracurricular Activities</label>
                                <input type="text" class="form-control mb-1" id="extracurricular_activities" name="extracurricular_activities[]" placeholder="Extracurricular Activities">
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button type='button' onclick="addExtraCurr()" class="btn btn-success btn-circle"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type='button' onclick="removeExtraCurr()" class="btn btn-danger btn-circle"><i class="fa fa-minus" aria-hidden="true"></i></button>
                            </div>
                            <!-- community activities -->
                            <div class="form-group" id='community_activities-group'>
                                <label class='font-weight-bold' for="community_activities">Community Activities</label>
                                <input type="text" class="form-control mb-1" id="community_activities" name="community_activities[]" placeholder="Community Activities">
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button type='button' onclick="addCommunityAct()" class="btn btn-success btn-circle"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type='button' onclick="removeCommunityAct()" class="btn btn-danger btn-circle"><i class="fa fa-minus" aria-hidden="true"></i></button>
                            </div>
                            <!-- scholarships awarded -->
                            <div class="form-group" id='scholarship_awarded-group'>
                                <label class='font-weight-bold' for="scholarship_awarded">Scholarships Awarded</label>
                                <input type="text" class="form-control mb-1" id="scholarship_awarded" name="scholarship_awarded[]" placeholder="Scholarships Awarded">
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button type='button' onclick="addScholarships()" class="btn btn-success btn-circle"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type='button' onclick="removeScholarships()" class="btn btn-danger btn-circle"><i class="fa fa-minus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit Application</button>
                        </div>
                    </form>
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
        function addHonors() {
            $('#academic-honors-group').append(`<input type="text" class="form-control mb-1" id="academic_honors" name="academic_honors[]" placeholder="Academic Honors">`);
        }

        function removeHonors() {
            $("#academic-honors-group :last-child").remove();
        }

        function addExtraCurr() {
            $('#extra_curricular-group').append(`<input type="text" class="form-control mb-1" id="extracurricular_activities" name="extracurricular_activities[]" placeholder="Extracurricular Activities">
`);
        }

        function removeExtraCurr() {
            $("#extra_curricular-group :last-child").remove();
        }

        function addCommunityAct() {
            $('#community_activities-group').append(`<input type="text" class="form-control mb-1" id="community_activities" name="community_activities[]" placeholder="Community Activities">
`);
        }

        function removeCommunityAct() {
            $("#community_activities-group :last-child").remove();
        }

        function addScholarships() {
            $('#scholarship_awarded-group').append(`<input type="text" class="form-control mb-1" id="scholarship_awarded" name="scholarship_awarded[]" placeholder="Scholarships Awarded">
`);
        }

        function removeScholarships() {
            $("#scholarship_awarded-group :last-child").remove();
        }
    </script>

    <?php
    if (isset($_POST['gwa'])) {
        // $get_userID_query = 
        $gwa = $_POST['gwa'];
        $specialization = $_POST['specialization'];


        $application_query = "INSERT INTO `application`(`student_id`,`gwa`, `specialization`) VALUES ($student_id,$gwa,'$specialization')";
        $result = mysqli_query($conn, $application_query);
        $application_id = mysqli_insert_id($conn);

        foreach ($_POST['academic_honors'] as $value) {
            $acad_query = "INSERT INTO `academic_honors` VALUES ($application_id,'$value')";
            $result = mysqli_query($conn, $acad_query);
        }
        foreach ($_POST['extracurricular_activities'] as $value) {
            $extra_query = "INSERT INTO `extracurricular_activities` VALUES ($application_id,'$value')";
            $result = mysqli_query($conn, $extra_query);
        }
        foreach ($_POST['community_activities'] as $value) {
            $comm_query = "INSERT INTO `community_activities` VALUES ($application_id,'$value')";
            $result = mysqli_query($conn, $comm_query);
        }
        foreach ($_POST['scholarship_awarded'] as $value) {
            $sc_query = "INSERT INTO `scholarship_awarded` VALUES ($application_id,'$value')";
            $result = mysqli_query($conn, $sc_query);
        }
        echo "<script type='text/javascript'>window.top.location='applicant_profile.php';</script>";
        exit;
    }
    ?>

</body>

</html>