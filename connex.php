<?php  
ini_set('display_errors', true); 
//Connection Variables
$host = "localhost";
$user = "root";
$password = "superior2020";
$db = "superiorf";

//Set connection to MySQL
$cnn = mysqli_connect($host,$user,$password,$db);

//Check status
if ($cnn->connect_error) {
	die("Connection Failds: " . $cnn->connect_error);
}
?>