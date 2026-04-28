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
include_once '../objects/mooedisbursements.php';
// include_once '../objects/ct_workflow.php';
// include_once '../objects/transactions.php';
include_once '../objects/fileuploads.php';
include_once '../objects/funds.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$mooedisbursements = new mooedisbursements($db);
// $ct_workflow = new ct_workflow($db);
$fileuploads = new fileuploads($db);
$funds = new funds($db);
// $transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode(file_get_contents("php://input"));

// set product property values

$mooedisbursements->set_property('mooedisid',$data->mooedisid);

if (count($data->liquidated)>0) {
    $mooedisbursements->set_property("liquidated","Y") ;
} else {
    $mooedisbursements->set_property("liquidated","N") ;
}

// $funds->set_property('liquidated',$data->liquidated);

//validate balance
// 


if (empty($data)) {
    echo '{';
        echo '"status": "0",';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;

//Get workflow begin status id
// $ct_workflow->set_type($diswft);
// $wf_status=$ct_workflow->getWFStart();










// create the user
if($mooedisbursements->update()){
    //add to transaction history
//     $transaction->set_recowner($mooedisid);
//     $transaction->set_recstatus($wf_status);
//     $transaction->create();
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to create request. ['.$mooedisbursements->lasterror.']"';
    echo '}';
}


if (isset($_FILES['file'])) {
    if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
      
        //check if file was uploaded 
        if ($_FILES['file']['size']) {
            //save upload file and save to database transaction
            $uploadfilename=$_FILES['file']['name'];
            $contenttype=$_FILES['file']['type'];
            $filesize=$_FILES['file']['size'];
            $filename=create_GUID();  //$_FILES['file']['name'];
            //Save file info
            $fileuploads->set_property("fileguid",$filename);
            $fileuploads->set_property("filename",$uploadfilename);
            $fileuploads->set_property("contenttype",$contenttype);
            $fileuploads->set_property("filesize",$filesize);
            $fileuploads->set_property("userguid",$current_user);
            $fileuploads->set_property("recowner",$data->mooedisid);
            $fileuploads->create();
        }
        //create region folder if not exists
        $regid=$data->schregid;
        if (is_dir($uploaddir."/".$regid)==false) {
            mkdir($uploaddir."/".$regid);
        }
        //move file to upload folder
        move_uploaded_file($_FILES['file']['tmp_name'],$uploaddir."/".$regid."/".$filename);



        
    //    return;
    } 

}

echo '{';
    echo '"status": "1",';
    echo '"message": "Disbursement has been saved."';
echo '}';




?>