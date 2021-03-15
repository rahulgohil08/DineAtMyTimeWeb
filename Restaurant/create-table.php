<?php

if (isset($_POST['submit'])) {

    session_start();
    include 'connection.php';

    if (isset($_SESSION['res_id'])) {
        $res_id = $_SESSION['res_id'];
    }

    $table_no = $_POST['table_no'];

    $query = "INSERT INTO `my_table`(`res_id`, `table_no`) VALUES($res_id,$table_no)";
    $exe = mysqli_query($conn, $query);

    header('location:manage-seats.php');

}


?>