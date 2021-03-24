<?php
if (isset($_POST['submit'])) {

    session_start();
    include 'connection.php';

    if (isset($_SESSION['res_id'])) {
        $res_id = $_SESSION['res_id'];
    }

    $promo_code = $_POST['promo_code'];
    $min_purchase = $_POST['min_purchase'];
    $discount = $_POST['discount'];

    $query = "INSERT INTO `manage_offers`(`res_id`, `promo_code`, `min_purchase`, `discount_amount`) VALUES($res_id,'$promo_code','$min_purchase','$discount')";
    $exe = mysqli_query($conn, $query);

    header('location:manage-promo.php');

}