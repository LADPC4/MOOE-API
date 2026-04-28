<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/fundbalance.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$fundbalance = new fundbalance($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$fundbalance->set_property('fbguid',$data->fbguid);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
$fundbalance_arr=$fundbalance->readOne();
// print_r($fundbalance_arr);

 
// make it json format
$monthNum  = $fundbalance_arr["fundmonth"];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
// print_r($dateObj);
// $monthName = $dateObj->format('F'); // March
$monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
//  $monthName;
 $fundbalance_arr["monthdesc"]=$monthName;
echo json_encode($fundbalance_arr);
?>