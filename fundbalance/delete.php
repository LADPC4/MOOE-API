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
// include_once '../objects/mooerequests.php';
// include_once '../objects/fileuploads.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$fundbalance = new fundbalance($db);
// $ct_workflow = new ct_workflow($db);
// $fileuploads = new fileuploads($db);
// $mooerequests = new mooerequests($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode(file_get_contents("php://input"));



if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;



// $fundbalance->set_property('schguid',$data->schguid);
// $fundbalance->set_property('gaayear',$data->fundyear);

//validate balance
// $bal_arr=$fundbalance->readSchoolBalance();




// $mooedisid=create_GUID();
$fundbalance->set_property('fbguid',$data->fbguid);


// $fundbalance->set_property('mooerequest',$data->requestid);




// create the user
if($fundbalance->delete()){
    //update request to N transferred
    // $mooerequests->set_property('requestid',$data->requestid);
    // $mooerequests->set_property('transferred',"N");
    // $mooerequests->update();
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to delete fund record. ['.$fundbalance->lasterror.']"';
    echo '}';
    return;
}



echo '{';
    echo '"status": "1",';
    echo '"message": "Fund Record has been deleted."';
echo '}';




?>