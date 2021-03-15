<?php

session_start();
include('connection.php');


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');

}


if (isset($_POST['submit'])) {


    $table_id = $_POST['table_id'];
    $table_no = $_POST['table_no'];


    $q = "UPDATE my_table set table_no = $table_no WHERE table_id = $table_id";
    $data = mysqli_query($conn, $q);

    header("location:manage-seats.php");


}
?>

<body>


</body>