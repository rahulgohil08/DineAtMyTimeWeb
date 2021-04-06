<?php
if (isset($_POST['submit'])) {

    session_start();
    require 'connection.php';
    require 'host_url.php';

    if (!isset($_SESSION['res_id'])) {

        header('location:login.php');
    }

    if (isset($_SESSION['res_id'])) {
        $res_id = $_SESSION['res_id'];
    }


    if (empty($_FILES['file']['name'])) {
        header('location:manage-seat-map.php');
    } else {


        $host = '../seat_map/';

        $filename = $_FILES["file"]["name"];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $upload = md5(date('d-m-Y H:i:s')) . "_seat_map" . ".jpg";
        $file_path = $host . $upload;


        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {

            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {


                $query = "UPDATE `restaurant_registration` set `seat_image` = '$upload' where res_id = $res_id";

                $conn->query($query);
                header('location:manage-seat-map.php');
            }

        } else {

            echo "<script>alert('Please Choose Valid Image')</script>";

        }
    }


}


?>