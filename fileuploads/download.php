<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/fileuploads.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$fileuploads = new fileuploads($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));


if (isset($_GET['fileguid'])) {
    $fileguid=$_GET['fileguid'];
} else {
    $fileguid=$data->fileguid;
}

if (isset($_GET['schregid']) ){
    $schregid=$_GET['schregid'];
} else {
    $schregid=$data->schregid;
}
 
// set ID property of product to be edited
$fileuploads->set_property('fileguid',$fileguid);

if (empty($fileguid)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

// read the details of product to be edited
$fileuploads_arr=$fileuploads->readOne();
//  print_r($fileuploads_arr);

$regid=$schregid;




$file = $uploaddir."/".$regid.'/'.$fileuploads_arr["fileguid"];

if(!file_exists($file)){ // file does not exist
    die('file not found');
} else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Cache-Control: no-store, no-cache");
    header("Content-Disposition: attachment; filename=".$fileuploads_arr["filename"]);
    header("Content-Type: ".$fileuploads_arr["contenttype"]);
    header("Content-Transfer-Encoding: binary");
    // header("Content-Type: application/octet-stream");

    // read the file from disk
    readfile($file);
}

 
// make it json format
// echo json_encode($fileuploads_arr);
?>