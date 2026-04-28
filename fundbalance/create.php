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
include_once '../objects/transactions.php';
include_once '../objects/mooerequests.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$fundbalance = new fundbalance($db);
// $ct_workflow = new ct_workflow($db);
$mooerequest = new mooerequests($db);
$transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode(file_get_contents("php://input"));

// set product property values
// $fundbalance->set_gusername($data->gusername) ;
// $fundbalance->set_gpassword($data->gpassword) ;
// $fundbalance->set_glastname($data->glastname) ;
// $fundbalance->set_gfirstname($data->gfirstname); 
// $fundbalance->set_gmiddlename($data->gmiddlename); 
// $fundbalance->set_gemail($data->gemail) ;
// $fundbalance->set_gmobile($data->gmobile); 
// $fundbalance->set_gfbid($data->gfbid) ;
// $fundbalance->set_ggoogleid($data->ggoogleid) ;
// $fundbalance->set_gaddress1($data->gaddress1); 
// $fundbalance->set_gaddress2($data->gaddress2) ;
// $fundbalance->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;

// //Get workflow begin status id
// $ct_workflow->set_type($reqwft);
// $wf_status=$ct_workflow->getWFStart();

//Create new request

// $reqid=create_GUID();



//close previous month
if (isset($data->closemonth)){
    $fundbalance->set_property('fbguid',$data->fbguid);
    $fundbalance->set_property('closed','Y');
    $fundbalance->update();
    $fundbalance->set_property('fbguid',null);
}

// create the beginning balance 
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
$fundbalance->set_property('closed','N');

if($fundbalance->create()){
    //add to transaction history
    // $transaction->set_recowner($reqid);
    // $transaction->set_recstatus($wf_status);
    // $transaction->create();
   
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to create fund beginning balance record. ['.$fundbalance->lasterror.']"';
    echo '}';
    return;
}



echo '{';
    echo '"status": "1",';
    echo '"message": "fund beginning balance saved."';
echo '}';




?>