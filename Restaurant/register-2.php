<?php
if (isset($_POST['submit'])) {

    session_start();
    require 'connection.php';
    require 'host_url.php';

    if (isset($_SESSION['res_id'])) {

        header("location:index.php");
    }


    if (empty($_FILES['file']['name'])) {
        header('location:register.php');
    } else {


        $r_name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];

        $host = '../restaurants/';

        $filename = $_FILES["file"]["name"];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name = md5(date('d-m-Y H:i:s'));
        $upload = $name . ".jpg";

        $file_path = $host . $upload;


        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {

            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

                $query = "INSERT INTO `restaurant_registration`(`res_name`, `res_email`, `res_password`, `res_contact`, `res_address`, `res_image`) VALUES('$r_name','$email','$password','$mobile','$address','$upload')";
                $conn->query($query);
                header('location:login.php');
            }

        } else {

            echo "<script>alert('Please Choose Valid Image')</script>";

        }
    }


}


?>