<?php

if (isset($_POST['submit'])) {

    session_start();
    include 'connection.php';

    if (isset($_SESSION['res_id'])) {
        $res_id = $_SESSION['res_id'];
    }

    $menu_name = trim($_POST['menu_name']);
    $amount = trim($_POST['amount']);


    $query = "INSERT INTO `menu`(`res_id`, `menu_name`, `amount`) VALUES($res_id,'$menu_name',$amount)";
    $exe = mysqli_query($conn, $query);

    header('location:manage-menu.php');

}


?>