<?php

session_start();
require 'connection.php';


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');
}

if (isset($_SESSION['res_id'])) {
    $res_id = $_SESSION['res_id'];
}


$get_product_data = "SELECT * FROM restaurant_registration where res_id = '$res_id'";
$execute = $conn->query($get_product_data);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Restaurant Panel</title>
    <link href="css/styles.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
          crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
            crossorigin="anonymous"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</head>


<body class="sb-nav-fixed">
<?php include 'nav.php' ?>


<div id="layoutSidenav">


    <?php include 'sidebar.php' ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid mt-3">

                <div class="card mb-4">


                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Manage Seat Map
                    </div>
                    <div class="card-body">

                        <?php

                        include 'host_url.php';

                        $fetch_data = $execute->fetch_object();
                        $img_url = $host_url . "dine_my_time/seat_map/";
                        $img = $img_url . $fetch_data->seat_image;

                        ?>


                        <form method="post" action="save-seat-image.php" enctype="multipart/form-data">


                            <!-- The Modal -->

                            <?php
                            if (!is_null($fetch_data->seat_image)) {
                                ?>

                                <center><img src='<?php echo $img ?>' id="myImg" width='800' height='400'/></center>

                            <?php } ?>


                            <div class="form-group">

                                <label>Seat Image</label><input type="file" name="file" class="form-control">
                            </div>


                            <button class="btn btn-primary" type="submit" name="submit">Save</button>

                        </form>


                    </div>
                </div>
            </div>
        </main>


        <?php include 'footer.php' ?>


    </div>
</div>

</body>
</html>
