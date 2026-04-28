<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/gaa.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$gaa = new gaa($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$gaa->set_property('gaayear',$data->fundyear);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
$gaa_arr=$gaa->importgaa($data->fundyear);
// print_r($gaa_arr);
if (($gaa_arr) ){
   //record exists!";
 
       $status="1";
       $msg="GAA Funds Finalized including IUs";
 
   
} else {
   //insert to database
   
  
       $status="0";
       $msg="Failed to add update gaa";

}


 
// make it json format
echo '{';
   echo '"status": "'.$status.'",';
  
   echo '"message": "'.$msg.' "';
echo '}';
?>