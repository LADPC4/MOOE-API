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
// include_once '../objects/wffields.php';

$database = new Database();
$db = $database->getConnection();

// initialize object 
// $wffields = new wffields($db);
$msg="Email was send successfuly.";
$to=array(array("arnel.calubag@deped.gov.ph"=>"Arnel Calubag"),
          array("nelson.talag@deped.gov.ph"=>"Arnel Calubag"));
$subj="MOOE Sender Test Email";
$content="<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";
$sentok=sendMail($to,$subj,$content);
if ($sentok==0) { 
    $msg="Email was send failed.";          
} 

echo '{';
    echo '"status": "'.$sentok.'",';
    echo '"message": "'.$msg.'"';
echo '}';





?>