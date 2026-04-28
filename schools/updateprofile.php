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
$schools->set_schaddress($data->schaddress);
// $schools->set_schaccount($data->schaccount);
// $schools->set_schbank($data->schbank);
$schools->set_schpayee($data->schpayee);
$schools->set_signatory1($data->signatory1);
// $schools->set_signatory2($data->signatory2);

// $schools->set_maintbal($data->maintbal);
$schools->set_acctofficer($data->acctofficer);
$schools->set_signatory3($data->signatory3);




if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
if($schools->updateprofile()){
    
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to update School Profile. ['.$schools->lasterror.']"';
    echo '}';
}



echo '{';
    echo '"status": "1",';
    echo '"message": "School Profile has been saved."';
echo '}';


?>