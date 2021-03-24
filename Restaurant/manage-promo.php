<?php


session_start();
include('connection.php');


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');
}

if (isset($_SESSION['res_id'])) {
    $res_id = $_SESSION['res_id'];
}


$stmt = "SELECT * FROM `manage_offers` WHERE res_id = $res_id";
$data = mysqli_query($conn, $stmt);

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

                    <div class="py-2 mr-5 d-flex justify-content-between">

                        <div class="btn btn-primary ml-4" data-target="#createPromoModal" data-toggle="modal">Create
                            Promo
                        </div>

                    </div>


                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        All Promo
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Promo</th>
<!--                                    <th>Minimum Purchase</th>-->
                                    <th>Discount Amount</th>
                                    <th>Creation Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>

                                <tbody>


                                <?php


                                while ($row = mysqli_fetch_assoc($data)) {

                                    ?>


                                    <tr>
                                        <td><?php echo $row['promo_code'] ?></td>
<!--                                        <td>Rs. --><?php //echo $row['min_purchase'] ?><!--</td>-->
                                        <td>Rs. <?php echo $row['discount_amount'] ?></td>
                                        <td><?php echo $row['created_at'] ?></td>
                                        <td class="d-flex justify-content-between text-white">

                                            <a href='edit-promo.php?promo=<?php echo $row["offer_id"] ?>'
                                               class='btn btn-primary'>Edit</a>

                                            <a href='delete.php?promo=<?php echo $row["offer_id"] ?>'
                                               class='btn btn-danger'
                                               onclick='return fun()'>Delete</a>

                                        </td>
                                    </tr>

                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <?php include 'footer.php' ?>


    </div>


    <!-----------------------------------------------------------Create State Modal========================= -->

    <div class="modal fade" id="createPromoModal" tabindex="-1" role="dialog" aria-labelledby="createPromoModal"
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

                    <form method="post" action="create-promo.php">


                        <div class="form-group">
                            <label for="menu_name" class="col-form-label">Promo Code</label>
                            <input type="text" name="promo_code" class="form-control" id="menu_name" required>
                        </div>

                        <div class="form-group" style="display: none">
                            <label for="amount" class="col-form-label">Minimum Purchase</label>
                            <input type="number" name="min_purchase" class="form-control" id="amount" value="0" required>
                        </div>

                        <div class="form-group">
                            <label for="amount" class="col-form-label">Discount Amount</label>
                            <input type="number" name="discount" class="form-control" id="amount" required>
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
