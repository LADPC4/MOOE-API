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
include_once '../objects/mooerequests.php';
include_once '../objects/ct_workflow.php';
include_once '../objects/transactions.php';
include_once '../objects/fileuploads.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$mooerequests = new mooerequests($db);
$ct_workflow = new ct_workflow($db);
$fileuploads = new fileuploads($db);
$transaction = new transactions($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode($_POST['data']);

// set product property values
// $mooerequests->set_gusername($data->gusername) ;
// $mooerequests->set_gpassword($data->gpassword) ;
// $mooerequests->set_glastname($data->glastname) ;
// $mooerequests->set_gfirstname($data->gfirstname); 
// $mooerequests->set_gmiddlename($data->gmiddlename); 
// $mooerequests->set_gemail($data->gemail) ;
// $mooerequests->set_gmobile($data->gmobile); 
// $mooerequests->set_gfbid($data->gfbid) ;
// $mooerequests->set_ggoogleid($data->ggoogleid) ;
// $mooerequests->set_gaddress1($data->gaddress1); 
// $mooerequests->set_gaddress2($data->gaddress2) ;
// $mooerequests->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
$current_user=$data->guserid;

//Get workflow begin status id
$ct_workflow->set_type($diswft);
$wf_status=$ct_workflow->getWFStart();






// $mooedisid=create_GUID();
$mooerequests->set_property('requestid',$data->requestid);
$mooerequests->set_property('paps',$data->paps);
$mooerequests->set_property('periodcovered',$data->periodcovered);
$mooerequests->set_property('totalamount',$data->totalamount);
$mooerequests->set_property("reqstatus",$wf_status);
$mooerequests->set_property("schacctguid",$data->schacctguid);
// $mooerequests->set_property('fundguid',$data->fundguid);
// $mooerequests->set_property('schguid',$data->schguid);
// $mooerequests->set_property('disreferenceno',$data->disreferenceno);
// $mooerequests->set_property('disrefdate',$data->disrefdate);
// $mooerequests->set_property('dismonth',$data->dismonth);
// // $mooerequests->set_property('disstatus',$wf_status);
// $mooerequests->set_property('payee',$data->payee);
// $mooerequests->set_property('payeetin',$data->payeetin);
// $mooerequests->set_property('orbursno',$data->orbursno);
// $mooerequests->set_property('coaguid',$data->coaguid);
// $mooerequests->set_property('trantype',$data->trantype);
// $mooerequests->set_property('vattype',$data->vattype);
// $mooerequests->set_property('particulars',$data->particulars);
// $mooerequests->set_property('grossamount',$data->grossamount);
// $mooerequests->set_property('netvat',str_replace(",","",$data->netvat));
// $mooerequests->set_property('bir2306',str_replace(",","",$data->bir2306));
// $mooerequests->set_property('bir2307',str_replace(",","",$data->bir2307));
// $mooerequests->set_property('netamount',str_replace(",","",$data->netamount));
// // $mooerequests->set_property('disreferenceno',$data->file);



// create the user
if($mooerequests->update()){
    //add to transaction history
    $transaction->set_recowner($data->requestid);
    $transaction->set_recstatus($wf_status);
    $transaction->create();
}
else{
    echo '{';
        echo '"message": "Unable to create request. ['.$mooerequests->lasterror.']"';
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
            $fileuploads->set_property("recowner",$data->requestid);
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
    echo '"message": "Request has been saved."';
echo '}';




?>