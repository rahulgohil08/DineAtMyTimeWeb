<?php

session_start();
include('connection.php');


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');

}


if (isset($_POST['submit'])) {


    $menu_id = $_POST['menu_id'];
    $menu_name = $_POST['menu_name'];
    $amount = $_POST['amount'];


     $q = "UPDATE menu set menu_name = '$menu_name',amount = $amount WHERE menu_id = $menu_id";
    $data = mysqli_query($conn, $q);

    header("location:manage-menu.php");


}
?>

<body>


</body>