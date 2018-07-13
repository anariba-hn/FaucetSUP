<?php
include("../connex.php"); 
session_start();

if(empty($_SESSION['admin']))
{
    header("Location: ../admincenter/index.html");
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../css/adminstylee.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <!-- SCRIPTS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Dashboard</title>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../admincenter/withdrawals.php">Withdrawals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admincenter/donations.php">Donations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admincenter/admins.php" >Admins</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admincenter/settings.php">Settigs</a>
                </li>
                <li class="nav-item">
                    <a id="btnLogOut" class="nav-link">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="row">
        <div class="container dashboard">
            <div class="col-xs-2 users">
                <p>Total Users</p>
                <span> 
                   <?php 

                $query = "SELECT count(*) as total from users";
                if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));

                $data = mysqli_fetch_row($result);
                  echo $total_users = (int) $data[0];
                    ?>
                </span>
            </div>

            <div class="col-xs-2 claims">
                <p>Total Claims</p>
                <span>
                     <?php 

                $query2 = "SELECT sum(wallet_claims) as total from wallet";
                if(!$result = mysqli_query($cnn, $query2))
                exit(mysqli_error($cnn));

                $data2 = mysqli_fetch_row($result);
                  echo $total_claims = (int) $data2[0];
                    ?> 
                 </span>
            </div>
            <div class="col-xs-2 paids">
                <p>Total Paid</p>
                <span>
                  <?php 

                $query3 = "SELECT sum(wallet_paids) as total from wallet";
                if(!$result = mysqli_query($cnn, $query3))
                exit(mysqli_error($cnn));

                $data3 = mysqli_fetch_row($result);
                  echo $total_paids = (int) $data3[0];
                    ?> 
              </span>
            </div>

            <div class="col-xs-2 donated">
                <p>Total Donated</p>
                <span>0</span>
            </div>
        </div>
    </div>
    
    <!--SCRIPTS-->
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">