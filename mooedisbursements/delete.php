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
include_once '../objects/mooedisbursements.php';
// include_once '../objects/ct_workflow.php';
include_once '../objects/transactions.php';
// include_once '../objects/fileuploads.php';
// include_once '../objects/funds.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$mooedisbursements = new mooedisbursements($db);
// $ct_workflow = new ct_workflow($db);
// $fileuploads = new fileuploads($db);
// $funds = new funds($db);
$transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode(file_get_contents("php://input"));




if (empty($data)) {
    echo '{';
        echo '"status": "0",';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;
// $transaction->set_sysuser($current_user);
//Get workflow begin status id
// $ct_workflow->set_type($diswft);
// $wf_status=$ct_workflow->getWFStart();




$voidoverride='N';
if ((isset($data->voidoverride))) {
    if ($data->voidoverride=='Y') {
        $voidoverride='Y';
    }
 } 


// $mooedisid=create_GUID();
$mooedisbursements->set_property('mooedisid',$data->mooedisid);



if ((isset($data->sdodis))) {
    $row=$mooedisbursements->readOneDivDis(); 
 } else {
    $row=$mooedisbursements->readOne();
 }

$row=$mooedisbursements->readOne();
// print_r($row);
// return 

$liquidated=$row["liquidated"];
$printed=$row["printed"];

if ($liquidated[0]=='on'){
    echo '{';
        echo '"status": "0",';
        echo '"message": "Liquidated disbursements can no longer be voided. "';
    echo '}';
    return ;
}

if (($printed=='Y') && ($voidoverride=='N')){
    echo '{';
        echo '"status": "0",';
        echo '"message": "Printed disbursements can no longer be voided. "';
    echo '}';
    return ;
}

// return; 
// create the user
if($mooedisbursements->delete()){
    $transaction->set_recowner($data->mooedisid);
    $transaction->set_recstatus("Deleted");
    $transaction->set_sysuser($current_user);
    $transaction->create();
} else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to delete disbursements. ['.$mooedisbursements->lasterror.']"';
    echo '}';
    return ;
}




echo '{';
    echo '"status": "1",';
    echo '"message": "Disbursement has been deleted."';
echo '}';




?>