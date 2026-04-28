<?php

//php ignore warnings
error_reporting(E_ERROR | E_PARSE);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Workflowed-With");
//get core config
include_once '../config/core.php';
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/workflow.php';
// include_once '../objects/ct_workflow.php';
// include_once '../objects/transactions.php';

 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$workflow = new workflow($db);
// $ct_workflow = new ct_workflow($db);
// $fileuploads = new fileuploads($db);
// $transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode( file_get_contents("php://input"));

// set product property values
// $workflow->set_gusername($data->gusername) ;
// $workflow->set_gpassword($data->gpassword) ;
// $workflow->set_glastname($data->glastname) ;
// $workflow->set_gfirstname($data->gfirstname); 
// $workflow->set_gmiddlename($data->gmiddlename); 
// $workflow->set_gemail($data->gemail) ;
// $workflow->set_gmobile($data->gmobile); 
// $workflow->set_gfbid($data->gfbid) ;
// $workflow->set_ggoogleid($data->ggoogleid) ;
// $workflow->set_gaddress1($data->gaddress1); 
// $workflow->set_gaddress2($data->gaddress2) ;
// $workflow->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;

//Get workflow begin status id
// $ct_workflow->set_type($diswft);
// $wf_status=$ct_workflow->getWFStart();






// $mooedisid=create_GUID();
// wfguid, `type`, `status`, wforder, description, completed

$workflow->set_property('wfguid',$data->wfguid);
$workflow->set_property('status',$data->status);
$workflow->set_property('type',$data->type);
$workflow->set_property('wforder',$data->wforder);
$workflow->set_property('description',$data->description);
$workflow->set_property('completed',$data->completed);
if (count($data->completed)>0) {
    $workflow->set_property("completed","Y") ;
} else {
    $workflow->set_property("completed","N") ;
}
if (count($data->wfprint)>0) {
    $workflow->set_property("wfprint","Y") ;
} else {
    $workflow->set_property("wfprint","N") ;
}
if (count($data->wfedit)>0) {
    $workflow->set_property("wfedit","Y") ;
} else {
    $workflow->set_property("wfedit","N") ;
}


// create the user
if($workflow->update()){
    //add to transaction history
//     $transaction->set_recowner($mooedisid);
//     $transaction->set_recstatus($wf_status);
//     $transaction->create();
}
else{
    echo '{';
        echo '"message": "Unable to create Workflow. ['.$workflow->lasterror.']"';
    echo '}';
}



echo '{';
    echo '"message": "Workflow has been saved."';
echo '}';




?>