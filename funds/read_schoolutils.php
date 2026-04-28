<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/funds.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$funds = new funds($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$funds->set_property('schguid',$data->schguid);
$funds->set_property('gaayear',$data->gaayear);
$funds->set_property('es',$data->es);
$funds->set_property('jhs',$data->jhs);
$funds->set_property('shs',$data->gaayear);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited

$funds_arr=$funds->readSchoolUtils();


if (isset($funds_arr["Allocated"])==false) {
   echo '{';
      echo '"Allocated": "0.00",
      "FundBalance": "0.00",
      "GAABalance": "0.00",
      "Liquidated": "0.00",
      "LiquidatedStatus": "0.00",
      "TransferStatus": "0.00",
      "Transferred": "0.00",
      "UtilizationStatus": "0.00",
      "Utilized": "0.00"
      ';
  echo '}';
  return;
}
// make it json format
if ($funds_arr["Allocated"]>0){
   $funds_arr["TransferStatus"]=($funds_arr["Transferred"]/$funds_arr["Allocated"]);
   $funds_arr["GAABalance"]=($funds_arr["Allocated"]-$funds_arr["Transferred"])/$funds_arr["Allocated"];
} else {
   $funds_arr["TransferStatus"]=0;
   $funds_arr["GAABalance"]=0;
}

if ($funds_arr["Transferred"]>0){
   $funds_arr["UtilizationStatus"]=($funds_arr["Utilized"]/$funds_arr["Transferred"]);
   $funds_arr["LiquidatedStatus"]=($funds_arr["Liquidated"]/$funds_arr["Transferred"]);
   $funds_arr["FundBalance"]=($funds_arr["Transferred"]-$funds_arr["Utilized"])/$funds_arr["Transferred"];
} else {
   $funds_arr["UtilizationStatus"]=0;
   $funds_arr["LiquidatedStatus"]=0;
   $funds_arr["FundBalance"]=0;
}
// print_r($funds_arr); 


echo json_encode($funds_arr);
?>