<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/wffields.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$wffields = new wffields($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$wffields->set_property('wffguid',$data->wffguid);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
$wffields_arr=$wffields->readOne();
// print_r($wffields_arr);

 
// make it json format
echo json_encode($wffields_arr);
?>