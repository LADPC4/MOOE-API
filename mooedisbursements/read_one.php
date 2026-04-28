<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/mooedisbursements.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$mooedisbursements = new mooedisbursements($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$mooedisbursements->set_property('mooedisid',$data->mooedisid);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
if ((isset($data->sdodis))) {
   $mooedisbursements_arr=$mooedisbursements->readOneDivDis(); 
} else {
   $mooedisbursements_arr=$mooedisbursements->readOne();
}


// print_r($mooedisbursements_arr);

$monthNum  = $mooedisbursements_arr["dismonth"];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March
//  $monthName;
 $mooedisbursements_arr["monthdesc"]=$monthName;
// make it json format
echo json_encode($mooedisbursements_arr);
?>