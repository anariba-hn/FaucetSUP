<?php
#
## WORKING ON THIS CODE
#
include("../connex.php"); 

$key = $_POST['key']; //KEY VARIABLE FROM POST REQUEST
$request=$_REQUEST; //TO DRAW
$col = array(
	0 => 'block',
	1 => 'amount',
	2 => 'tx_hash'
	//3 => 'tx_hash'
);

#
##CONDITION TO KNOW EMPTY KEY
#
if($key == "")
	$response = 0; // ZERO ITS A DEFAULT ID VALUE FOR ANONYMUS DONATIONS
else{
	$sql1 = "SELECT id FROM donation WHERE email = '$key'";
	if(!$result = mysqli_query($cnn, $sql1))
		exit(mysqli_error($cnn));
	else{
		$test = mysqli_fetch_row($result); 
		$response = $test[0];
	}
}

$sql = "SELECT block, amount, tx_hash FROM get_tx_in WHERE donor_id = '$response'";
$query = mysqli_query($cnn, $sql);
$totalData = mysqli_num_rows($query);
$totalFilter = $totalData;
$data = array();

while($row = mysqli_fetch_array($query)){
	$subdata = array();
	$subdata['block'] = $row[0];
	$subdata['amount'] = $row[1];
	$subdata['hash'] = $row[2];
	$data[] = $subdata;
}

$json_data = array(
	//"draw" 				=> intval($request['draw']),
	//"recordsTotal"		=> intval($totalData),
	//"recordsFilteres"	=> intval($totalFilter),
	"data"				=> $data
);

echo json_encode($json_data);

?>