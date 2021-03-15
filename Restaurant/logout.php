<?php
error_reporting(0);
session_start();
include('connection.php');


if (isset($_SESSION['admin_id'])) {

    unset($_SESSION['admin_id']);
    header('location:login.php');
}


if (isset($_SESSION['res_id'])) {

    unset($_SESSION['res_id']);
    header('location:login.php');

}


?>



 