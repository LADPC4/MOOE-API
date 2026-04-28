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
include_once '../objects/transactions.php';
include_once '../objects/fileuploads.php';
include_once '../objects/funds.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$mooedisbursements = new mooedisbursements($db);
// $ct_workflow = new ct_workflow($db);
$fileuploads = new fileuploads($db);
// $funds = new funds($db);
$transaction = new transactions($db);

 
// get posted data
// echo file_get_contents("php://input");
// print_r($_POST);
$data = json_decode(file_get_contents("php://input"));

// set product property values

// $funds->set_property('fundguid',$data->fundguid);

//validate balance
// $bal_arr=$funds->readFundBalance();

// $funds->set_property('fundguid',$data->fundguid);
// if ((isset($data->sdodis))) {
//     $curr_rec=$funds->readOneDiv();
// } else {
//     $curr_rec=$funds->readOne();
// }



// echo $curr_rec;
// $curr_totalamt=$curr_rec["totalamount"];
// $newval=$data->grossamount-$curr_totalamt;

// if ($newval > $bal_arr["Balance"]) {
//     echo '{';
//         echo '"status": "0",';
//         echo '"message": "Amount exceeds Fund Balance. "';
//     echo '}';
//     return;
// }



if (empty($data)) {
    echo '{';
        echo '"status": "0",';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

//current user
// $current_user=$data->guserid;

//Get workflow begin status id
// $ct_workflow->set_type($diswft);
// $wf_status=$ct_workflow->getWFStart();






// $mooedisid=create_GUID();
$mooedisbursements->set_property('mooedisid',$data->mooedisid);
$mooedisbursements->set_property('printed','Y');
// $mooedisbursements->set_property('disstatus',$data->disstatus);

// $mooedisbursements->set_property('schguid',$data->schguid);
// if(isset($data->disreferenceno)) {
    
// }
// if(isset($data->disrefdate)){
//     $mooedisbursements->set_property('disrefdate',$data->disrefdate);
// }

// $mooedisbursements->set_property('dismonth',$data->dismonth);
// // $mooedisbursements->set_property('disstatus',$wf_status);
// $mooedisbursements->set_property('payee',$data->payee);
// $mooedisbursements->set_property('payeetin',$data->payeetin);
// $mooedisbursements->set_property('orbursno',$data->orbursno);
// $mooedisbursements->set_property('coaguid',$data->coaguid);
// $mooedisbursements->set_property('trantype',$data->trantype);
// $mooedisbursements->set_property('vattype',$data->vattype);
// $mooedisbursements->set_property('particulars',$data->particulars);
// $mooedisbursements->set_property('grossamount',$data->grossamount);
// $mooedisbursements->set_property('netvat',str_replace(",","",$data->netvat));
// $mooedisbursements->set_property('bir2306',str_replace(",","",$data->bir2306));
// $mooedisbursements->set_property('bir2307',str_replace(",","",$data->bir2307));
// $mooedisbursements->set_property('netamount',str_replace(",","",$data->netamount));
// if (count($data->liquidated)>0) {
//     $mooedisbursements->set_property("liquidated","Y") ;
// } else {
//     $mooedisbursements->set_property("liquidated","N") ;
// }
// $mooedisbursements->set_property('disreferenceno',$data->file);



// create the user
if($mooedisbursements->update()){
    //add to transaction history
    $transaction->set_recowner($data->mooedisid);
    // $transaction->set_recstatus($data->disstatus);
    $transaction->set_remarks("DV Printing");
    
    $transaction->create();
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to create request. ['.$mooedisbursements->lasterror.']"';
    echo '}';
}


// if (isset($_FILES['file'])) {
//     if ( 0 < $_FILES['file']['error'] ) {
//     echo 'Error: ' . $_FILES['file']['error'] . '<br>';
//     }
//     else {
      
//         //check if file was uploaded 
//         if ($_FILES['file']['size']) {
//             //save upload file and save to database transaction
//             $uploadfilename=$_FILES['file']['name'];
//             $contenttype=$_FILES['file']['type'];
//             $filesize=$_FILES['file']['size'];
//             $filename=create_GUID();  //$_FILES['file']['name'];
//             //Save file info
//             $fileuploads->set_property("fileguid",$filename);
//             $fileuploads->set_property("filename",$uploadfilename);
//             $fileuploads->set_property("contenttype",$contenttype);
//             $fileuploads->set_property("filesize",$filesize);
//             $fileuploads->set_property("userguid",$current_user);
//             $fileuploads->set_property("recowner",$data->mooedisid);
//             $fileuploads->create();
//         }
//         //create region folder if not exists
//         $regid=$data->schregid;
//         if (is_dir($uploaddir."/".$regid)==false) {
//             mkdir($uploaddir."/".$regid);
//         }
//         //move file to upload folder
//         move_uploaded_file($_FILES['file']['tmp_name'],$uploaddir."/".$regid."/".$filename);



        
//     //    return;
//     } 

// }

echo '{';
    echo '"status": "1",';
    echo '"message": "Disbursement has been tagged printed."';
echo '}';




?>