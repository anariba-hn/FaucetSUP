<?php include("./connex.php");?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Description" content="Author: Superior Coin, Category: Cryptocurrencie, Description: History User page section for Superior Coin Faucet.">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/faucetstylee.css">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <title>SuperiorFaucet</title>
    <link rel="shortcut icon" type="image/png" href="./assets/img/sup-logo.png">

    <!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>
</head>

<body>

    <header>
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
                        <a class="nav-link" href="#modal3" data-toggle="modal" data-target="#">My History</a>
                    </li>
                    <li class="nav-item">
                        <a id="btnLogOut" class="nav-link" href="#">Log Out</a>
                    </li>
                    <li class="nav-item google_translate_element">
                            <div id="google_translate_element"></div>
                            <script>
                            function googleTranslateElementInit() {
                              new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'es', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: 'UA-120818445-1'}, 'google_translate_element');
                            }
                            </script>
                            <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                        </li>
                </ul>
            </div>
        </nav>
    </header>

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
                <h5>Paid</h5>
                <span id="spnPaid">0</span>
            </div>
            
            <div class="col-sm-3" style="text-align: center;">
                <h5>Withdraws</h5>
                <span id="spnWithdraws">0</span>
            </div>
        </div>
        <!-- ENDS ROW 2-->

        <div class="container payments-container">
            <div class="table-responsive ">
                <h2>Donations</h2>
                <table width="100%" class="table table-hover">
                    <tbody>
                        <tr>
                            <td>Hyperlink</td>
                            <td>Live</td>
                        </tr>
                    </tbody>

                    <?php
                    #CATCHING THE COOKIE FROM SERVER SIDE
                    $walle = $_COOKIE["walle"];

                    $query = "SELECT user_email FROM users WHERE id_user = '$walle'";
                    if(!$result = mysqli_query($cnn, $query))
                        exit(mysqli_error($cnn));
                    else{
                        $data = mysqli_fetch_row($result);
                        $email = $data[0];
                        }

                    $query2 = "SELECT * FROM donation WHERE email = '$email' AND hyperlink != '' AND amount != ''";
                    if(!$result2 = mysqli_query($cnn, $query2))
                        exit(mysqli_error($cnn));
                    if(mysqli_num_rows($result2) > 0)
                    {
                        while($row = mysqli_fetch_assoc($result2))
                        {
                            echo "<tr>";
                            echo "<td>", $row['hyperlink'], "</td>";
                            echo "<td>", $row['amount'], " - Outputs</td>";
                            echo "</tr>";
                        }
                    }else{

                        echo "<p class=\"text-danger\">You do not have any donation yet</p>";
                    }
                    ?>
                </table>
            </div>
        </div>

        <div class="payments-container">
            <div class="table-responsive succes-tbl">
               <br/>
               <h2>Succesfully Transferred</h2>
                <table width="100%" class="table table-hover" id="tb-succes">
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
                        
                            $query = "SELECT * FROM vf_payments_succes WHERE user_id = '$walle'";

                            #SETING PAGINATION VARIABLES
                            $result = mysqli_query($cnn, $query);
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
                            $paginateData = "SELECT * FROM vf_payments_succes WHERE user_id = '$walle' LIMIT " .$per_page. " OFFSET " .$offset. "";
                            if(!$result = mysqli_query($cnn, $paginateData))
                                exit(mysqli_error($cnn));
                
                            while($row=mysqli_fetch_assoc($result))
                            {
                                echo "<tr>";
                                    echo "<td>", $row['id_succes'], "</td>";
                                    echo "<td>", $row['payments_balance'], "-SUP</td>";
                                    echo "<td><p class=\"text-success\">", $row['payments_status'], "</p></td>";
                                    echo "<td>", $row['payments_wallet'], "</td>";
                                    echo "<td><a href='http://superior-coin.info:8081/tx/".$row['payments_hash']."'>", $row['payments_hash'], "</a></td>";
                                    echo "<td>", $row['payments_date'], "</td>";
                                    echo "<td>", $row['user_id'], "</td>";
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

            </div>
            <!-- TABLE-RESPONSIVE ENDS -->
            
            <div class="table-responsive error-tbl">
               <br/>
               <h2>Transfer Errors</h2>
                <table width="100%" class="table table-hover" id="tb-error">
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
                                    
                                $query2 = "SELECT * FROM vf_payments_error WHERE user_id = '$walle'";

                                #SETING PAGINATION VARIABLES
                                $result = mysqli_query($cnn, $query);
                                $num_rows_error = $result->num_rows;
                                $per_page_error     = 5;
                                $offset_error       = 0;
                                $current_page_error = '';
                            
                                #CALCULATE THE PAGE LEFT TO SHOW 
                                $no_off_page_error = ceil($num_rows_error / $per_page_error); //ceil function round int
                                
                                #LOGIC TO HANDLE DATA OUTPUT PER PAGINATION
                                if(isset($_GET['page'])){
                                    $current_page_error = $_GET['page'];
                                    $offset_error = ($per_page_error * $current_page_error) - $per_page_error ;
                                }
                                
                                #NEW QUERY WITH PARAMETERS
                                $paginateDataError = "SELECT * FROM vf_payments_error WHERE user_id = '$walle' LIMIT " .$per_page_error. " OFFSET " .$offset_error. "";

                                if(!$result = mysqli_query($cnn, $paginateDataError))
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

                    <!--PAGINATION-->

                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="<?php
                                               if($current_page_error == 1 || $current_page_error == ''){echo 'disabled';}?> page-item">
                                        <a class="page-link" href="<?php
                                               if($current_page_error == 1 || $current_page_error == ''){
                                                   echo " # ";
                                               }else{
                                                    echo "?page=". ($current_page_error - 1);   
                                               }
                                               ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <?php for($i = 1; $i <= $no_off_page_error; $i ++): ?>
                                    <li class="<?php
                                               if($current_page_error == $i){
                                                   echo 'active';
                                               }
                                               ?> page-item">
                                        <a class="page-link" href="?page=<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                    <?php endfor; ?>
                                    <li class="<?php
                                               if($current_page_error == $no_off_page_error){echo 'disabled';}?> page-item">
                                        <a class="page-link" href="<?php
                                               if($current_page_error == $no_off_page_error){
                                                   echo " # ";
                                               }elseif($current_page_error == ''){
                                                   echo "?page=2";
                                               }else{
                                                    echo "?page=". ($current_page_error + 1);   
                                               }
                                               ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <!-- ENDS PAGINATIONS -->

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
                    <h5 class="modal-title">Tranfers Amount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <br/>
                        </button>
                </div>
                <div class="modal-body">
                    <form>
                        <form id="form">
                            <div class="form-group">
                                <label for="destination" id="account">Account Destination</label>
                                <input type="text" id="destination" placeholder="Wallet Address" class="form-control" required />
                            </div>
                            <!--FORM-GRTOUP ENDS-->

                            <div class="form-group">
                                <label for="amount" id="mount">Amount</label>
                                <input type="text" id="amount" placeholder="100,000.00 SUP" class="form-control" required/>
                            </div>
                            <!--FORM-GROUP ENDS-->

                            <div class="form-group">
                                <label for="vpass" id="pass">Password</label>
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
                    <p>Your transfer has been processed. Please wait for it to complete and it will output in your history section.</p>
                    <div class="row">
                        <div class="col">
                            <img src="./assets/img/success.png" alt="success-png">
                        </div>
                    </div>
                    <br/>
                    <button id="btnClose" type="button" class="btn btn-succes" data-dismiss="modal">OK</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- succes modal -->

    <!--ERROR LOG DIV-->

        <div id="errorLog" class="errorlog">
            <div class="error-hero">
                <i class="fas fa-exclamation-triangle"><span id="logMsg"> ErrorLog</span></i>
            </div>
        </div>

        <!--ENDS ERROR LOG-->

    <!--SCRIPTS-->
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/history.js"></script>
    <script src="js/js.cookie.js"></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/currency.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

<footer class="footer-hero">

    <div class="row ends">
            <div class="container media-footer d-inline-flex flex-wrap">
                <div class="col-xs-2 col-md-2 media-icon">
                    <a href="https://kryptonia.io/" target="_blank" rel="noopener"><img src="assets/img/krypto.png" alt="KRIPTO-PNG"></a>
                </div>

                <div class="col-xs-2 col-md-2 media-icon">
                    <a target="_blank" rel="noopener" href="https://www.linkedin.com/shareArticle?mini=true&url=https://faucet.the-superior-coin.net/&title=Visit%20and%20start%20earning%20Superior%20Coin
                    &summary=My%20favorite%20developer%20program&source=SuperiorFaucet">
                    <img src="assets/img/003-linkedin.png" alt="LINKD-PNG">
                    </a>
                </div>

                <div class="col-xs-2 col-md-2 media-icon">
                    <a href="https://superior-coin.com" target="_blank" rel="noopener"><img src="./assets/img/fsuper.png" alt="SUP-PNG"></a>
                </div>

                <div class="col-xs-2 col-md-2 media-icon">
                    <a href="https://discord.gg/swsHbJH" target="_blank" rel="noopener"><img src="./assets/img/discordd.png" alt="DISCORD-PNG"></a>
                </div>

                <div class="col-xs-2 col-md-2 media-icon">
                    <!--<a href="https://www.facebook.com/TheSuperiorCoin/"></a>-->
                    <a  target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Ffaucet.the-superior-coin.net%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">
                    <img src="assets/img/facebook.png" alt="FCB-PNG">
                    </a>
                    <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.1';
                          fjs.parentNode.insertBefore(js, fjs);
                          }(document, 'script', 'facebook-jssdk'));
                    </script>
                </div>

                <div class="col-xs-2 col-md-2 media-icon">
                    <!--<a href="https://twitter.com/superiorcoins"></a>-->
                    <a target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?hashtags=Crypto,BlockChain&amp;original_referer=https%3A%2F%2Fdeveloper.twitter.com%2Fen%2Fdocs%2Ftwitter-for-websites%2Ftweet-button%2Foverview&amp;ref_src=twsrc%5Etfw&amp;related=twitterapi%2Ctwitter&amp;text=Visit%20and%20start%20earning%20Superior%20Coin&amp;tw_p=tweetbutton&amp;url=https%3A%2F%2Ffaucet.the-superior-coin.net&amp;via=superiorcoins">
                        <img src="assets/img/twitter.png" alt="TWITTER-PNG">
                    </a>
                </div>

            </div> <!-- CONTAINER ENDS -->
        </div> <!-- ROWS ENDS -->

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