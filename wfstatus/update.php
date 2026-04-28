<?php

//php ignore warnings
error_reporting(E_ERROR | E_PARSE);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-statused-With");
//get core config
include_once '../config/core.php';
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/wfstatus.php';
// include_once '../objects/ct_wfstatus.php';
// include_once '../objects/transactions.php';

 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$wfstatus = new wfstatus($db);
// $ct_wfstatus = new ct_wfstatus($db);
// $fileuploads = new fileuploads($db);
// $transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode( file_get_contents("php://input"));

// set product property values
// $wfstatus->set_gusername($data->gusername) ;
// $wfstatus->set_gpassword($data->gpassword) ;
// $wfstatus->set_glastname($data->glastname) ;
// $wfstatus->set_gfirstname($data->gfirstname); 
// $wfstatus->set_gmiddlename($data->gmiddlename); 
// $wfstatus->set_gemail($data->gemail) ;
// $wfstatus->set_gmobile($data->gmobile); 
// $wfstatus->set_gfbid($data->gfbid) ;
// $wfstatus->set_ggoogleid($data->ggoogleid) ;
// $wfstatus->set_gaddress1($data->gaddress1); 
// $wfstatus->set_gaddress2($data->gaddress2) ;
// $wfstatus->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;

//Get wfstatus begin status id
// $ct_wfstatus->set_type($diswft);
// $wf_status=$ct_wfstatus->getWFStart();






// $mooedisid=create_GUID();
// wfguid, `type`, `status`, wforder, description, completed

$wfstatus->set_property('id',$data->id);
$wfstatus->set_property('name',$data->name);
$wfstatus->set_property('gorder',$data->gorder);
if (count($data->gshow)>0) {
    $wfstatus->set_property("gshow","Y") ;
} else {
    $wfstatus->set_property("gshow","N") ;
}



// create the user
if($wfstatus->update()){
    //add to transaction history
//     $transaction->set_recowner($mooedisid);
//     $transaction->set_recstatus($wf_status);
//     $transaction->create();
}
else{
    echo '{';
        echo '"message": "Unable to create status. ['.$wfstatus->lasterror.']"';
    echo '}';
}




echo '{';
    echo '"message": "status has been saved."';
echo '}';




?>