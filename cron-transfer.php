<?php

require "/var/www/html/vendor/autoload.php";

include ("/var/www/html/FaucetSUP/connex.php");

 use Superior\Wallet;
 $walletFaucet = new Superior\Wallet();
 
#
## GET THE CRON-COUNT-AMOUNT FROM CONFG DB
#
$sql = "SELECT value FROM confg WHERE id_confg = '4'";
if(!$result = mysqli_query($cnn, $sql))
	exit(mysqli_error($cnn));
else{
	$data = mysqli_fetch_row($result);
	$requestcount = (int)$data[0];
}


 //$cnn = include
 //$requestcount      = set variable from admindcenter
 $response          = array(); //json_response
 $cron_address      = array(); //address to transfer
 $cron_amounts      = array(); //amount to transfer
 $cron_errors       = array(); //address with errors
 $destinations      = array(); // object with amounts and transfer

$query = "SELECT * FROM vf_payments WHERE payments_status = 'pending'";
if (!$result = mysqli_query($cnn, $query)) 
	exit(mysqli_error($cnn));
 
 while ($row= mysqli_fetch_array($result)) 
 {
	$address= $row['payments_wallet'];
	$amount = $row['payments_balance'];
	$cron_address[count($cron_address)] = $address;
	$cron_amounts[count($cron_amounts)] = $amount;

	$destinations[count($destinations)] = 
	(object) array('amount' => $amount, 'address' => $address);
 }

 if (count($cron_amounts) >= $requestcount)
{	
		
	echo "</br><h3>There are ". count($cron_amounts)." no processed withdrawals in our database . </br> 
	We will processing in group/lot of ". $requestcount." to run Superior Transfer cronjob.</br>";
	echo "Running cronjob... </h3>";
	$cron_amounts = array_slice($cron_amounts, 0, $requestcount);
	$destinations = array_slice($destinations, 0, $requestcount);
    $total_amount = array_sum($cron_amounts);
     
    #SPLIT TRASNFER REQUEST
	$options2 = [
	    'destinations' => $destinations
	];
	
	$sup_transfer = $walletFaucet->transfer($options2);
	echo "</br>".$sup_transfer."</br>";
	$transfer_result = json_decode($sup_transfer);

	#VALIDATING IF TRANSFER SUCCES
	
	//if "fee" exists in transfer response means that transfe was successfull
	if (isset($transfer_result->{'fee'})) 
	{
		echo "</br> <h1>Success Transfer!</h1> </br>";
		$transfer_fee = $transfer_result->{'fee'};
		$transfer_hash = $transfer_result->{'tx_hash'};
		echo 
		"Transfer Fee: ".$transfer_fee. 
		"</br>Transfer Hash: ".$transfer_hash.
		"</br>Total Number of Transfers: ".$requestcount.
		"</br>Total Amount Transfered: ".$total_amount.
		"</br>------------------------------------------</br>";

		$hash_transfer=$transfer_hash;

		for ($i=0; $i < $requestcount; $i++) {
			
			echo "</br>--> Running transfer number: " .$i. "/ with amount of:" .$cron_amounts[$i] . "address: ". $cron_address[$i];
				
			/*$db2->query("update tbl_withdrawal set status=1,reccode='".$hash_transfer."',fee=".$transfer_fee." where withdrawal_id=".$wid."");
			*/
		
			$query2 = "SELECT user_id FROM vf_payments WHERE payments_wallet = '$cron_address[$i]'";
		    if (!$result = mysqli_query($cnn,$query2)) 
		        exit(mysqli_error($cnn));

		    if (mysqli_num_rows($result) > 0) 
		    {
		        $data = mysqli_fetch_row($result);
		        $userid = (int) $data[0];
		    }

			$query3 = "INSERT INTO vf_payments_succes (payments_balance, payments_status, payments_wallet, payments_hash, payments_date, user_id) VALUES ('$cron_amounts[$i]','succes', '$cron_address[$i]', '$hash_transfer', now(), '$userid')";
			if (!$result = mysqli_query($cnn, $query3)) 
			{
				echo "</br>Transer number: ".$i." not be inserted on db";	
				echo mysqli_error($cnn); 		
			}
		}


		#HERES GOES THE CODE TO UPDATE VF_PAYMENTS TABLE
		
		for ($x=0; $x < $requestcount; $x++)
		{

			$query3 = "DELETE FROM vf_payments WHERE payments_wallet = '$cron_address[$x]'";
			if (!$result = mysqli_query($cnn,$query3)) 
		        exit(mysqli_error($cnn));
		}

		
	    echo "</br><h3>".$requestcount. " Withdrawal Transfers has been proceessed with hash number:".$hash_transfer."</h3>" ;
	    
	//if "fee" not exists in transfer response means that error exists
	} else {

		$transfer_errorcode = $transfer_result->{'code'};
		$transfer_errormessage = $transfer_result->{'message'};

		if($transfer_errorcode == '5')
		{	
			echo "<br/> <h3>Error on API call</h3><br/>";
		}else if($transfer_errorcode == '4')
		{
			echo "<br/> <h3>Error on API call</h3><br/>";
		}else{

		#PREPARE STRING FROM JSON SPLIT RESPONSE
		list($code, $walletmsg) = explode(':', $transfer_result->{'message'});
		#DELETE SPACES FROM STRING
		$invalidWallet = str_replace(' ', '', $walletmsg);


		#INSERT DATA OF INVAILD TRANFER
		
		$query2 = "SELECT id_payments FROM vf_payments WHERE payments_wallet = '$invalidWallet'";
		    if (!$result = mysqli_query($cnn,$query2)) 
		        exit(mysqli_error($cnn));

		    if (mysqli_num_rows($result) > 0) 
		    {
		        $data = mysqli_fetch_row($result);
		        $paymentID = (int) $data[0];
		        
		    }

		$query3 = "SELECT payments_balance FROM vf_payments WHERE id_payments = '$paymentID'";
		if (!$result = mysqli_query($cnn,$query3)) 
		        exit(mysqli_error($cnn));
		    if (mysqli_num_rows($result) > 0) 
		    {
		        $data2 = mysqli_fetch_row($result);
		        $invalidBalance = (int) $data2[0];
		    }

		$query4 = "SELECT user_id FROM vf_payments WHERE id_payments = '$paymentID'";
		if (!$result = mysqli_query($cnn,$query4)) 
		        exit(mysqli_error($cnn));
		    if (mysqli_num_rows($result) > 0) 
		    {
		        $data3 = mysqli_fetch_row($result);
		        $userid = (int) $data3[0];
		    }

		$insert = "INSERT INTO vf_payments_error (payments_balance, payments_status, payments_wallet, payments_date, user_id) VALUES ('$invalidBalance', 'error', '$invalidWallet', now(), '$userid')";  
		if (!$result = mysqli_query($cnn, $insert)) 
			{
				echo "</br>Wallet: ".$invalidWallet." not be inserted on db payments_error";	
				echo mysqli_error($cnn); 		
			}
			else{

				#UPDATE PAYMENTS DB WHERE CRON RUNS
				
				$query5 = "DELETE FROM vf_payments WHERE id_payments = '$paymentID'";
				if (!$result = mysqli_query($cnn,$query5)) 
		        	exit(mysqli_error($cnn));
		        else{
		        	echo "</br> <h2>This Wallet Address: ".$invalidWallet." has been deledet</h2>";
		        }

		        #UPDATE BALANCE FROM WALLET NOT PROCESSED
		        
		        $query6 = "SELECT wallet_unlock FROM wallet WHERE user_id = '$userid'";
		        if (!$result = mysqli_query($cnn,$query6)) 
		        	exit(mysqli_error($cnn));
		        if (mysqli_num_rows($result) > 0) 
		        {
		        $data4 = mysqli_fetch_row($result);
		        $old_balance = (int) $data4[0];
		    	}

		    	$newBalance = $old_balance + $invalidBalance;

		    	$query7 = "SELECT wallet_withdraws FROM wallet WHERE user_id = '$userid'";
			    if (!$result = mysqli_query($cnn,$query7)) 
			        exit(mysqli_error($cnn));
			    if (mysqli_num_rows($result) > 0) 
			    {
		        $data5 = mysqli_fetch_row($result);
		        $wallet_withdraws = (int) $data5[0];
		        }

		        $new_withdraws = $wallet_withdraws - 1;

		        $query8 = "UPDATE wallet SET wallet_unlock = '$newBalance', wallet_withdraws = '$new_withdraws'";
		        if (!$result = mysqli_query($cnn,$query8))
			        exit(mysqli_error($cnn));
				else{
					echo "</br> <h3>This Wallet Address Balance: ".$invalidWallet." has been updated</h3>";
				}
			}
		}
		  
		

		echo "<h1>The Transfer has not been processed</br> Error Transfer!</h1> </br> ";
		echo 
		"Error Code: ".$transfer_errorcode. 
		"</br>Error Message: ".$transfer_errormessage;
		

	}
		
}
else {
	echo "</br><h3>There are only ". count($cron_amounts)." withdrawals in our database </br> We must have  ". $requestcount." withdrawals or more to run Superior Transfer Cronjob.</h3>";
				
}

 ?>