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
include_once '../objects/fundconfirm.php';
include_once '../objects/funds.php';
// include_once '../objects/ct_workflow.php';
// include_once '../objects/transactions.php';
// include_once '../objects/fileuploads.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$fundconfirm = new fundconfirm($db);
// $ct_workflow = new ct_workflow($db);
// $fileuploads = new fileuploads($db);
// $transaction = new transactions($db);
$funds = new funds($db);
 
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

// //Get workflow begin status id
// $ct_workflow->set_type($reqwft);
// $wf_status=$ct_workflow->getWFStart();

//Create new request

// $reqid=create_GUID();
$fundconfirm->set_property('fundguid',$data->fundguid);
$fundconfirm->set_property('schguid',$data->schguid);
$fundconfirm->set_property('ackdate',$data->ackdate);
$fundconfirm->set_property('ctmor',$data->morguid);
$fundconfirm->set_property('receivername',$data->receivername);
$fundconfirm->set_property('receivercontact',$data->receivercontact);
// $fundconfirm->set_property('totalamount',$data->totalamount);
// $fundconfirm->set_property('paps',$data->paps);
// $fundconfirm->set_property('fundyear',$data->fundyear);
$fundconfirm->set_property('guserid',$data->guserid);
// create the user
$db->beginTransaction();
if($fundconfirm->create()){
    //add to transaction history
    // $transaction->set_recowner($reqid);
    // $transaction->set_recstatus($wf_status);
    // $transaction->create();

    //update fund info to confirmed

    $funds->set_property('fundguid',$data->fundguid);
    $funds->set_property('guserid',$data->guserid);
    $funds->set_property('confirmed','Y');
    $funds->set_property('ncainfo',$data->ncainfo);
    $funds->set_property('ncadate',$data->ncadate);
    if ($funds->update()==false) {
        //rollback data 
        echo '{';
            echo '"message": "Unable to confirm  funds. ['.$funds->lasterror.']"';
        echo '}';
        $db->rollback();
        return;
    }
    $db->commit();

}
else{
    
    echo '{';
        echo '"message": "Unable to create transfer fund record. ['.$fundconfirm->lasterror.']"';
    echo '}';
}



echo '{';
    echo '"message": "Transfer fundconfirm complete."';
echo '}';




?>