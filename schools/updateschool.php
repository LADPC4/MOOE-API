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
if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
$schools->set_schguid($data->schguid);
if (count($data->schtype)>0) {
    $schools->set_schtype("IU") ;
} else {
    $schools->set_schtype("NON-IU") ;
}
if (count($data->lastmile)>0) {
    $schools->set_lastmile("Y") ;
} else {
    $schools->set_lastmile("N") ;
}
if (count($data->ES)>0) {
    $schools->set_ES("Y") ;
} else {
    $schools->set_ES("N") ;
}
if (count($data->JHS)>0) {
    $schools->set_JHS("Y") ;
} else {
    $schools->set_JHS("N") ;
}
if (count($data->SHS)>0) {
    $schools->set_SHS("Y") ;
} else {
    $schools->set_SHS("N") ;
}


// read the details of product to be edited
if($schools->updateschool()){
    
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to update School. ['.$schools->lasterror.']"';
    echo '}';
}



echo '{';
    echo '"status": "1",';
    echo '"message": "School has been saved."';
echo '}';


?>