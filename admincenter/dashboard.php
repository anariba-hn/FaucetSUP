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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
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
                    <a class="nav-link" href="#">Dashboard</a>
                </li>
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
                    <a class="nav-link" href="../admincenter/settings.php">Settings</a>
                </li>
                <li class="nav-item">
                   <form action="../admincenter/logout.php">
                    <button id="btnLogOut" class="nav-link logOut">Log Out</button>
                    </form>
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
                <span>
                <?php
                $query4 = "SELECT count(*) AS total FROM get_tx_in";
                if(!$result = mysqli_query($cnn, $query4))
                    exit(mysqli_error($cnn));
                $data4 = mysqli_fetch_row($result);
                echo $total_donated = (int)$data4[0];
                ?>
                </span>
            </div>
        </div> <!-- EDNS CONTAINER -->
    </div> <!-- EDNS ROW -->

    <div class="container mytable">
        <div class="table-responsive">
            <table id="tblUsers" width="100%" class="display table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <td width="10%">User</td>
                        <td width="20%">Email</td>
                        <td width="10%">Balance</td>
                        <td width="10%">Unlock</td>
                        <td width="10%">Withdrawals</td>
                        <td width="10%">Paid</td>
                        <td width="10%">Claims</td>
                        <td width="40%">Wallet</td>
                    </tr>
                </thead>

                <?php
                $query = "SELECT us.user_name, us.user_email, wa.wallet_balance, wa.wallet_unlock, us.user_address, wa.wallet_withdraws, wa.wallet_paids, wa.wallet_claims FROM users AS us JOIN wallet AS wa ON us.id_user = wa.user_id;";
                if(!$result = mysqli_query($cnn, $query))
                    exit(mysqli_error($cnn));

                while($row=mysqli_fetch_assoc($result))
                        {
                            echo "<tr>";
                                echo "<td>", $row['user_name'], "</td>";
                                echo "<td>", $row['user_email'], "</td>";
                                echo "<td>", $row['wallet_balance'], "</td>";
                                echo "<td>", $row['wallet_unlock'], "</td>";
                                echo "<td>", $row['wallet_withdraws'], "</td>";
                                echo "<td>", $row['wallet_paids'], "</td>";
                                echo "<td>", $row['wallet_claims'], "</td>";
                                echo "<td>", $row['user_address'], "</td>";
                            echo "</tr>";
                        }
                ?>

            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tblUsers').DataTable();
        } );
    </script>
    
    <!--SCRIPTS-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">