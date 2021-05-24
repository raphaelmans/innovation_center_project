<?php 
    require('./config/connection.php');


        if(isset($_POST['request_method']) && $_POST['request_method'] == 'insert'){
            $first_name = $_POST['first_name'];

            $middle_initial = $_REQUEST['middle_initial'];
            $last_name = $_REQUEST['last_name'];
            $phone_number = $_REQUEST['phone_number'];
            $specialization = $_REQUEST['specialization'];
            $email = $_REQUEST['email'];
            $password = $_REQUEST['password'];
            $role = $_REQUEST['role'];
    
            $create_user_q = "INSERT INTO `user`(`email`, `password`, `role`) VALUES ('$email',md5('$password'), '$role')";
    
    
            $create_result = mysqli_query($conn,$create_user_q);
            $user_id = mysqli_insert_id($conn);
    
            
            if($create_result){
                if($role =='SPECIALIST'){
                    $insert_query = "INSERT INTO `specialist` (`first_name`, `middle_initial`, `last_name`, `phone_number`, `specialization`, `user_id`) VALUES ('$first_name','$middle_initial','$last_name','$phone_number','$specialization',$user_id)";
                    $insert_result = mysqli_query($conn,$insert_query);
                }elseif($role =='STAFF'){
                    $insert_query = "INSERT INTO `staff` (`first_name`, `middle_initial`, `last_name`, `phone_number`, `position`, `user_id`) VALUES ('$first_name','$middle_initial','$last_name','$phone_number','$specialization',$user_id)";
                    $insert_result = mysqli_query($conn,$insert_query);
                }
     
            }
            header("location: manage_admins.php");
            exit();
        }
        elseif(isset($_GET['request_method']) && $_GET['request_method'] == 'get_all'){
            $spec_query = 'SELECT * FROM `specialist` INNER JOIN user ON specialist.user_id = user.user_id';
            $staff_query = 'SELECT * FROM `staff` INNER JOIN user ON staff.user_id = user.user_id';
            $result = mysqli_query($conn,$spec_query);
            $output = array();
            if($result->num_rows > 0){
                while($row = mysqli_fetch_assoc($result)){
                    array_push($output,array(
                        "first_name" => $row['first_name'],
                        "middle_initial" => $row['middle_initial'],
                        "last_name" => $row['last_name'],
                        "specialization" => $row['specialization'],
                        "phone_number" => $row['phone_number'],
                        "email" => $row['email'],
                        "password" => $row['password'],
                        "role" => $row['role'],
                    ));
                }
            }
            $result = mysqli_query($conn,$staff_query);
            if($result->num_rows > 0){
                while($row = mysqli_fetch_assoc($result)){
                    array_push($output,array(
                        "first_name" => $row['first_name'],
                        "middle_initial" => $row['middle_initial'],
                        "last_name" => $row['last_name'],
                        "specialization" => $row['position'],
                        "phone_number" => $row['phone_number'],
                        "email" => $row['email'],
                        "password" => $row['password'],
                        "role" => $row['role'],
                    ));
                }
            }
            header("Content-Type: application/json");
            echo json_encode($output);
        }
        elseif(isset($_POST['request_method']) && $_POST['request_method'] == 'delete_one'){
            $email = $_POST['email'];
            $delete_query = "DELETE FROM `user` WHERE email='$email'";
            $result = mysqli_query($conn,$delete_query);
            header("location: manage_admins.php");
            exit();
        }
 
?>