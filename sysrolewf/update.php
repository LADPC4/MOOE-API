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
include_once '../objects/sysrolewf.php';

$database = new Database();
$db = $database->getConnection();

// initialize object 
$sysrolewf = new sysrolewf($db);


 
// get posted data
//echo file_get_contents("php://input");
$data =  json_decode( file_get_contents("php://input"));

// set product property values
// $sysrolewf->set_gusername($data->gusername) ;
// $sysrolewf->set_gpassword($data->gpassword) ;
// $sysrolewf->set_glastname($data->glastname) ;
// $sysrolewf->set_gfirstname($data->gfirstname); 
// $sysrolewf->set_gmiddlename($data->gmiddlename); 
// $sysrolewf->set_gemail($data->gemail) ;
// $sysrolewf->set_gmobile($data->gmobile); 
// $sysrolewf->set_gfbid($data->gfbid) ;
// $sysrolewf->set_ggoogleid($data->ggoogleid) ;
// $sysrolewf->set_gaddress1($data->gaddress1); 
// $sysrolewf->set_gaddress2($data->gaddress2) ;
// $sysrolewf->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

 



//  $sysrolewf->set_property('wfguid',$data->G73);
 
//  $sysrolewf->set_property('gshow',$data->wforder);
//  $sysrolewf->set_property('description',$data->description);
//  if (count($data->gshow)>0) {
//     $sysrolewf->set_property("gshow","Y") ;
// } else {
//     $sysrolewf->set_property("gshow","N") ;
// }

//delete existing 
$sysrolewf->set_property('roleguid',$data->roleguid);
// print_r($data->wfstatus);


// return "";
$sysrolewf->delete();

//iterate 

foreach ($data->wfguid as &$wfguid) {
    // echo $stat;
    $sysrolewf->set_property('wfguid',$wfguid);
    // create the user
    if($sysrolewf->create()){


    }
    else{
        echo '{';
            echo '"message": "Unable to create record. ['.$sysrolewf->lasterror.']"';
        echo '}';
    }
 }



echo '{';
    echo '"message": "Workflow has been assigned."';
echo '}';




?>