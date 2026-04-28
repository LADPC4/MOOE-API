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
include_once '../objects/ct_workflow.php';
include_once '../objects/transactions.php';
include_once '../objects/fileuploads.php';
include_once '../objects/funds.php';
include_once '../objects/fundbalance.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$mooedisbursements = new mooedisbursements($db);
$ct_workflow = new ct_workflow($db);
$fileuploads = new fileuploads($db);
$transaction = new transactions($db);
$funds = new funds($db);
$fundbalance = new fundbalance($db);

 
// get posted data
//echo file_get_contents("php://input");
$data = json_decode($_POST['data']);

// set product property values
// $mooedisbursements->set_gusername($data->gusername) ;
// $mooedisbursements->set_gpassword($data->gpassword) ;
// $mooedisbursements->set_glastname($data->glastname) ;
// $mooedisbursements->set_gfirstname($data->gfirstname); 
// $mooedisbursements->set_gmiddlename($data->gmiddlename); 
// $mooedisbursements->set_gemail($data->gemail) ;
// $mooedisbursements->set_gmobile($data->gmobile); 
// $mooedisbursements->set_gfbid($data->gfbid) ;
// $mooedisbursements->set_ggoogleid($data->ggoogleid) ;
// $mooedisbursements->set_gaddress1($data->gaddress1); 
// $mooedisbursements->set_gaddress2($data->gaddress2) ;
// $mooedisbursements->set_gcountry($data->gcountry) ;


if (empty($data)) {
    echo '{';
        echo '"status": "0",';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//validate balances
$funds->set_property('fundguid',$data->fundguid);
$schtype="";
//validate balance
$valbalance="";
if ((isset($data->sdodis))) {
     $parentfund=$data->fundguid;
     $funds->set_property('schguid',$data->schguid);
     $bal_arr=$funds->readOtherFundBalance($parentfund,"D"); 
     $bal_arr["Balance"]=$bal_arr["FundBalance"];
     $valbalance=round($bal_arr["Balance"],2);
     

} else {
    $bal_arr=$funds->readFundBalance();
    $schtype=$data->schtype;
    if ($data->schtype=='NON-IU'){
        $valbalance=round($bal_arr["NetBalance"],2);
    } else {
        $valbalance=round($bal_arr["Balance"],2);
    }
}


//  print_r($bal_arr);
// return;



if ($data->grossamount >  $valbalance) {
    echo '{';
        echo '"status": "0",';
        echo '"message": "Amount exceeds Fund Balance. '.$schtype.':['.$valbalance.'] "';
    echo '}';
    return;
}


//validate month if closed
// if ($data->dismonth>date("m"))
$fundbalance->set_property("fundyear",date("Y"));
$fundbalance->set_property("fundmonth",$data->dismonth);
$fundbalance->set_property("schguid",$data->schguid);


if ($fundbalance->monthClosed()=='Y') {
    echo '{';
        echo '"status": "0",';
        echo '"message": "Disbursement month has already been closed. "';
    echo '}';
    return;
}

//current user
$current_user=$data->guserid;

//Get workflow begin status id
if ((isset($data->sdodis))) {
    $ct_workflow->set_type($dsdwft); 
} else {
    $ct_workflow->set_type($diswft);
}

$wf_status=$ct_workflow->getWFStart();
// echo  $dsdwft;

// return "Test";


$mooedisid=create_GUID();
$mooedisbursements->set_property('mooedisid',$mooedisid);
$mooedisbursements->set_property('fundguid',$data->fundguid);
$mooedisbursements->set_property('schguid',$data->schguid);
// $mooedisbursements->set_property('disreferenceno',$data->disreferenceno);
// $mooedisbursements->set_property('disrefdate',$data->disrefdate);
$mooedisbursements->set_property('dismonth',$data->dismonth);
$mooedisbursements->set_property('disstatus',$wf_status);
$mooedisbursements->set_property('payee',$data->payee);
$mooedisbursements->set_property('payeetin',$data->payeetin);
$mooedisbursements->set_property('orbursno',$data->orbursno);
$mooedisbursements->set_property('coaguid',$data->coaguid);
$mooedisbursements->set_property('trantype',$data->trantype);
$mooedisbursements->set_property('vattype',$data->vattype);
$mooedisbursements->set_property('particulars',$data->particulars);
$mooedisbursements->set_property('grossamount',$data->grossamount);
$mooedisbursements->set_property('netvat',str_replace(",","",$data->netvat));
$mooedisbursements->set_property('bir2306',str_replace(",","",$data->bir2306));
$mooedisbursements->set_property('bir2307',str_replace(",","",$data->bir2307));
$mooedisbursements->set_property('netamount',str_replace(",","",$data->netamount));
$mooedisbursements->set_property('userguid',str_replace(",","",$data->guserid));

if (isset($data->liquidated)){
    if (count($data->liquidated)>0) {
        $mooedisbursements->set_property("liquidated","Y") ;
    } else {
        $mooedisbursements->set_property("liquidated","N") ;
    }
}
// $mooedisbursements->set_property('disreferenceno',$data->file);



// create the user
if($mooedisbursements->create()){
    //add to transaction history
    $transaction->set_recowner($mooedisid);
    $transaction->set_recstatus($wf_status);
    $transaction->create();
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
            // $fileuploads->set_fileguid($filename);
            // $fileuploads->set_filename($uploadfilename);
            // $fileuploads->set_contenttype($contenttype);
            // $fileuploads->set_filesize($filesize);
            // $fileuploads->set_userguid($current_user);
            // $fileuploads->set_recowner($mooedisid);

            $fileuploads->set_property("fileguid",$filename);
            $fileuploads->set_property("filename",$uploadfilename);
            $fileuploads->set_property("contenttype",$contenttype);
            $fileuploads->set_property("filesize",$filesize);
            $fileuploads->set_property("userguid",$current_user);
            $fileuploads->set_property("recowner",$mooedisid);



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