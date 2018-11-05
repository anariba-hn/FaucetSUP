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

$sql = "SELECT block, amount, tx_hash FROM get_tx_in WHERE donor_id = '$key'";
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