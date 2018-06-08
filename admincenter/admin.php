<?php include("../connex.php"); 

if(isset($_POST['useradmin']))
{
    $admin = $_POST['useradmin'];
    $pw    = $_POST['pass'];

        $query = "SELECT user_password FROM admincenter WHERE user_admin = '$admin'";
        if(!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
        $data = mysqli_fetch_row($result);
        $dbPass = (string) $data[0];

    if($pw != $dbPass)
    {
     header("Location: ../admincenter/index.html");
    }
    
}else{
    header("Location: ../admincenter/index.html");
}

?>
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
    <link rel="stylesheet" type="image/png" href="../assets/img/fsuper.png">

    <!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

    <head>
        <!-- As a link -->
        <nav class="navbar navbar-light bg-light d-flex justify-content-end">
            <button id="btnlogOut" class="btn btn-warning">Log Out</button>
        </nav>
    </head>
    <!-- HEAD ENDS -->

    <div class="row">
        <div class="col-3">
            <div class="nav flex-column nav-pills left-nav" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-dash-tab" data-toggle="pill" href="#v-pills-dash" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a class="nav-link" id="v-pills-withdrawal-tab" data-toggle="pill" href="#v-pills-withdrawal" role="tab" aria-controls="v-pills-profile" aria-selected="false">Withdrawal</a>
                <a class="nav-link" id="v-pills-donate-tab" data-toggle="pill" href="#v-pills-donate" role="tab" aria-controls="v-pills-messages" aria-selected="false">Donate</a>
                <a class="nav-link" id="v-pills-admins-tab" data-toggle="pill" href="#v-pills-admins" role="tab" aria-controls="v-pills-messages" aria-selected="false">Admins</a>
                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
        </div>
        <!--COL 3 ENDS-->

        <div class="col-9 back">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-dash" role="tabpanel" aria-labelledby="v-pills-home-tab">

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
                    <br/>
                    <button type="button" class="btn btn-light"><a href="">Run Cron-Job</a></button>
                    <br/>
                    <br/>
                    <div class="table-responsive">
                        <table widh="100%" class="table table-hover">
                            <thead>
                                <tr>
                                    <td width="31%">ID</td>
                                    <td width="25%">Balance</td>
                                    <td width="34%">Status</td>
                                    <td width="34%">Wallet</td>
                                    <td width="50%">Date</td>
                                    <td width="25%">User</td>
                                </tr>
                            </thead>

                            <?php
                            $query = "SELECT * FROM vf_payments";
                            if(!$result = mysqli_query($cnn, $query))
                                            exit(mysqli_error($cnn));
                            while($row=mysqli_fetch_assoc($result))
                                        {
                                            echo "<tr>";
                                                echo "<td>", $row['id_payments'], "</td>";
                                                echo "<td>", $row['payments_balance'], "-SUP</td>";
                                                echo "<td><p class=\"text-success\" id=\"success\">", $row['payments_status'], "</p></td>";
                                                echo "<td>", $row['payments_wallet'], "</td>";
                                                echo "<td>", $row['payments_date'], "</td>";
                                                echo "<td>", $row['user_id'], "</td>";
                                            echo "</tr>";
                                        }
                            ?>
                        </table>
                    </div> <!--TABLE RESPONSIVE ENDS-->
                </div>
                <div class="tab-pane fade" id="v-pills-donate" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <h3>Donates</h3>
                       <div class="table-responsive">
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
                    </div> <!--TABLE RESPONSIVE ENDS-->   
                </div>
                <div class="tab-pane fade admins" id="v-pills-admins" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <br>
                    <h3>Admins</h3>
                    <button type="button" class="btn btn-outline-success" href="#modalNewAdmin" data-toggle="modal" data-target="#modalNewAdmin">New Admin</button>
                    <br/>
                    <br/>
                    <div class="table-responsive">
                    <table widh="100%" class="table table-hover">
                        <thead>
                            <tr>
                                <td width="25%">ID</td>
                                <td width="25%">User</td>
                                <td>Edit</td>
                                <td>Delete</td>
                            </tr>
                        </thead>

                        <?php
                        $query = "SELECT * FROM admincenter";
                        if(!$result = mysqli_query($cnn, $query))
                                        exit(mysqli_error($cnn));
                        while($row=mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>";
                                            echo "<td>", $row['id'], "</td>";
                                            echo "<td>", $row['user_admin'], "</td>";
                                            echo "<td><button type='button' class='btn btn-outline-warning edit_data' href='#modalEditAdmin' data-toggle='modal' data-target='#modalEditAdmin' id=",$row['id']," value='edit'></button></td>";
                                            echo "<td><button type='button' class='btn btn-outline-danger delete_data' href='#alert_modal' data-toggle='modal' data-target='#alert_modal' id=",$row['id'],"></button></td>";
                                        echo "</tr>";
                                    }
                        ?>

                    </table>
                    </div> <!--ENDS TABLE RESPONSIVE-->
                </div>
                <div class="tab-pane fade settings" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
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
                    </form>

                </div>
            </div>
        </div>
        <!--COL 9 ENDS-->
    </div>
    <!--ROW ENDS-->


    <!-- NEW ADMIN MODAL -->
    <div class="modal fade" id="modalNewAdmin" tabindex="-1" role="dialog" aria-labelledby="modalNewAdmin" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Administrator</h5>
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
                                <label for="users-admin">Nick Name</label>
                                <input type="text" id="nick" placeholder="nickname" class="form-control" required />
                            </div>
                            <!--FORM-GRTOUP ENDS-->

                            <div class="form-group">
                                <label for="passw">Password</label>
                                <input type="password" id="passw" placeholder="password" class="form-control" required/>
                            </div>
                            <!--FORM-GROUP ENDS-->

                            <br>
                            <button id="btnNewAdmin" type="button" class="btn btn-success">Send</button>
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
    <!-- ENDS NEW ADMIN MODAL -->

    <!--EDIT ADMIN MODAL-->
    <div class="modal fade" id="modalEditAdmin" tabindex="-1" role="dialog" aria-labelledby="modalEditAdmin" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <br/>
                        </button>
                </div>
                <div class="modal-body">
                    <form>
                        <form id="form">
                            <p id="getID"></p>
                            <div class="form-group">
                                <label for="users-admin">Nick Name</label>
                                <input type="text" id="editNick" placeholder="nickname" class="form-control" required />
                            </div>
                            <!--FORM-GRTOUP ENDS-->

                            <div class="form-group">
                                <label for="passw">Password</label>
                                <input type="password" id="editPass" placeholder="password" class="form-control" required/>
                            </div>
                            <!--FORM-GROUP ENDS-->

                            <br>
                            <button id="btnUpdate" type="button" class="btn btn-success">Update</button>
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
    <!-- ENDS EDIT ADMIN MODAL -->

    <!--MODAL ALERT-->
    <div class="modal fade" id="alert_modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-error">
                    <h3 style="color:black;" class="modal-title">Wait!</h3>
                </div>
                <div class="modal-body">
                    <br/>
                    <p id="msgAlert">Are you shure wants to delete this user ?</p>
                    <br/>
                </div>
                <div class="modal-footer">
                    <button id="btnConfirm" type="button" type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal ALERT ENDS-->

    <!--SCRIPTS-->
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>

</body>

</html>