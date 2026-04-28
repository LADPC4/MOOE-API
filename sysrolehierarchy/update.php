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
include_once '../objects/sysrolehierarchy.php';

$database = new Database();
$db = $database->getConnection();

// initialize object 
$sysrolehierarchy = new sysrolehierarchy($db);


 
// get posted data
//echo file_get_contents("php://input");
$data =  json_decode( file_get_contents("php://input"));

// set product property values
// $sysrolehierarchy->set_gusername($data->gusername) ;
// $sysrolehierarchy->set_gpassword($data->gpassword) ;
// $sysrolehierarchy->set_glastname($data->glastname) ;
// $sysrolehierarchy->set_gfirstname($data->gfirstname); 
// $sysrolehierarchy->set_gmiddlename($data->gmiddlename); 
// $sysrolehierarchy->set_gemail($data->gemail) ;
// $sysrolehierarchy->set_gmobile($data->gmobile); 
// $sysrolehierarchy->set_gfbid($data->gfbid) ;
// $sysrolehierarchy->set_ggoogleid($data->ggoogleid) ;
// $sysrolehierarchy->set_gaddress1($data->gaddress1); 
// $sysrolehierarchy->set_gaddress2($data->gaddress2) ;
// $sysrolehierarchy->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

 



//  $sysrolehierarchy->set_property('wfguid',$data->G73);
 
//  $sysrolehierarchy->set_property('gshow',$data->wforder);
//  $sysrolehierarchy->set_property('description',$data->description);
//  if (count($data->gshow)>0) {
//     $sysrolehierarchy->set_property("gshow","Y") ;
// } else {
//     $sysrolehierarchy->set_property("gshow","N") ;
// }

//delete existing 
$sysrolehierarchy->set_property('roleguid',$data->roleguid);
// print_r($data->wfstatus);


// return "";
$sysrolehierarchy->delete();

//iterate 

foreach ($data->childroleguid as &$childroleguid) {
    // echo $stat;
    $sysrolehierarchy->set_property('childroleguid',$childroleguid);
    // create the user
    if($sysrolehierarchy->create()){


    }
    else{
        echo '{';
            echo '"message": "Unable to create record. ['.$sysrolehierarchy->lasterror.']"';
        echo '}';
    }
 }



echo '{';
    echo '"message": "Hierarchy has been assigned."';
echo '}';




?>