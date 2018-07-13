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
                    <a class="nav-link" href="../admincenter/dashboard.php" >Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admincenter/withdrawals.php">Withdrawals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admincenter/donations.php">Donations</a>
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
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    
</body>
</html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">