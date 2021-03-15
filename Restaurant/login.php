<?php
include "connection.php";
session_start();


if (isset($_SESSION['res_id'])) {

    header("location:index.php");
}


if (isset($_POST['submit'])) {


    $username = $_POST['username'];
    $pwd = $_POST['pwd'];


    $username = $conn->real_escape_string($username);
    $pwd = $conn->real_escape_string($pwd);


    $q = "SELECT * FROM restaurant_registration WHERE res_email='$username' and res_password='$pwd'";
    $data = mysqli_query($conn, $q);
    $result = mysqli_num_rows($data);


    if ($result == 1) {

        $total = mysqli_fetch_assoc($data);
        $_SESSION['res_id'] = $total['res_id'];
        header("location:index.php");


    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
    }


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
                                    Login</h3></div>
                            <div class="card-body">


                                <form method="post">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <input type="text" name="username" id="inputEmail" class="form-control"
                                                   placeholder="Email address" required="required"
                                                   autofocus="autofocus">
                                            <label for="inputEmail">Username</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <input type="password" name="pwd" id="inputPassword" class="form-control"
                                                   placeholder="Password"
                                                   required="required">
                                            <label for="inputPassword">Password</label>
                                        </div>
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
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
