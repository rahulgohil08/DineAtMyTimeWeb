<?php

session_start();
require 'connection.php';


if (!isset($_SESSION['res_id'])) {

    header('location:login.php');
}

if (isset($_SESSION['res_id'])) {
    $res_id = $_SESSION['res_id'];
}

$stmt = "SELECT my_order.order_id,my_order.menu,my_order.amount,my_order.booking_date_time,user.cust_name,my_table.table_no FROM `my_order` JOIN restaurant_registration USING (res_id) JOIN customer_registration as user USING(cust_id) JOIN my_table USING(table_id) where my_order.res_id = $res_id and my_order.is_expired = 0 and date(my_order.booking_date_time) = date(now())
 order by my_order.booking_date_time desc";
$data = mysqli_query($conn, $stmt);
// SELECT my_order.order_id,my_order.menu,my_order.amount,user.cust_name,my_table.table_no FROM `my_order` JOIN restaurant_registration USING (res_id) JOIN customer_registration as user USING(cust_id) JOIN my_table USING(table_id)
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
                        All Customers
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Customer Name</th>
                                    <th>Table No.</th>
                                    <th>Selected Menu</th>
                                    <th>Amount Paid</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>


                                <?php


                                while ($row = mysqli_fetch_assoc($data)) {

                                    ?>


                                    <tr>
                                        <td><?php echo $row['order_id'] ?></td>
                                        <td><?php echo $row['cust_name'] ?></td>
                                        <td><?php echo $row['table_no'] ?></td>
                                        <td><?php echo $row['menu'] ?></td>
                                        <td>Rs. <?php echo $row['amount'] ?></td>
                                        <td><?php echo $row['booking_date_time'] ?></td>
                                        <td>

                                            <a href='edit.php?order=<?php echo $row["order_id"] ?>'
                                               class='btn btn-success'
                                               onclick='return fun()'>Make Seat Available</a>
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
</div>

</body>
</html>
