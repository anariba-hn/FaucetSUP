<?php
session_destroy();
header("Location: ../admincenter/index.html");
$response['status'] = 200;
header('Content-type: application/json; charset=utf8');
echo json_encode($response);
?>