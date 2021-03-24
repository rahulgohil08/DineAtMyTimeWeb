<?php

session_start();
include('connection.php');


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');

}


if (isset($_GET['menu'])) {

    $menu = $_GET['menu'];

    $query = "DELETE FROM menu where menu_id  =$menu";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:manage-menu.php');
    }


}


if (isset($_GET['table'])) {

    $table = $_GET['table'];

    $query = "DELETE FROM my_table where table_id = $table";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:manage-seats.php');
    }


}


if (isset($_GET['promo'])) {

    $promo = $_GET['promo'];

    $query = "DELETE FROM manage_offers where offer_id = $promo";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:manage-promo.php');
    }


}


?>

<body>


</body>