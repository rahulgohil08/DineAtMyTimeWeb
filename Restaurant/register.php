<?php
include "connection.php";
session_start();


if (isset($_SESSION['res_id'])) {

    header("location:index.php");
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
            crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Restaurant
                                    Register</h3></div>
                            <div class="card-body">


                                <form method="post" enctype="multipart/form-data" action="register-2.php">


                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="inputEmail">Name</label>

                                            <input type="text" name="name" id="inputEmail" class="form-control"
                                                   placeholder="Restaurant Name" required="required"
                                                   autofocus="autofocus">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="inputEmail">Email</label>

                                            <input type="text" name="email" id="inputEmail" class="form-control"
                                                   placeholder="Email address" required="required"
                                                   autofocus="autofocus">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="inputPassword">Password</label>

                                            <input type="password" name="password" id="inputPassword" class="form-control"
                                                   placeholder="Password"
                                                   required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="inputEmail">Contact No.</label>

                                            <input type="number" name="mobile" id="inputEmail" class="form-control"
                                                   placeholder="Contact No." required="required"
                                                   autofocus="autofocus">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="inputEmail">Address</label>

                                            <input type="text" name="address" id="inputEmail" class="form-control"
                                                   placeholder="Address" required="required"
                                                   autofocus="autofocus">
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label>Restaurant Image</label><input type="file" name="file" class="form-control">
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                                </form>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>


</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
