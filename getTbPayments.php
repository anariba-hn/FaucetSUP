<?php 
include("./connex.php");

$request=$_REQUEST;
$col =array(
    0   =>  'id_payments',
    1   =>  'payments_balance',
    2   =>  'payments_status',
    3   =>  'payments_wallet',
    4   =>  'payments_date'
);  //create column like table in database
//$cnn = connexion include
$sql ="SELECT * FROM vf_payments";
$query=mysqli_query($cnn,$sql);

$totalData=mysqli_num_rows($query);
$totalFilter=$totalData;
$data=array();

while($row=mysqli_fetch_array($query)){
    $subdata=array();
    $subdata[]=$row[0]; //id
    $subdata[]=$row[1]; //amount
    $subdata[]=$row[2]; //status
    $subdata[]=$row[3]; //wallet
    $subdata[]=$row[4]; //date      
    $data[]=$subdata;
}
$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);
echo json_encode($json_data);

 ?>