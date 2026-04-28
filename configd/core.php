<?php
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
// home page url dev 
$home_url="http://localhost/mooe-api/";

// home page url dev 
// $home_url="https://mooe-prod-middleware.azurewebsites.net/";


//upload folder dev
$uploaddir=$_SERVER['mooeuploads'];
$reqwft=$_SERVER['mooereqwft'];
$diswft=$_SERVER['mooediswft'];

//upload folder prod
// $uploaddir=getenv('mooeuploads');
// $reqwft=getenv('mooereqwft');
// $diswft=getenv('mooediswft');

 
  
// page given in URL parameter, default page is one
// $page=1;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set number of records per page
$records_per_page = 25;
 
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

function create_GUID(){
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
?>