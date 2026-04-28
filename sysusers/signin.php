<?php

//php ignore warnings
error_reporting(E_ERROR | E_PARSE);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/core.php';
// get database connection

include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/sysusers.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$sysusers = new sysusers($db);
 

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode(file_get_contents("php://input"));

// set product property values
$sysusers->set_gusername($data->gusername) ;
$sysusers->set_gpassword($data->gpassword) ;
$sysusers->set_glastname($data->glastname) ;
$sysusers->set_gfirstname($data->gfirstname); 
$sysusers->set_gmiddlename($data->gmiddlename); 
$sysusers->set_gemail($data->gemail) ;
$sysusers->set_gmobile($data->gmobile); 
$sysusers->set_gfbid($data->gfbid) ;
$sysusers->set_ggoogleid($data->ggoogleid) ;
$sysusers->set_gaddress1($data->gaddress1); 
$sysusers->set_gaddress2($data->gaddress2) ;
$sysusers->set_gcountry($data->gcountry) ;

if (empty($data)) {
   echo '{';
        echo '"status": "0",';
        echo '"message": "No Data Sent.'.print_r($data).'"';
    echo '}';
   return;
}

//validate google token
$googletoken=$data->googletoken ;

if (validateToken($googletoken)==false){
    echo '{';
        echo '"status": "0",';
        echo '"message": "Invalid Session. "';
    echo '}';
    return ;
}


// create the user
if($sysusers->signin()){

    $showscdb=false;
    $showsddb=false;
    $showsrdb=false;

    $rg=$sysusers->get_rolegroup();
    $schtype=$sysusers->get_schtype();
    $rt=$sysusers->get_roletype();

    // if ($rt="X") {
    //     $showscdb=true;
    //     $showsddb=true;
    //     $showsrdb=true;
    // } else {
        $showscdb=($rg=="S");

        $showsddb=($rg=="D");

        $showsrdb=($rg=="R");
    // }
    


    

    $schtypeiu=($schtype=='IU');

    // create array
    $sysusers_arr = array(
    "guserid" =>  $sysusers->get_guserid(),
    "gusername" =>  $sysusers->get_gusername(),
    "gpassword" =>  $sysusers->get_gpassword(),
    "glastname" =>  $sysusers->get_glastname(),
    "gfirstname" =>  $sysusers->get_gfirstname(),
    "gmiddlename" =>  $sysusers->get_gmiddlename(),
    "gemail" =>  $sysusers->get_gemail(),
    "gmobile" =>  $sysusers->get_gmobile(),
    "gfbid" =>  $sysusers->get_gfbid(),
    "gaddress1" =>  $sysusers->get_gaddress1(),
    "gaddress2" =>  $sysusers->get_gaddress2(),
    "gcountry" =>  $sysusers->get_gcountry(),
    "gtimestamp" =>  $sysusers->get_gtimestamp(),
    "divcode" =>  $sysusers->get_divcode(),
    "schdivid" =>  $sysusers->get_schdivid(),
    "divdescription" =>  $sysusers->get_divdescription(),
    "roletype" =>  $sysusers->get_roletype(),
    "rolegroup" =>  $sysusers->get_rolegroup(),
    "roleguid" =>  $sysusers->get_roleguid(),
    "gstatus" =>  $sysusers->get_gstatus(),
    "roledescription" =>  $sysusers->get_roledescription(),
    "schdescription" =>  $sysusers->get_schdescription(), 
    "schoolid" =>  $sysusers->get_schoolid(),
    "schguid" =>  $sysusers->get_schguid(),
    "schaddress" =>  $sysusers->get_schaddress(),
    "schpayee" =>  $sysusers->get_schpayee(), 
    "schtype" =>  $sysusers->get_schtype(), 
    "schaccount" =>  $sysusers->get_schaccount(), 
    "schbank" =>  $sysusers->get_schbank(),
    "schregid" =>  $sysusers->get_schregid(), 
    "schregdescription" =>  $sysusers->get_schregdescription(),
    "showscdb"=>$showscdb,
    "showsddb"=>$showsddb,
    "showsrdb"=>$showsrdb,
    "schtypeiu"=>$schtypeiu,
    "ES" =>  $sysusers->get_ES(), 
    "JHS" =>  $sysusers->get_JHS(), 
    "SHS" =>  $sysusers->get_SHS() 
    );
    
    // make it json format
    print_r(json_encode($sysusers_arr));
    
}
 
// if unable to create the user, tell the user
else{
    echo '{';
        echo '"message": "Unable to create User. ['.$sysusers->lasterror.']"';
    echo '}';
}
?>