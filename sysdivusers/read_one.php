<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/sysdivusers.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$sysdivusers = new sysdivusers($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$sysdivusers->set_property('ggmid',$data->ggmid);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
$sysdivusers_arr=$sysdivusers->readOne();
// print_r($sysdivusers_arr);

// if ($sysdivusers_arr["gstatus"]=="Y") {
//    $sysdivusers_arr["gstatus"]=array("on");
// } 
// make it json format
echo json_encode($sysdivusers_arr);
?>