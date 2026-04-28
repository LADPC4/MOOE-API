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
include_once '../objects/wfnextstatus.php';

$database = new Database();
$db = $database->getConnection();

// initialize object 
$wfnextstatus = new wfnextstatus($db);


 
// get posted data
//echo file_get_contents("php://input");
$data =  json_decode( file_get_contents("php://input"));

// set product property values
// $wfnextstatus->set_gusername($data->gusername) ;
// $wfnextstatus->set_gpassword($data->gpassword) ;
// $wfnextstatus->set_glastname($data->glastname) ;
// $wfnextstatus->set_gfirstname($data->gfirstname); 
// $wfnextstatus->set_gmiddlename($data->gmiddlename); 
// $wfnextstatus->set_gemail($data->gemail) ;
// $wfnextstatus->set_gmobile($data->gmobile); 
// $wfnextstatus->set_gfbid($data->gfbid) ;
// $wfnextstatus->set_ggoogleid($data->ggoogleid) ;
// $wfnextstatus->set_gaddress1($data->gaddress1); 
// $wfnextstatus->set_gaddress2($data->gaddress2) ;
// $wfnextstatus->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

 



//  $wfnextstatus->set_property('wfguid',$data->G73);
 
//  $wfnextstatus->set_property('gshow',$data->wforder);
//  $wfnextstatus->set_property('description',$data->description);
//  if (count($data->gshow)>0) {
//     $wfnextstatus->set_property("gshow","Y") ;
// } else {
//     $wfnextstatus->set_property("gshow","N") ;
// }

//delete existing 
$wfnextstatus->set_property('workflow',$data->workflow);
// print_r($data->wfstatus);


// return "";
$wfnextstatus->delete();

//iterate 

foreach ($data->wfstatus as &$stat) {
    // echo $stat;
    $wfnextstatus->set_property('wfstatus',$stat);
    // create the user
    if($wfnextstatus->create()){


    }
    else{
        echo '{';
            echo '"message": "Unable to create record. ['.$wfnextstatus->lasterror.']"';
        echo '}';
    }
 }



echo '{';
    echo '"message": "wfnextstatus has been updated."';
echo '}';




?>