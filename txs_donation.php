<?php

require "/var/www/html/vendor/autoload.php";

include ("/var/www/html/FaucetSUP/connex.php");

use Superior\Wallet;
$wallet = new Superior\Wallet();
$integArray = array(); // INTEGRATED ADDRESS TO EVALUATED BETWEEN RUN BLOCK STATEMENT
$totalmount = 0; // TOTAL AMOUNT OF TXS DONATIONS
$totaltxs = 0; // TOTAL TXS EVALUATED
//$cnn =     CONNECTION FROM ./FaucetSUP/connex.php ;

#
## GETTING THE NEXT RUN BLOCK
#

$sql = "SELECT next_run_block FROM get_tx_log ORDER BY id_log DESC limit 1";
if(!$result = mysqli_query($cnn, $sql))
    exit(mysqli_error($cnn));

if(mysqli_num_rows($result) > 0)
{
    $data = mysqli_fetch_row($result);
    $runBlock = $data[0];
}

#
##SET THE GET_TX_LOG TABLE
#
$height = $wallet->getHeight();
$json = json_decode($height);
$curBlock = (int)$json->height;
$nextRun = $curBlock - 100;
$query = "INSERT INTO get_tx_log (block, date_run, next_run_block) VALUES('$curBlock', now(), '$nextRun')";
if (!$result = mysqli_query($cnn, $query))
    exit(mysqli_num_rows($cnn));
else{
    echo "<br /><h2>GET_TX_LOG CREATED</h2>";
}

$lastID = mysqli_insert_id($cnn);

#
## GETTING THE NEXT RUN BLOCK
#

$sql = "SELECT next_run_block FROM get_tx_log WHERE id_log = '$lastID'";
if(!$result = mysqli_query($cnn, $sql))
    exit(mysqli_error($cnn));

if(mysqli_num_rows($result) > 0)
{
    $data = mysqli_fetch_row($result);
    $nextRun = $data[0];
}


#
## GETTING THE LAST PAYMENTID
#

$query = "SELECT payment_id FROM donation order by id DESC limit 1";
if (!$result = mysqli_query($cnn, $query))
    exit(mysqli_error($cnn));
if(mysqli_num_rows($result) > 0)
{
    $data = mysqli_fetch_row($result);
    $paymentID = $data[0];
}

#
## PREPARE ARRAY OF PAYMETSID ON DONATION DB TO COMPARE WITH THE BULKPAYMENTS FUNCTION
#
$jsonBulk = $wallet->getBulkPayments($paymentID, $runBlock);
$bulk = json_decode($jsonBulk);

$query = "SELECT * FROM donation WHERE block >= '$runBlock'";
if (!$result = mysqli_query($cnn, $query))
    exit(mysqli_error($cnn));
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_row($result))
    {
        $integrated = $row[4];
        $integArray[count($integArray)] = $integrated;
    }
}

#
## VERIFY IF TX ALREADY EXIST ON TABLE
#
if(!isset($bulk))
{
    foreach($bulk->payments as $value => $payments)
    {
        #PREPARE THE PAYMENT ID WITHOUT ZEROS AT FRONT OR END
        $pid = $payments->payment_id;
        $tags = strip_tags($pid);
        $explode = trim($tags, "0");

        $request = "SELECT * FROM get_tx_in WHERE tx_hash = '$payments->tx_hash' ";
        if(!$result = mysqli_query($cnn, $request))
            exit(mysqli_error($cnn));
        if(mysqli_num_rows($result) > 0)
        {
            if(($key = array_search($explode, $integArray)) !== false)
            {
                unset($integArray[$key]);
                echo "<br /><h2>THIS PAYMENTS ID WILL BE OMITTED BECAUSE WAS PROCESS BEFORE</h2><br />";
                echo "<br />". $explode . "<br />";
            }
        }
    }
}


#
## LOOP THE BULKPAYMENT AND SAVE ON TX_IN DB
#

if(!empty($integArray) && !isset($bulk))
{
    foreach($bulk->payments as $value => $payments)
    {
        #PREPARE THE PAYMENT ID WITHOUT ZEROS AT FRONT OR END
        $pid = $payments->payment_id;
        $tags = strip_tags($pid);
        $explode = trim($tags, "0");

        #
        ##API CALL TO GET THE DONATION DATE PER EACH
        #
        $bblock = $payments->block_height;
        $apicall = "http://superior-coin.info:8081/api/search/".$bblock ;
        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$apicall);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        // Will dump a beauty json :3
        $json = json_decode($result, true);
        $datetx = $json['data']['timestamp_utc'];

        if(in_array($explode, $integArray))
        {

            #
            ## VERIFY IF EMAIL ALREADY EXIST ON DONOR_LIST WILL UPDATE DONOR_ID FROM LAST DONATION
            #
            $query5 = "SELECT email FROM donation WHERE payment_id = '$explode'";
            if(!$result5 = mysqli_query($cnn, $query5))
                exit(mysqli_error($cnn));
            if(mysqli_num_rows($result5)> 0)
            {
                $row4 = mysqli_fetch_row($result5);
                $email = $row4[0];
            }
            
            $sql = "SELECT rel_id FROM get_donor_list WHERE email = '$email'";
            if(!$result = mysqli_query($cnn, $sql))
                exit(mysqli_error($cnn));
            if(mysqli_num_rows($result) > 0)
            {
                $data = mysqli_fetch_row($result);
                $rel_id = (int)$data[0];

                $update = "UPDATE donation SET donor_id = '$rel_id' WHERE integrated = '$explode'";
                if(!$result = mysqli_query($cnn, $update))
                    exit(mysqli_error($cnn));
            }

            #
            ##PREPARE FIELDS FOR GET_TX_IN
            #
            $query = "SELECT donor_id FROM donation WHERE payment_id = '$explode'";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));
            $row = mysqli_fetch_row($result);
            $donor_id = (int)$row[0]; 

            $query3 = "SELECT id_log FROM get_tx_log WHERE next_run_block = '$nextRun'";
            if(!$result3 = mysqli_query($cnn, $query3))
                exit(mysqli_error($cnn));
            $row2 = mysqli_fetch_row($result3);
            $logId = (int)$row2[0];

            $jsonBlock = (int)$payments->block_height;
            $amount    = number_format($payments->amount / 100000000, 0, "", "");
            $tx_hash   = $payments->tx_hash;

            $insert = "INSERT INTO get_tx_in (donor_id, block, date_tx, log_id, amount, tx_hash) VALUES('$donor_id', '$jsonBlock','$datetx' , '$logId','$amount', '$tx_hash')";
            if (!$result4 = mysqli_query($cnn, $insert))
            {
                echo "<br /><h2>PaymentID: </h2>" . $pid . " not be insertet on get_tx_in";
                echo exit(mysqli_error($cnn));
            }
            else{
                #
                ## PREPARE VALUES FOR TABLE GET_DONOR_LIST
                #
                $sups = 0; //TOTAL OF SUPS DONATED PER EACH
                $donorTx = 1; // TOTAL OF TXS DONATED PER EACH

                $query4 = "SELECT name FROM donation WHERE payment_id = '$explode'";
                if(!$result4 = mysqli_query($cnn, $query4))
                    exit(mysqli_error($cnn));
                if(mysqli_num_rows($result4)>0)
                {
                    $row3 = mysqli_fetch_row($result4);
                    $name = $row3[0];
                }

                $query6 = "SELECT sup FROM get_donor_list WHERE email = '$email' ";
                if (!$result6 = mysqli_query($cnn, $query6))
                    exit(mysqli_error($cnn));
                if(mysqli_num_rows($result6) > 0)
                {
                    $row5 = mysqli_fetch_row($result6);
                    $sups = (int)$row5[0] + $amount;
                }else{
                    $sups = $amount;
                }

                $query7 = "SELECT txs FROM get_donor_list WHERE email = '$email'";
                if (!$result7 = mysqli_query($cnn, $query7))
                    exit(mysqli_error($cnn));
                if (mysqli_num_rows($result7) > 0)
                {
                    $row6 = mysqli_fetch_row($result7);
                    $donorTx = $donorTx + (int)$row6[0];
                }else{
                    $donorTx = 1;
                }

                $query8 = "SELECT email FROM get_donor_list WHERE email = '$email'";
                if (!$result8 = mysqli_query($cnn, $query8))
                    exit(mysqli_error($cnn));
                if (mysqli_num_rows($result8) > 0)
                {
                    $update = "UPDATE get_donor_list SET date_update = now(), sup = '$sups', txs = '$donorTx' WHERE email = '$email'";
                    if (!$result9 = mysqli_query($cnn, $update))
                        exit(mysqli_error($cnn));
                    else{
                        echo "<br /><h2>GET_TX_IN & GET_DONOR_LIST UPDATED</h2>";
                        echo "<br />" . $explode;
                    }
                }else{
                    $update2 = "INSERT INTO get_donor_list (rel_id, name, email, date_create, sup, txs) VALUES('$donor_id' ,'$name', '$email', now(), '$sups', '$donorTx')";
                    if (!$result10 = mysqli_query($cnn, $update2))
                        exit(mysqli_error($cnn));
                    else{
                        echo "<br /><h2>GET_TX_IN & GET_DONOR_LIST INSERT</h2>";
                        echo "<br />" . $explode;
                    }

                }

                #
                ## ADD REDUCIBLE AMOUNT TO DONATION TABLE FOR HYPERLINKS
                #

                if($name != "" && $email != "")
                {
                    $query9 = "UPDATE donation SET amount = '$amount' WHERE payment_id = '$explode'";
                    if(!$result11 = mysqli_query($cnn, $query9))
                        exit(mysqli_error($cnn));
                    else{
                        echo "<br /><h2>AMOUNT ON DONATION TABLE UPDATED</h2>";
                    }

                }

            }

            #
            ##SETTIN VALUES FOR GET_TX_LOG
            #
            $totalmount = $totalmount + $amount;
            $totaltxs ++;
        }

    }
}
else{
    #
    ##UPDATE VARIABLES FOR LOG
    #
    $totalmount = 0;
    $totaltxs   = 0;
    echo "<br /><h3>DOES NOT MATCH ANY DONATION</h3><br />";

}


#
##UPDATED GET_TX_LOG FOR NEXT RUN
#
$query = "UPDATE get_tx_log SET txs = '$totaltxs', amount = '$totalmount' WHERE id_log = '$lastID'";
if (!$result = mysqli_query($cnn, $query))
    exit(mysqli_num_rows($cnn));
else{
    echo "<br /><h2>GET_TX_LOG UPDATED</h2>";
}

?>