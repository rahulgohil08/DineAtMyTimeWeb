<?php

session_start();
include('connection.php');


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');
}


if (isset($_SESSION['res_id'])) {
    $res_id = $_SESSION['res_id'];
}


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


    <script>

        function fun() {

            return confirm('Are you sure? ');
        }

    </script>
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
                        Edit Promo
                    </div>
                    <div class="card-body">


                        <?php


                        $get_promo_id = $_GET['promo'];

                        $get_promo_data = "SELECT * FROM manage_offers where offer_id = $get_promo_id";
                        $execute = $conn->query($get_promo_data);
                        $fetch_data = $execute->fetch_object();


                        ?>


                        <form method="post" action="edit-promo-2.php">


                            <div class="form-group">

                                <input type="hidden" name="offer_id" value="<?php echo $fetch_data->offer_id ?>">

                                <label>Promo Code</label>
                                <input type="text" name="promo_code" value="<?php echo $fetch_data->promo_code ?>"
                                       class="form-control" required>
                            </div>


                            <div class="form-group" style="display: none">


                                <label>Minimum Purchase</label>
                                <input type="text" name="min_purchase" value="<?php echo $fetch_data->min_purchase ?>"
                                       class="form-control" required>
                            </div>


                            <div class="form-group">


                                <label>Discount Amount</label>
                                <input type="text" name="discount" value="<?php echo $fetch_data->discount_amount ?>"
                                       class="form-control" required>
                            </div>


                            <button class="btn btn-primary" type="submit" name="submit">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </main>


        <?php include 'footer.php' ?>


    </div>


    <!-----------------------------------------------------------Create State Modal========================= -->

    <div class="modal fade" id="createMenuModal" tabindex="-1" role="dialog" aria-labelledby="createMenuModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="post" action="create-menu.php">


                        <div class="form-group">
                            <label for="menu_name" class="col-form-label">Menu Name</label>
                            <input type="text" name="menu_name" class="form-control" id="menu_name" required>
                        </div>

                        <div class="form-group">
                            <label for="amount" class="col-form-label">Price</label>
                            <input type="number" name="amount" class="form-control" id="amount" required>
                        </div>


                        <button type="submit" name="submit" class="btn btn-primary">Create</button>

                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

</body>
</html>
