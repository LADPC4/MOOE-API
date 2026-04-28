<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/fileuploads.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$fileuploads = new fileuploads($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$fileuploads->set_property('requestid',$data->requestid);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
$fileuploads_arr=$fileuploads->readOne();
// print_r($fileuploads_arr);

 
// make it json format
echo json_encode($fileuploads_arr);
?>