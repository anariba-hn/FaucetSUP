<?php include("./connex.php");?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/faucetstylee.css">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <title>SuperiorFaucet</title>

    <!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

    <head>
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="./faucet.html">
                    <img src="assets/img/sup-logo.png" width="40" height="40" class="d-inline-block align-top" alt="">
                    Superior Coin
                </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#modal2" data-toggle="modal" data-target="#modal2">Transfer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modal3" data-toggle="modal" data-target="#">MyHistory</a>
                    </li>
                    <li class="nav-item">
                        <a id="btnLogOut" class="nav-link" href="#">Log Out</a>
                    </li>
                </ul>
            </div>
        </nav>
    </head>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 profile-hero">
                <img src="assets/img/user.png" alt="USER-IMG" style="width: 50px; height: 50px;">
                <br/>
                <span id="spnIdUser">user</span>
            </div>
        </div>
        <!--ENDS ROW 1-->

        <div class="row">
            <div class="col-sm-3" style="text-align: center;">
                <h5>Email</h5>
                <span id="spnEmail">error@superior.com</span>
            </div>

            <div class="col-sm-3" style="text-align: center;">
                <h5>Claims</h5>
                <span id="spnClaim">0</span>
            </div>

            <div class="col-sm-3" style="text-align: center;">
                <h5>Paids</h5>
                <span id="spnPaid">0</span>
            </div>
            
            <div class="col-sm-3" style="text-align: center;">
                <h5>Withdraws</h5>
                <span id="spnPWithdraws">0</span>
            </div>
        </div>
        <!-- ENDS ROW 2-->

        <div class="payments-container">
            <div class="table-responsive succes-tbl">
               <br/>
               <h2>Succes Transfer</h2>
                <table widh="100%" class="table table-hover" id="tb-succes">
                        <tbody>
                            <tr>
                                <td width="10%">ID</td>
                                <td width="25%">Amount</td>
                                <td width="25%">Status</td>
                                <td width="34%">Address</td>
                                <td width="34%">Hash</td>
                                <td width="30%">Date/Time</td>
                                <td width="10%">User ID</td>
                            </tr>
                        </tbody>
                        
                        <?php

                            #CATCHING THE COOKIE FROM SERVER SIDE
                            $walle = $_COOKIE["walle"];
                        
                            $query = "SELECT * FROM vf_payments_succes WHERE payments_wallet = '$walle'";
                            if(!$result = mysqli_query($cnn, $query))
                                exit(mysqli_error($cnn));
                
                            while($row=mysqli_fetch_assoc($result))
                            {
                                echo "<tr>";
                                    echo "<td>", $row['id_succes'], "</td>";
                                    echo "<td>", $row['payments_balance'], "-SUP</td>";
                                    echo "<td><p class=\"text-success\">", $row['payments_status'], "</p></td>";
                                    echo "<td>", $row['payments_wallet'], "</td>";
                                    echo "<td><a href=\"http://superior-coin.info:8081/\">", $row['payments_hash'], "</a></td>";
                                    echo "<td>", $row['payments_date'], "</td>";
                                    echo "<td>", $row['user_id'], "</td>";
                                echo "</tr>";
                            }
                            
                        ?>
                    </table>
            </div>
            <!-- TABLE-RESPONSIVE ENDS -->
            
            <div class="table-responsive error-tbl">
               <br/>
               <h2>Error Transfer</h2>
                <table widh="100%" class="table table-hover" id="tb-error">
                        <tbody>
                            <tr>
                                <td width="10%">ID</td>
                                <td width="25%">Amount</td>
                                <td width="25%">Status</td>
                                <td width="34%">Address</td>
                                <td width="30%">Date/Time</td>
                                <td width="10%">User ID</td>
                            </tr>
                        </tbody>
                        
                            <?php
                                    
                                #CATCHING THE COOKIE FROM SERVER SIDE
                                $walle = $_COOKIE["walle"];
                                    
                                $query2 = "SELECT * FROM vf_payments_error WHERE payments_wallet = '$walle'";
                                if(!$result = mysqli_query($cnn, $query2))
                                    exit(mysqli_error($cnn));

                                while($row=mysqli_fetch_assoc($result))
                                {
                                    echo "<tr>";
                                        echo "<td>", $row['id_error'], "</td>";
                                        echo "<td>", $row['payments_balance'], "-SUP</td>";
                                        echo "<td><p class=\"text-danger\">", $row['payments_status'], "</td>";
                                        echo "<td>", $row['payments_wallet'], "</td>";
                                        echo "<td>", $row['payments_date'], "</td>";
                                        echo "<td>"; echo $row['user_id'], "</td>";
                                        echo "</tr>";
                                }
                            
                            ?>
                    </table>
            </div>
            <!-- TABLE-RESPONSIVE ENDS -->
            
        </div>
        <!-- PAYMENTS-CONTAINER ENDS-->

    </div>
    <!-- CONTAINER ENDS-->


    <!-- Modal Tranfer-->
    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tranfers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <br/>
                            <span id="msg"></span>
                        </button>
                </div>
                <div class="modal-body">
                    <form>
                        <form id="form">
                            <div class="form-group">
                                <label for="destination">Account Destination</label>
                                <input type="text" id="destination" placeholder="Wallet Address" class="form-control" required />
                            </div>
                            <!--FORM-GRTOUP ENDS-->

                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" id="amount" placeholder="100,000.00 SUP" class="form-control" required/>
                            </div>
                            <!--FORM-GROUP ENDS-->

                            <div class="form-group">
                                <label for="vpass">Password</label>
                                <input type="password" id="vpass" placeholder="Match password" class="form-control" required/>
                            </div>
                            <!--FORM-GROUP ENDS-->

                            <br>
                            <button id="btnSend" type="button" class="btn btn-success">Send</button>
                        </form>
                        <!--ENDS FORM-->
                    </form>
                    <!--FORM ENDS-->
                </div>
                <!--MODA-BODY ENDS-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL TRANFER ENDS-->


    <!--SUCCES MODAL-->
    <div class="modal fade" id="succes_tranfer_modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-success">
                    <h4 style="color:white;" class="modal-title"> <i class="glyphicon glyphicon-thumbs-up"></i> Thanks! </h4>
                </div>
                <div class="modal-body succes_tranfer_modal">
                    <br/>
                    <p>Your transfer has been processed</p>
                    <br/>
                    <button id="btnClose" type="button" class="btn btn-succes" data-dismiss="modal">OK</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- succes modal -->

    <!--SCRIPTS-->
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/history.js"></script>
    <script src="js/js.cookie.js"></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/currency.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

<footer class="footer-hero">

    <div class="row ends">
        <div class="container media-footer d-inline-flex">
            <div class="col-xs-2 col-md-2 media-krypto">
                <a href="https://kryptonia.io/"><img src="assets/img/krypto.png" alt="KRIPTO-PNG"></a>
            </div>

            <div class="col-xs-2 col-md-3 media-github">
                <a href="https://github.com/TheSuperiorCoin"><img src="assets/img/github.png" alt="GIT-ONG"></a>
            </div>

            <div class="col-xs-2 col-md-2 media-linked">
                <a href="https://www.linkedin.com/company/superior-coin/"><img src="assets/img/003-linkedin.png" alt="LINKD-PNG"></a>
            </div>

            <div class="col-xs-2 col-md-3 media-fb">
                <a href="https://www.facebook.com/TheSuperiorCoin/"><img src="assets/img/facebook.png" alt="FCB-PNG"></a>
            </div>

            <div class="col-xs-2 col-md-2 media-tw">
                <a href="https://twitter.com/superiorcoins"><img src="assets/img/twitter.png" alt="TWITTER-PNG"></a>
            </div>

        </div>
        <!-- CONTAINER ENDS -->
    </div>
    <!-- ROWS ENDS -->

    <div class="footer-ends">
        <h5>@Superior Coin Copyright 2018</h5>
    </div>

    <div class="container links">
        <div class="row">
            <div class="col-md-3">
                <div class="title">
                    Worldwide Offices
                    <i class="fas fa-globe"></i>
                </div>
                <div>Philipines</div>
                <div>Belize</div>
                <div>Honduras</div>
                <div>USA</div>
            </div>
            <div class="col-md-3">
                <div class="title">
                    User Guide
                    <i class="fas fa-map"></i>
                </div>
                <div><a href="https://superiorcoins.info/installing-the-superiorcoin-mining-app/">SuperiorCoin Windows Miner Installation</a></div>
                <div><a href="https://steemit.com/superiorcoin/@sydesjokes/install-superiorcoin-win64-gui-wallet-v0-12-0-0">Setting up the GUI Wallet</a></div>
                <div><a href="https://superiorcoins.info/adding-superiorcoin-sup-to-blockfolio-app/">Adding SUP on Blockfolio</a></div>
                <div><a href="https://steemit.com/blockchain/@sydesjokes/how-to-create-a-superior-coin-wallet-and-mine-superior-coin-with-minergate">Mine SUP using Minergate</a></div>
                <div><a href="https://steemit.com/superiorcoin/@sydesjokes/re-scanning-the-new-superior-coin-gui-wallet">Re-scanning GUI Wallet</a></div>
                <div><a href="https://www.youtube.com/watch?v=KcRQaD0vL-A&amp;t=175s">Kryptonia Task Creation</a></div>
                <div><a href="https://superiorcoins.info/kryptonia-user-guide/">Kryptonia Help Page</a></div>
            </div>
            <div class="col-md-3">
                <div class="title">
                    Resources
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div><a href="http://minesuperiorcoin.net/">Browser Mining</a></div>
                <div><a href="http://superior-coin.info:8081/">Blockchain Explorer</a></div>
                <div><a href="http://superiorcoinpool.com/superior-wallet-generator.html">Wallet Generator</a></div>
                <div><a href="https://mysuperiorcoin.com/#!/">Online Wallet</a></div>
                <div><a href="https://github.com/TheSuperiorCoin/GUIwallet/releases">SuperiorCoin GUI</a></div>
                <div><a href="http://superiorcoinpool.com/">Mining Pool</a></div>
            </div>
            <div class="col-md-3">
                <div class="title">
                    Social
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div><a href="https://www.facebook.com/groups/superiorcoinmining/">Facebook Mining Group</a></div>
                <div><a href="https://www.facebook.com/Kryptoniaio/">Kryptonia Facebook</a></div>
                <div><a href="https://t.me/superiorcoin">Telegram</a></div>
                <div><a href="https://www.instagram.com/superiorcoin/">SUP Instagram</a></div>
                <div><a href="https://www.instagram.com/kryptonia.io/">Kryptonia Instagram</a></div>
                <div><a href="https://twitter.com/KRYPT0N1A">Kryptonia Twitter</a></div>
                <div><a href="https://bitcointalk.org/index.php?topic=2170457">Bitcoin Talk</a></div>
                <div><a href="https://steemit.com/@kryptonia">Kryptonia Steemit</a></div>
            </div>
        </div>
        <!--ENDS ROW2-->
    </div>
    <!--ENDS CONTAINER2-->
</footer>

</html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">