<?php

if(isset($_GET['rid'])){

    include 'connection.php';

    $rid = $_GET['rid'];
    $status = $_GET['status'];

    echo $rid."-----------".$status;

    if($status == 'approve'){
            $query = "UPDATE `restaurant_registration` SET `registration_status`='Approved'  WHERE res_id = $rid";
    }
    else{
        $query = "UPDATE `restaurant_registration` SET `registration_status`='Rejected'  WHERE res_id = $rid";
    }


    if(mysqli_query($conn,$query)){
        header('location:pending_res.php');
    }



}
?>