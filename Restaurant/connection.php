<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dine_mytime";

//session_start ();
// Create connection 
$conn = mysqli_connect ($servername, $username, $password, $dbname);
//Check connection
if (!$conn)
	{
		die("Connection failed: ".mysqli_connect_error());
	}else{
  //  echo 'connection';
  }
?>