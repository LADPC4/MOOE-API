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
include_once '../objects/import.php';


 
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
    //  print_r($fileitem);

    


    $fileclassname=$fileitem["classname"];
    $deleterecords=$fileitem["deleterecords"];

    if (isset($data->fundyear)) {
        $tblyear=$data->fundyear;
        $file=new $fileclassname($db,$tblyear);
    } else {
        $file=new $fileclassname($db);
    }
    
    
    $file->set_property("FileName",$data->filename);
    
    if ($deleterecords=='Y') {
         $file->deletefiles();
    }

    //convert xls date cells to string
    // echo (ExcelToPHPObject("44153"));
    echo '{';
        echo '"status": "1",';
        echo '"message": "Records Deleted"';
    echo '}';
    return;
    
}


?>