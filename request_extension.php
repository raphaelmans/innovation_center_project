<?php 

    require('./config/connection.php');

    if(isset($_POST['application_id']))
    $app_id = $_POST['application_id'];

    $query = "INSERT INTO `membership_extension`(`application_id`) VALUES ($app_id)";
    $result = mysqli_query($conn,$query);
    header('location: applicant_profile.php');

?>