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
include_once '../objects/funds.php';
// include_once '../objects/ct_workflow.php';
include_once '../objects/transactions.php';
include_once '../objects/mooerequests.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$funds = new funds($db);
// $ct_workflow = new ct_workflow($db);
// $mooerequest = new mooerequests($db);
$transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode(file_get_contents("php://input"));

// set product property values
// $funds->set_gusername($data->gusername) ;
// $funds->set_gpassword($data->gpassword) ;
// $funds->set_glastname($data->glastname) ;
// $funds->set_gfirstname($data->gfirstname); 
// $funds->set_gmiddlename($data->gmiddlename); 
// $funds->set_gemail($data->gemail) ;
// $funds->set_gmobile($data->gmobile); 
// $funds->set_gfbid($data->gfbid) ;
// $funds->set_ggoogleid($data->ggoogleid) ;
// $funds->set_gaddress1($data->gaddress1); 
// $funds->set_gaddress2($data->gaddress2) ;
// $funds->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;

// //Get workflow begin status id
// $ct_workflow->set_type($reqwft);
// $wf_status=$ct_workflow->getWFStart();

//Create new request

// $reqid=create_GUID();


$funds->set_property('gaayear',$data->fundyear);
$funds->set_property('parentfund',$data->parentfund);
$funds->set_property('parentorg',$data->parentorg);
$funds->set_property('paps',$data->paps);
$funds->set_property('rolegroup',$data->rolegroup);
// $gaafield=$data->gaafield;

//validate balance
$bal_arr=$funds->readOtherFundBalance($data->parentfund,$data->rolegroup);


if ($data->totalamount > $bal_arr["FundBalance"]) {
    echo '{';
        echo '"status": "0",';
        echo '"message": "Amount exceeds Fund Balance ['.number_format($bal_arr["FundBalance"]).']. "';
    echo '}';
    return;
}
if (isset($data->schregid)) {
    if ($data->schregid!=""){
        $funds->set_property('schregid',$data->schregid);
    }
    
}
if (isset($data->schdivid)) {
    if ($data->schdivid!=""){
        $funds->set_property('schdivid',$data->schdivid);
        $funds->set_property('schguid',"");
    }
    
}
if (isset($data->schguid)) {
    if ($data->schguid!=""){
        $funds->set_property('schguid',$data->schguid);
        $funds->set_property('schregid',"");
        $funds->set_property('schdivid',$data->schdivid);
    }
    
}
// $funds->set_property('schdivid',$data->schdivid);



$funds->set_property('transferdate',$data->transferdate);
$funds->set_property('totalamount',$data->totalamount);

// $funds->set_property('mooerequest',$data->requestid);
$funds->set_property('fundyear',$data->fundyear);
$funds->set_property('userguid',$data->guserid);
$funds->set_property('schacctguid',$data->schacctguid);




// create the user
if($funds->create()){
    //add to transaction history
    // $transaction->set_recowner($reqid);
    // $transaction->set_recstatus($wf_status);
    // $transaction->create();
    // $mooerequest->set_property('requestid',$data->requestid);
    // $mooerequest->set_property('transferred','Y');
    // $mooerequest->update();
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to create transfer fund record. ['.$funds->lasterror.']"';
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
            $fileuploads->set_fileguid($filename);
            $fileuploads->set_filename($uploadfilename);
            $fileuploads->set_contenttype($contenttype);
            $fileuploads->set_filesize($filesize);
            $fileuploads->set_userguid($current_user);
            $fileuploads->set_recowner($reqid);
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
    echo '"message": "Transfer funds complete."';
echo '}';




?>