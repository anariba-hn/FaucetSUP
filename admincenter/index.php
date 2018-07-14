<?php
session_destroy();
?>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminCenter</title>
    <link rel="shortcut icon" type="image/png" href="../assets/img/sup-logo.png">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/adminstylee.css">
</head>

<body>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-4">
               <div class="logo">
                   <img src="../assets/img/supMenu.png" alt="">
               </div>
                <form class="loginForm" action="../admincenter/access.php" method="post">
                  <div class="form-group">
                    <label for="exampleInputEmail1">User</label>
                    <input type="text" name="useradmin" class="form-control" id="useradmin" aria-describedby="nick" placeholder="Nickname">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="pass" class="form-control" id="pass" placeholder="Password">
                  </div>
                  <button type="submit" class="btn btn-success">LogIn</button>
                </form>
            </div> <!--ENDS COL MD-->
        </div> <!--ENDS ROW-->
    </div> <!--ENDS CONTAINER-->
    
    <!--SCRIPTS-->
    <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
