<?php 
    require 'connection.php';
// Data Fetch
// Start the session
session_start();


    $Email = $_REQUEST['email'];
    $Password = $_REQUEST['password'];

    $_SESSION["email"] = "$Email";
    // $_SESSION["password"] = "$Password";
    // echo "Session variable set".$_SESSION["email"];
    $sql = "select * from `admin_login` where admin_email = '$Email' and admin_password= '$Password'";
    //echo $sql;  
    
    $result = $conn->query($sql);

    if($result->num_rows>0){
        while($row = $result->fetch_assoc())
        {
            $id = $row['admin_id'];
            $name = $row['admin_name'];
            $email = $row['admin_email'];
        }
        echo'<script>window.location.href="index.php"</script>';
    }else{
        echo'<script>window.location.href="login.php"</script>';

    }
    
?>