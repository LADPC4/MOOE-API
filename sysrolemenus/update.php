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
include_once '../objects/sysrolemenus.php';

$database = new Database();
$db = $database->getConnection();

// initialize object 
$sysrolemenus = new sysrolemenus($db);


 
// get posted data
//echo file_get_contents("php://input");
$data =  json_decode( file_get_contents("php://input"));

// set product property values
// $sysrolemenus->set_gusername($data->gusername) ;
// $sysrolemenus->set_gpassword($data->gpassword) ;
// $sysrolemenus->set_glastname($data->glastname) ;
// $sysrolemenus->set_gfirstname($data->gfirstname); 
// $sysrolemenus->set_gmiddlename($data->gmiddlename); 
// $sysrolemenus->set_gemail($data->gemail) ;
// $sysrolemenus->set_gmobile($data->gmobile); 
// $sysrolemenus->set_gfbid($data->gfbid) ;
// $sysrolemenus->set_ggoogleid($data->ggoogleid) ;
// $sysrolemenus->set_gaddress1($data->gaddress1); 
// $sysrolemenus->set_gaddress2($data->gaddress2) ;
// $sysrolemenus->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

 



//  $sysrolemenus->set_property('wfguid',$data->G73);
 
//  $sysrolemenus->set_property('gshow',$data->wforder);
//  $sysrolemenus->set_property('description',$data->description);
//  if (count($data->gshow)>0) {
//     $sysrolemenus->set_property("gshow","Y") ;
// } else {
//     $sysrolemenus->set_property("gshow","N") ;
// }

//delete existing 
$sysrolemenus->set_property('gsysrole',$data->roleguid);
// print_r($data->wfstatus);


// return "";
$sysrolemenus->delete();

//iterate 

foreach ($data->gsysmenuid as &$gsysmenuid) {
    // echo $stat;
    $sysrolemenus->set_property('gsysmenuid',$gsysmenuid);
    // create the user
    if($sysrolemenus->create()){


    }
    else{
        echo '{';
            echo '"message": "Unable to create record. ['.$sysrolemenus->lasterror.']"';
        echo '}';
    }
 }



echo '{';
    echo '"message": "Menus has been assigned."';
echo '}';




?>