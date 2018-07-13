<?php include("../connex.php"); ?>
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
                    <a class="nav-link" href="../admincenter/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admincenter/withdrawals.php">Withdrawals</a>
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
    
    <h3>Donations</h3>
       <div class="table-responsive">
        <table widh="100%" class="table table-hover">
            <thead>
                <tr>
                    <td width="10%">Id_TX</td>
                    <td width="10%">Donor_ID</td>
                    <td width="20%">Block</td>
                    <td width="35%">Date_TX</td>
                    <td width="10%">Log_ID</td>
                    <td width="20%">Amount</td>
                    <td width="100%">TX_Hash</td>
                </tr>
            </thead>

            <?php

            $query = "SELECT * FROM get_tx_in";
            if(!$result = mysqli_query($cnn, $query))
                            exit(mysqli_error($cnn));

            #SETING PAGINATION VARIABLES
            $num_rows = $result->num_rows;
            $per_page     = 5;
            $offset       = 0;
            $current_page = '';

            #CALCULATE THE PAGE LEFT TO SHOW 
            $no_off_page = ceil($num_rows / $per_page); //ceil function round int

            #LOGIC TO HANDLE DATA OUTPUT PER PAGINATION
            if(isset($_GET['page'])){
                $current_page = $_GET['page'];
                $offset = ($per_page * $current_page) - $per_page ;
            }

            #NEW QUERY WITH PARAMETERS
            $paginateData = "SELECT * FROM get_tx_in LIMIT " .$per_page. " OFFSET " .$offset. "";
            if(!$result = mysqli_query($cnn, $paginateData))
                exit(mysqli_error($cnn));

            while($row=mysqli_fetch_assoc($result))
                        {
                            echo "<tr>";
                                echo "<td>", $row['id_tx'], "</td>";
                                echo "<td>", $row['donor_id'], "</td>";
                                echo "<td>", $row['block'], "</td>";
                                echo "<td>", $row['date_tx'], "</td>";
                                echo "<td>", $row['log_id'], "</td>";
                                echo "<td>", $row['amount'], "</td>";
                                echo "<td>", $row['tx_hash'], "</td>";
                            echo "</tr>";
                        }
            ?>

        </table>

        <!--PAGINATION-->

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="<?php
                               if($current_page == 1 || $current_page == ''){echo 'disabled';}?> page-item">
                        <a class="page-link" href="<?php
                               if($current_page == 1 || $current_page == ''){
                                   echo " # ";
                               }else{
                                    echo "?page=". ($current_page - 1);   
                               }
                               ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <?php for($x = 1; $x <= $no_off_page; $x ++): ?>
                    <li class="<?php
                               if($current_page == $x){
                                   echo 'active';
                               }
                               ?> page-item">
                        <a class="page-link" href="?page=<?php echo $x; ?>">
                            <?php echo $x; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    <li class="<?php
                               if($current_page == $no_off_page){echo 'disabled';}?> page-item">
                        <a class="page-link" href="<?php
                               if($current_page == $no_off_page){
                                   echo " # ";
                               }elseif($current_page == ''){
                                   echo "?page=2";
                               }else{
                                    echo "?page=". ($current_page + 1);   
                               }
                               ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- ENDS PAGINATIONS -->
    </div> <!--TABLE RESPONSIVE ENDS--> 
    
    <!--SCRIPTS-->
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">