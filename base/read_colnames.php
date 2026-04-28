<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/fileuploads.php';
include_once '../objects/filetypes.php';
//include all fileupload classes
include_once '../objects/vmallfmo.php';
include_once '../objects/trxpaynamics.php';
include_once '../objects/bispaynamics.php';
include_once '../objects/idealeod.php';
include_once '../objects/lbc.php';
include_once '../objects/lbcbilling.php';
include_once '../objects/lbcremittance.php';
include_once '../objects/mbsettlements.php';
include_once '../objects/cwmssoo.php';
include_once '../objects/lbcbreakdown.php';
include_once '../objects/cwmssncirc.php';
include_once '../objects/2goremittance.php';
include_once '../objects/2gobilling.php';
include_once '../objects/2godmr.php';
include_once '../objects/ibsdrautogen.php';
include_once '../objects/shopinventory.php';
include_once '../objects/billpaynamics.php';
include_once '../objects/shopee.php';
include_once '../objects/lazada.php';
include_once '../objects/huaweisettlements.php';



 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$fileuploads = new fileuploads($db);
$filetypes = new filetypes($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));



if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

$status="1";
$msg="Record was successfuly saved";

// check if more than 0 record found
$filetypes->set_property("filetypeguid",$data->filetype);
$fileitem=$filetypes->readOne();
if (count( $fileitem)>0) {
    // print_r($fileitem);

    


    $fileclassname=$fileitem["classname"];
    $file=new $fileclassname($db);
    // print_r($file);
    $arr_colnames=$file->readColNames();
    
    // print_r($arr_colnames);

    
    echo json_encode($arr_colnames);
    
}


?>