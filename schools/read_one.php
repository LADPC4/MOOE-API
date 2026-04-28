<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/schools.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$schools = new schools($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$schools->set_schguid($data->schguid);
// $schools->set_schaddress($data->schaddress);
// $schools->set_schaccount($data->schaccount);
// $schools->set_schbank($data->schbank);
// $schools->set_schpayee($data->schpayee);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
$schools_arr=$schools->readOne();

if ($schools_arr["schtype"]=="IU") {
   $schools_arr["schtype"]=array("on");
} else {
   $schools_arr["schtype"]=null;
}
// print_r($schools_arr);

 
// make it json format
echo json_encode($schools_arr);
?>