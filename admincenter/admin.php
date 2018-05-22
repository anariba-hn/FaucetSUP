<?php include("../connex.php"); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/adminstyle.css">
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
    <title>Admin SUP</title>
    
    <!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    
    <head>
        <!-- As a link -->
        <nav class="navbar navbar-light bg-light d-flex justify-content-end">
          <button id="logOut">Log Out</button>
        </nav>
    </head> <!-- HEAD ENDS -->
    
    <div class="row">
          <div class="col-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-dash-tab" data-toggle="pill" href="#v-pills-dash" role="tab" aria-controls="v-pills-home" aria-selected="true">Dashboard</a>
              <a class="nav-link" id="v-pills-withdrawal-tab" data-toggle="pill" href="#v-pills-withdrawal" role="tab" aria-controls="v-pills-profile" aria-selected="false">Withdrawal</a>
              <a class="nav-link" id="v-pills-donate-tab" data-toggle="pill" href="#v-pills-donate" role="tab" aria-controls="v-pills-messages" aria-selected="false">Donate</a>
              <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
          </div> <!--COL 3 ENDS-->
          
          <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-dash" role="tabpanel" aria-labelledby="v-pills-home-tab">
                  
                  <div class="row">
                      <div class="container d-inline-flex">
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
                              <p>Total Paids</p>
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
                  
              </div>
              <div class="tab-pane fade" id="v-pills-withdrawal" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <button type="button" class="btn btn-light"><a href="">Run Cron-Job</a></button>
                    <table widh="100%" class="table table-hover">
                        <tbody>
                            <tr>
                                <td width="31%">Amount</td>
                                <td width="25%">Status</td>
                                <td width="34%">Address</td>
                                <td width="34%">Date</td>
                                <td width="10%">User</td>
                            </tr>
                        </tbody>
                        
                        <tbody>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                        </tbody>
                    </table>
              </div>
              <div class="tab-pane fade" id="v-pills-donate" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <h3>Donates</h3>
                    <table widh="100%" class="table table-hover">
                        <tbody>
                            <tr>
                                <td width="31%">Amount</td>
                                <td width="25%">Status</td>
                                <td width="34%">Address</td>
                                <td width="34%">Date</td>
                                <td width="10%">User</td>
                            </tr>
                        </tbody>
                        
                        <tbody>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                        </tbody>
                    </table>
              </div>
              <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                  
              </div>
            </div>
          </div> <!--COL 9 ENDS-->
        </div> <!--ROW ENDS-->
    
    
    <!--SCRIPTS-->
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    
</body>
</html>