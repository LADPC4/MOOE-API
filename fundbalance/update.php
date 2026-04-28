<?php

//php ignore warnings
error_reporting(E_ERROR | E_PARSE);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//get core config
include_once '../config/core.php';
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/fundbalance.php';
// include_once '../objects/ct_workflow.php';
// include_once '../objects/transactions.php';
include_once '../objects/fileuploads.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$fundbalance = new fundbalance($db);
// $ct_workflow = new ct_workflow($db);
$fileuploads = new fileuploads($db);
// $transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode(file_get_contents("php://input"));


$fundbalance->set_property('fbguid',$data->fbguid);
$fundbalance->set_property('schguid',$data->schguid);
$fundbalance->set_property('schdivid',$data->schdivid);
$fundbalance->set_property('fundyear',$data->fundyear);
$fundbalance->set_property('fundmonth',$data->dismonth);
$fundbalance->set_property('regmooebegbal',$data->regmooebegbal);
$fundbalance->set_property('otherfundbegbal',$data->otherfundbegbal);
$fundbalance->set_property('esbegbal',$data->esbegbal);
$fundbalance->set_property('jhsbegbal',$data->jhsbegbal);
$fundbalance->set_property('shsbegbal',$data->shsbegbal);
$fundbalance->set_property('userguid',$data->guserid);



// create the user
if($fundbalance->update()){
    
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to update transfer record. ['.$fundbalance->lasterror.']"';
    echo '}';
}


echo '{';
    echo '"status": "1",';
    echo '"message": "Transfer record has been saved."';
echo '}';




?>