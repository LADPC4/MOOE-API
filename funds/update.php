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
// include_once '../objects/transactions.php';
include_once '../objects/fileuploads.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object 
$funds = new funds($db);
// $ct_workflow = new ct_workflow($db);
$fileuploads = new fileuploads($db);
// $transaction = new transactions($db);

 
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



$funds->set_property('schguid',$data->schguid);
$funds->set_property('gaayear',$data->fundyear);
$funds->set_property('paps',$data->paps);
$gaafield=$data->gaafield;

//validate balance
$bal_arr=$funds->readSchoolBalance($gaafield);



//read record 

$funds->set_property('fundguid',$data->fundguid);
$curr_rec=$funds->readOne();
$curr_totalamt=$curr_rec["totalamount"];
$newval=$data->totalamount-$curr_totalamt;

if ($newval > ( $bal_arr["GAABalance"] - $bal_arr["Taxes"])) {
    echo '{';
        echo '"status": "0",';
        echo '"message": "Amount exceeds Fund Balance ['.number_format( $bal_arr["GAABalance"] - $bal_arr["Taxes"]).']. "';
    echo '}';
    return;
}


// $funds->set_property('schdivid',$data->schdivid);
// $funds->set_property('transferdate',$data->transferdate);
// $funds->set_property('totalamount',$data->totalamount);
// $funds->set_property('paps',$data->paps);
// $funds->set_property('fundyear',$data->fundyear);
// $funds->set_property('userguid',$data->guserid);



// $mooedisid=create_GUID();
$funds->set_property('fundguid',$data->fundguid);
$funds->set_property('schdivid',$data->schdivid);
// $funds->set_property('schguid',$data->schguid);
$funds->set_property('transferdate',$data->transferdate);
$funds->set_property('totalamount',$data->totalamount);
$funds->set_property('ncainfo',$data->ncainfo);
$funds->set_property('ncadate',$data->ncadate);
$funds->set_property('fundyear',$data->fundyear);
$funds->set_property('userguid',$data->guserid);
$funds->set_property('schacctguid',$data->schacctguid);
// $funds->set_property('mooerequest',$data->requestid);




// create the user
if($funds->update()){
    
}
else{
    echo '{';
        echo '"status": "0",';
        echo '"message": "Unable to update transfer record. ['.$funds->lasterror.']"';
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
            $fileuploads->set_property("recowner",$data->fundguid);
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
    echo '"message": "Transfer record has been saved."';
echo '}';




?>