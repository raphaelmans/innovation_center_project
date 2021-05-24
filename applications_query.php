<?php

require('./config/connection.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET' && $_REQUEST['request_method'] == 'get_all') {
    $query = "SELECT * FROM application INNER JOIN student ON application.student_id = student.student_id AND application.status = 'PENDING'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($output, array(
            $row
        ));
    }
    header("Content-Type: application/json");
    echo json_encode($output);
} elseif ($method == 'GET' && $_REQUEST['request_method'] == 'get_one') {
    $app_id = $_REQUEST['application_id'];
    $student_id = $_REQUEST['student_id'];
    $query = "SELECT * FROM application INNER JOIN student ON application.student_id = student.student_id WHERE application.application_id = $app_id && student.student_id = $student_id";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    $acads_query = "SELECT * FROM academic_honors WHERE application_id=$app_id";
    $acads_result = mysqli_query($conn, $acads_query) or die(mysqli_error($conn));
    $row['acads'] = array();
    while ($acads = mysqli_fetch_assoc($acads_result)) {
        array_push($row['acads'], $acads);
    }

    $comm_query = "SELECT * FROM community_activities WHERE application_id=$app_id";
    $comm_result = mysqli_query($conn, $comm_query) or die(mysqli_error($conn));
    $row['comms'] = array();
    while ($comms = mysqli_fetch_assoc($comm_result)) {
        array_push($row['comms'], $comms);
    }



    $extra_query = "SELECT * FROM extracurricular_activities WHERE application_id=$app_id";
    $extra_result = mysqli_query($conn, $extra_query) or die(mysqli_error($conn));
    $row['extras'] = array();
    while ($extra = mysqli_fetch_assoc($extra_result)) {
        array_push($row['extras'], $extra);
    }


    $scholar_query = "SELECT * FROM scholarship_awarded WHERE application_id=$app_id";
    $scholar_result = mysqli_query($conn, $scholar_query) or die(mysqli_error($conn));
    $row['scholars'] = array();
    while ($scholar = mysqli_fetch_assoc($scholar_result)) {
        array_push($row['scholars'], $scholar);
    }


    header("Content-Type: application/json");
    echo json_encode($row);
} elseif (isset($_REQUEST['req_method']) == 'PUT') {
    $specialist_id = $_REQUEST['specialist_id'];
    $application_id = $_REQUEST['application_id'];

    $check_approval_query = "SELECT * FROM `application_approval` WHERE application_id=$application_id && specialist_id = $specialist_id";
    $check_result = mysqli_query($conn, $check_approval_query) or die(mysqli_error($conn));
    if ($check_result->num_rows > 0) {
        header("location: applications.php");
        exit();
    }
    $approval_query = "INSERT INTO `application_approval` VALUES ($application_id,$specialist_id)";
    $result = mysqli_query($conn, $approval_query) or die(mysqli_error($conn));

    $count_approval_query = "SELECT COUNT(*) as total_count FROM application_approval WHERE application_id=$application_id";
    $count_result = mysqli_query($conn, $count_approval_query);
    $total_count = 0;
    if($count_result->num_rows > 0){
        $count_row = mysqli_fetch_assoc($count_result);
        $total_count = $count_row['total_count'];
    }else{
        $total_count = 1;
    }

    if ($total_count >= 2) {
        $futureDate = date('Y-m-d', strtotime('+1 year'));
        $app_query = "UPDATE application SET approval_count=$total_count, status='ACTIVE', membership_end_date='$futureDate' WHERE application_id=$application_id";
        mysqli_query($conn, $app_query) or die(mysqli_error($conn));
    } else {
        $app_query = "UPDATE application SET approval_count=$total_count WHERE application_id=$application_id";
        mysqli_query($conn, $app_query) or die(mysqli_error($conn));
    }
    header("location: applications.php");
}
