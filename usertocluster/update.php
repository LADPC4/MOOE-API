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
include_once '../objects/sysusrschcluster.php';

$database = new Database();
$db = $database->getConnection();

// initialize object 
$sysusrschcluster = new sysusrschcluster($db);


 
// get posted data
//echo file_get_contents("php://input");
$data =  json_decode( file_get_contents("php://input"));

// set product property values
// $sysusrschcluster->set_gusername($data->gusername) ;
// $sysusrschcluster->set_gpassword($data->gpassword) ;
// $sysusrschcluster->set_glastname($data->glastname) ;
// $sysusrschcluster->set_gfirstname($data->gfirstname); 
// $sysusrschcluster->set_gmiddlename($data->gmiddlename); 
// $sysusrschcluster->set_gemail($data->gemail) ;
// $sysusrschcluster->set_gmobile($data->gmobile); 
// $sysusrschcluster->set_gfbid($data->gfbid) ;
// $sysusrschcluster->set_ggoogleid($data->ggoogleid) ;
// $sysusrschcluster->set_gaddress1($data->gaddress1); 
// $sysusrschcluster->set_gaddress2($data->gaddress2) ;
// $sysusrschcluster->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

 



//  $sysusrschcluster->set_property('wfguid',$data->G73);
 
//  $sysusrschcluster->set_property('gshow',$data->wforder);
//  $sysusrschcluster->set_property('description',$data->description);
//  if (count($data->gshow)>0) {
//     $sysusrschcluster->set_property("gshow","Y") ;
// } else {
//     $sysusrschcluster->set_property("gshow","N") ;
// }

//delete existing 
$sysusrschcluster->set_property('guserid',$data->guserid);
$sysusrschcluster->set_property('schdivid',$data->schdivid);
// print_r($data->wfstatus);


// return "";
$sysusrschcluster->delete();

//iterate 

foreach ($data->clusterschools as &$school) {
    // echo $stat;
    $sysusrschcluster->set_property('schguid',$school->schguid);
    // create the user
    if($sysusrschcluster->create()){


    }
    else{
        echo '{';
            echo '"message": "Unable to create record. ['.$sysusrschcluster->lasterror.']"';
        echo '}';
    }
 }



echo '{';
    echo '"message": "Workflow has been assigned."';
echo '}';




?>