<?php
include("../connex.php"); 
session_start();

if(empty($_SESSION['admin']))
{
    header("Location: ../admincenter/index.html");
}?>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <!-- Bootstrap TABLE -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
        <!-- CSS -->
        <link rel="stylesheet" href="../css/adminstylee.css">
        <!-- SCRIPTS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <title>Dashboard</title>

        <style>
            @import url('//cdn.datatables.net/1.10.2/css/jquery.dataTables.css');
            td.details-control {
                background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
                cursor: pointer;
            }

            tr.shown td.details-control {
                background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
            }
        </style>
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
                        <a class="nav-link" href="../admincenter/admins.php">Admins</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admincenter/settings.php">Settigs</a>
                    </li>
                    <li class="nav-item">
                        <a id="btnLogOut" class="nav-link" href="#">Log Out</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h3>Donations</h3>
        <div class="table-responsive">
            <table id="tblDonation" width="100%" class="display table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <td width="3%"></td>
                        <td width="10%">Name</td>
                        <td width="20%">Email</td>
                        <td width="40%">Date_Update</td>
                        <td width="10%">Total SUP</td>
                        <td width="10%">TXS</td>
                    </tr>
                </thead>

                <?php

            $query = "SELECT * FROM get_donor_list";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));

            while($row=mysqli_fetch_assoc($result))
                        {
                            echo "<tr id='", $row['rel_id'], "' >";
                                echo "<td class='details-control'></td>";
                                echo "<td>", $row['name'], "</td>";
                                echo "<td>", $row['email'], "</td>";
                                echo "<td>", $row['date_update'], "</td>";
                                echo "<td>", $row['sup'], "</td>";
                                echo "<td>", $row['txs'], "</td>";
                            echo "</tr>";
                        }
                    ?>

                    <tbody>
                        <tr data-key-1="Val 1"></tr>
                        <tr data-key-2="Val 2"></tr>
                    </tbody>

            </table>

        </div>
        <!--TABLE RESPONSIVE ENDS-->

        <script>
            function format(dataSource) {
                var html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
                $.each(dataSource, function(index, dat) {
                    

                    for (i = 0; i < dat.length; i++) {

                        var x = dat[i]['block'];
                        var y = dat[i]['amount'];
                        var z = dat[i]['hash'];

                        html += '<tr>' +
                            '<td>Block: ' + x + '</td>' +
                            '<td>Amount: ' + y + '</td>' +
                            '<td>Tx_Hash: <a href=http://superior-coin.info:8081/tx/'+z+'>' + z + '</a></td>' +
                            '</tr>';
                    }
                });

                return html += '</table>';
            }

            $(function() {

                var table = $('#tblDonation').DataTable({});

                // Add event listener for opening and closing details
                $('#tblDonation').on('click', 'td.details-control', function() {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);
                    var key = $(this).closest('tr')[0].id;
                    console.log(key);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {

                        // Open this row
                        $.post('./getInnerDonation.php', {
                            key: key
                        }).done(function(data) {
                            var arr = jQuery.parseJSON(data);
                            row.child(format(arr)).show();
                            tr.addClass('shown');
                        });
                    }
                });
            });
        </script>

        <!--SCRIPTS-->
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="../js/admin.js"></script>
        <script src="../js/bootstrap.bundle.js"></script>
    </body>

    </html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">