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
include_once '../objects/wffields.php';
// include_once '../objects/ct_wffields.php';
// include_once '../objects/transactions.php';

 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$wffields = new wffields($db);
// $ct_wffields = new ct_wffields($db);
// $fileuploads = new fileuploads($db);
// $transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode( file_get_contents("php://input"));

// set product property values
// $wffields->set_gusername($data->gusername) ;
// $wffields->set_gpassword($data->gpassword) ;
// $wffields->set_glastname($data->glastname) ;
// $wffields->set_gfirstname($data->gfirstname); 
// $wffields->set_gmiddlename($data->gmiddlename); 
// $wffields->set_gemail($data->gemail) ;
// $wffields->set_gmobile($data->gmobile); 
// $wffields->set_gfbid($data->gfbid) ;
// $wffields->set_ggoogleid($data->ggoogleid) ;
// $wffields->set_gaddress1($data->gaddress1); 
// $wffields->set_gaddress2($data->gaddress2) ;
// $wffields->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;

//Get wffields begin status id
// $ct_wffields->set_type($diswft);
// $wf_status=$ct_wffields->getWFStart();






// $mooedisid=create_GUID();
// wfguid, `type`, `status`, wforder, description, completed
$wffields->set_property('wffguid',$data->wffguid);
$wffields->set_property('wfguid',$data->wfguid);
$wffields->set_property('wffield',$data->wffield);
$wffields->set_property('wffielddesc',$data->wffielddesc);


// create the user
if($wffields->update()){
    //add to transaction history
//     $transaction->set_recowner($mooedisid);
//     $transaction->set_recstatus($wf_status);
//     $transaction->create();
}
else{
    echo '{';
        echo '"message": "Unable to create status. ['.$wffields->lasterror.']"';
    echo '}';
}




echo '{';
    echo '"message": "status has been saved."';
echo '}';




?>