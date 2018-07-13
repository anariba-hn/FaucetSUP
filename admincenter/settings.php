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
                    <a class="nav-link" href="../admincenter/donations.php">Donations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admincenter/admins.php" >Admins</a>
                </li>
                <li class="nav-item">
                    <a id="btnLogOut" class="nav-link" href="#">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="settings">
        <h3>Settings</h3>
        <br/>
        <form name="myForm">
            <h4>Reward Amount</h4>
            <input type="number" name="reward" id="reward">
            <br/>
            <button id="btnReward" type="button">Save</button>
            <br/>
            <h4>Set Time Control - Mints.</h4>
            <input type="number" name="timeSet" id="time">
            <br/>
            <button id="btnTime" type="button">Save</button>
            <br/>
            <h4>Set Cron-Transfer Amount</h4>
            <input type="number" name="cron-transfer" id="cron">
            <br/>
            <button id="btnCron" type="button">Save</button>
            <br/>
            <h4>Set new AddOn - href.</h4>
            <input type="text" name="href" id="href">
            <br/>
            <button id="btnRef" type="button">Save</button>
        </form>
    </div>
    
    <!--SCRIPTS-->
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">