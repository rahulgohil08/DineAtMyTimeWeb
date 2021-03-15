<?php 

    require 'connection.php';


    $stmt = "select * from `restaurant_registration`";
    $data = mysqli_query($conn, $stmt);

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tables - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php include 'nav.php'?>
        <div id="layoutSidenav">
        <?php include 'sidebar.php' ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="col-lg-12 d-flex justify-content-center">
                            <ul class="nav nav-pills nav-fill col-lg-4 text-center p-2">
                                <li class="nav-item">
                                    <a class="nav-link " href="approveReject.php?status=approve" id="btnApproved">Approved</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="approveReject.php?status=reject" id="btnRejected">Rejected</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="approveReject.php?status=Pending" id="btnRejected">Pending</a>
                                </li>
                            </ul>
                        </div>
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Restaurant ID</th>
                                                <th>Restaurant Name</th>
                                                <th>Restaurant Email</th>
                                                <th>Restaurant Contact</th>
                                                <th>Restaurant Address</th>
                                                <th>Restaurant Status</th>
                                                <th>Approve/Reject</th>

                                            </tr>
                                        </thead>
                                       
                                        <tbody>


                                        <?php
                                        
                                        $i=0;
                                        while($row = mysqli_fetch_assoc($data)){
                                            if($row['registration_status'] == "Pending"){
                                                $i=$i+1;
                                        ?>

                                            <tr>
                                                <td><?php echo $row['res_id'] ?></td>
                                                <td><?php echo $row['res_name'] ?></td>
                                                <td><?php echo $row['res_email'] ?></td>
                                                <td><?php echo $row['res_contact'] ?></td>
                                                <td><?php echo $row['res_address'] ?></td>
                                                <td><?php echo $row['registration_status'] ?></td>

                                                <td class="d-flex justify-content-between mr-3">
                                                    <a class='btn btn-success' href="manage_restaurant_status.php?status=approve&rid=<?php echo $row['res_id']?>">Approve</a>
                                                    <a class='btn btn-danger' href="manage_restaurant_status.php?status=reject&rid=<?php echo $row['res_id']?>">Reject</a>
                                                    
                                                </td>
                                            </tr>


                                            
                                            <?php } }?>

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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="/js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
