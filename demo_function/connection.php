<?php  
//sql procedural

//Credentials database
$servername = "localhost";
$username = "root";
$password = "";
$database = "book_library";

$conn = mysqli_connect($servername, $username, $password, $database);

//to check if there is no error in connecting to database

if (!$conn){
	die ("connection failed:" . mysqli_connect_error());
}

//echo "connected successfully";


?>
