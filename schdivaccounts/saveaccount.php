<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/schacctejs.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$schacctejs = new schacctejs($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
if ($data->ejsguid==""){
   $schacctejs->set_property('ejsguid',"%".$data->ejsguid."%");
} else {
   $schacctejs->set_property('ejsguid',$data->ejsguid);
}

$schacctejs->set_property('schdivguid',$data->schdivguid);

$schacctejs->set_property('schaccount',$data->schaccount);
$schacctejs->set_property('schbank',$data->schbank);
$schacctejs->set_property('maintbal',$data->maintbal);
$schacctejs->set_property('guserguid',$data->guserguid);

try {
   if (count($data->es)>0) {
       $schacctejs->set_property("es","Y") ;
   } else {
       $schacctejs->set_property("es","N") ;
   }
   if (count($data->jhs)>0) {
       $schacctejs->set_property("jhs","Y") ;
   } else {
       $schacctejs->set_property("jhs","N") ;
   }
   if (count($data->shs)>0) {
       $schacctejs->set_property("shs","Y") ;
   } else {
       $schacctejs->set_property("shs","N") ;
   }
} catch (Exception $e) {
   //continue if no schoo assignment
}





if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
if ($schacctejs->checkoverlap()==true){
  echo '{';
      echo '"status": "0",';
      echo '"message": "Account Assignment Overlaps/Duplicates an existing account "';
  echo '}';
} else {
   //insert to database 
   $saveresult=false;
   if ($data->ejsguid=="") {
      $saveresult=$schacctejs->create();
   } else {
      $saveresult=$schacctejs->update();
   }
   if ($saveresult==true) {
      echo '{';
         echo '"status": "1",';
         echo '"message": "Account was Successfully saved"';
     echo '}';
   } else {
      echo '{';
         echo '"status": "0",';
         echo '"message": "Sorry a problem was encountered while saving the account "'.$schacctejs->lasterror;
     echo '}';
   }
   
}
// print_r($schacctejs_arr);

 
// make it json format
// echo json_encode($schacctejs_arr);
?>