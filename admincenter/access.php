<?php
include("../connex.php");
session_start();

if(isset($_POST['useradmin']))
{
	$admin = $_POST['useradmin'];
    $pw    = $_POST['pass'];
    $_SESSION['admin'] = $admin;
    
        $query = "SELECT user_password FROM admincenter WHERE user_admin = '$admin'";
        if(!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
        $data = mysqli_fetch_row($result);
        $dbPass = (string) $data[0];

    if($pw != $dbPass)
    {
     header("Location: ../admincenter/index.html");
    }else{
        	header("Location: ../admincenter/dashboard.php");
    }

}else{
	header("Location: ../admincenter/index.html");	
}

?>