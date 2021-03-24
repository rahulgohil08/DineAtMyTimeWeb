<?php

session_start();
include('connection.php');


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');

}


if (isset($_POST['submit'])) {


    $offer_id = $_POST['offer_id'];
    $promo_code = $_POST['promo_code'];
    $min_purchase = $_POST['min_purchase'];
    $discount = $_POST['discount'];


    $q = "UPDATE manage_offers set promo_code = '$promo_code',min_purchase = $min_purchase,discount_amount = $discount WHERE offer_id = $offer_id";
    $data = mysqli_query($conn, $q);

    header("location:manage-promo.php");


}
?>

<body>


</body>