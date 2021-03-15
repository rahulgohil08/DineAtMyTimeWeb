<?php

session_start();
include('connection.php');


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');

}


if (isset($_GET['order'])) {

    $order = $_GET['order'];

    $query = "UPDATE my_order set is_expired = 1 where order_id  =$order";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:manage-order.php');
    }


}


?>

<body>


</body>