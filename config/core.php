<?php
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
// home page url dev 
$home_url="http://localhost/mooe-api/";

// require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/Exception.php';
require '../vendor/phpmailer/PHPMailer.php';
require '../vendor/phpmailer/SMTP.php';


// home page url dev 
// $home_url="https://mooe-prod-middleware.azurewebsites.net/";

// phpinfo();

//upload folder dev
// $uploaddir=$_SERVER['mooeuploads'];
// $reqwft=$_SERVER['mooereqwft'];
// $diswft=$_SERVER['mooediswft'];

// upload folder prod
$uploaddir=getenv('mooeuploads');
$errdir=getenv('mooeerrors');
$reqwft=getenv('mooereqwft');
$diswft=getenv('mooediswft');
$dsdwft=getenv('mooedsdwft');




// echo $mlrusr;


 
  
// page given in URL parameter, default page is one
// $page=1;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set number of records per page
$records_per_page = 100;
 
// calculate for the query LIMIT clause
// echo $page;
if ($page=="null") $page=1; 
$from_record_num = ($records_per_page * $page) - $records_per_page;

if ($from_record_num <0 ) $from_record_num = 1;

// if ($page==1) {
//     $until_record_num = $from_record_num + ($records_per_page-1);
// } else {
    $until_record_num = $from_record_num + ($records_per_page-1);
// }


//set time zone
define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

function validateToken($id_token){
    
        return true;
        $CLIENT_ID="'1071367696181-41hguqf1j44kmgv2opo3esu2ip4dfr05.apps.googleusercontent.com'";

        // Get $id_token via HTTPS POST.

        $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($id_token);
        echo  $payload;
        if ($payload) {
            $userid = $payload['sub'];
            // If request specified a G Suite domain:
            $domain = $payload['hd'];
            echo $userid." ".$domain;
            return true;
        } else {
        // Invalid ID token
           return false;
        }
}

function create_GUID(){
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function sendMail($to=array(array("nelson.talag@deped.gov.ph"=>"Nelson Homer Talag")),
                  $subj="Test is Test Email sent via Gmail SMTP Server using PHP Mailer",
                  $content="<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>"){

    $mlrusr=getenv('mooemlrusr');
    $mlrpwd=getenv('mooemlrpwd');
    $errdir=getenv('mooeerrors');

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";

    $mail->SMTPDebug  = 0;  
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = $mlrusr;
    $mail->Password   = $mlrpwd;

    
    $mail->IsHTML(true);
    $mail->SetFrom($mlrusr, "MOOE Mailer(no-reply)");
    $mail->AddReplyTo($mlrusr, "noreply.mooe@deped.gov.ph");

    $mail->AddAddress($mlrusr, "MOOE Mail Auto Sender");
    //add recipients to save email counts

    foreach ($to as $contact){
        foreach($contact as $email => $contactname){
            $mail->addBCC($email, $contactname);
        }

    }
    $mail->Subject = $subj;

    //simulate failed 

    // $mail->IsHTML(true);
    // $mail->AddAddress("recipient-email@domain", "recipient-name");
    // $mail->SetFrom("from-email@gmail.com", "from-name");
    // $mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
    // $mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
    // $mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
    // $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

    

    
    // $content = "";


    $mail->MsgHTML($content); 
    if(!$mail->Send()) {
        //"Error while sending Email.";
        $err_dump= json_encode($mail);
        //write to log file 
        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $date = date("Ymd_His",$date_array[1]);
      

        $filename=$date = $date."_".$date_array[0].".log";

        if (is_dir($errdir)==false) {
            mkdir($errdir);
        }

        $errfile = fopen($errdir."/".$filename, "w");
        fwrite($errfile, $err_dump);
        fclose($errfile);

       
        return 0;
    } else {
        return 1;
    }

}
?>