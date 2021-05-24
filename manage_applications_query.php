<?php
require('./config/connection.php');
if (isset($_GET['request_method']) && $_GET['request_method'] == 'get_all') {
    $stud_query = 'SELECT * FROM `student` INNER JOIN application ON application.student_id = student.student_id';
    $result = mysqli_query($conn, $stud_query);
    $output = array();
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $action_query = 'SELECT * FROM membership_extension WHERE application_id='.$row['application_id'];
            $action_result = mysqli_query($conn, $action_query);
            if($action_result->num_rows > 0){
                $action = 'REQUEST MEMBERSHIP EXTEND';
            }else{
                $action = 'None';
            }
            array_push($output, array(
                "action" => $action,
                "application_id" => $row['application_id'],
                "school_name" => $row['school_name'],
                "student_name" => $row['first_name'] . " " . $row['middle_initial'] . " " . $row['last_name'],
                "specialization" => $row['specialization'],
                "application_date" => $row['application_date'],
                "membership_end_date" => $row['membership_end_date'],
                "status" => $row['status'],
            ));
        }
    }
    header("Content-Type: application/json");
    echo json_encode($output);
} elseif (isset($_POST['request_method']) && $_POST['request_method'] == 'update_one') {
    $app_id = $_POST['application_id'];
    $membership_end_date = $_POST['membership_end_date'];
    $status = $_POST['status'];
    $app_query = "UPDATE application SET membership_end_date='$membership_end_date', status='$status' WHERE application_id = $app_id";
    $result = mysqli_query($conn, $app_query);

    $staff_id = $_SESSION['staff_id'];
    $staff_query = "INSERT INTO `application_update` VALUES ($app_id,$staff_id,now())";
    $staff_result = mysqli_query($conn,$staff_query);
    if(empty($action)){
        $extend_query = "DELETE FROM membership_extension WHERE application_id=$app_id";
        $result = mysqli_query($conn, $extend_query);
    }
}
?>