<?php

include ("./connex.php");

$deduc = 0; // VARIABLE TO SUBTRACT
$amount = 0; // VARIABLE AMOUNT FROM DB
$hyper = ""; // VARIABLE FOR HYPERLINK TO USE
$valid = array(); // ARRAY FOR VALID DONATIONS
$response = array(); // JSON RESPONSE
//$cnn = INCLUDE FROM connex.php

#
## SELECT THE CURRENT REWARD TO DEDUCT
#
$query = "SELECT value FROM confg WHERE action = 'reward'";
if(!$result = mysqli_query($cnn, $query))
    exit(mysqli_error($cnn));
if(mysqli_num_rows($result) > 0)
{
    $data = mysqli_fetch_row($result);
    $deduc = (int)$data[0];
}

#
## PREPARE ARRAY OF PAYMETSID ON DONATION DB TO COMPARE VALIDS
#
$query2 = "SELECT * FROM donation WHERE hyperlink != '' && amount != '' ";
if(!$result2 = mysqli_query($cnn, $query2))
    exit(mysqli_error($cnn));
while($row = mysqli_fetch_row($result2))
{
    $paymentsID = $row[4];
    $valid[count($valid)] = $paymentsID;
}

#
## COLLECT DATA FROM RANDOMLY VALID DONATION
#
if(!empty($valid))
{
    do{
        //GETTING A RANDOM PAYMENT ID TO SEARCH
        $rand = $valid[array_rand($valid)];

        $query3 = "SELECT * FROM donation WHERE payment_id = '$rand'";
        if(!$result3 = mysqli_query($cnn, $query3))
            exit(mysqli_error($cnn));
        if(mysqli_num_rows($result3) > 0)
        {
            $data2  = mysqli_fetch_row($result3);
            $hyper  = (string)$data2[6];
            $amount = (int)$data2[7];

        }else{
            $response['message'] = "Any Donation Found";
            $response['status'] = 404;
        }

    }while($amount < 0);

    #
    ## REDUCE AMOUNT FROM DONATION TB WHERE HYPER TO USE
    #
    $finalAmount = $amount - $deduc;

    $update = "UPDATE donation SET amount = '$finalAmount' WHERE payment_id = '$rand' ";
    if(!$result4 = mysqli_query($cnn, $update))
        exit(mysqli_error($cnn));
    else
    {
        $response['hyper'] = $hyper;
        $response['message'] = "Hyperlink amount updated";
        $response['status'] = 200;
    }

    #
    ##VERIFY AMOUNT AND ANNOUNCE WITH AN EMAIL IF ITS GOIN TO DIE
    #
    $sql = "SELECT email FROM donation WHERE payment_id = '$rand'";
    if(!$result = mysqli_query($cnn, $sql))
            exit(mysqli_error($cnn));
    else if($finalAmount <= 5){

    $data3 = mysql_fetch_row($result);
    $email = (string)$data3[0];
                #
                ##START ANNOUNCE EMAIL 
                #
                $to      = $email;
                $subject = 'HyperLink | ANNOUNCE';
                $message = 
 'Thanks for being a Superior Coin Star member ! 
 
 Your Donation was processed on SuperiorCoin Faucet Site. Now this link will expire on the next: '.$finalAmount.' outputs. Feel free to make a new donation to keep promoting your site with us and build a better community. 

 Best Regards, SuperiorCoin support.
 
 --------------------------------------------------------------------- 
 Hyperlink: '.$hyper.' 
 Outputs to die: '.$finalAmount.' 
 ---------------------------------------------------------------------
 
 Check our Telegram SUP Channel: https://t.me/superiorcoin
 SuperiorCoin: https://www.superior-coin.com/
 Kryptonia: https://kryptonia.io/
 
 ';

        $headers = 'From:admin@superior.com' . "\r\n";
        mail($to, $subject, $message, $headers); //Send the email
    }

}else{
    #
    ## IF DONATION ARRAY ITS EMPTY DEFAULT CONFG WILL BE SETTING
    #
    $query = "SELECT value FROM confg WHERE action = 'href' ";
    if(!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
    $data = mysqli_fetch_row($result);
    $hyper = (string)$data[0];

    $response['hyper'] = $hyper;
    $response['message'] = "Hyperlink getting by default";
    $response['status'] = 200;
}

header('Content-type: application/json; charset=utf8');
echo json_encode($response);

?>