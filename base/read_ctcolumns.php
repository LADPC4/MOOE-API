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
include_once '../objects/baseclass.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
// $fileuploads = new fileuploads($db);
// $filetypes = new filetypes($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
// echo ("Nelson ");
// $fileuploads->set_property("gsysuserid",$data->gsysuserid) ;


if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}
 
// $filetypes->set_property("filetypeguid",$data->filetype);
// $fileitem=$filetypes->readOne();
// if (count( $fileitem)>0) {
//     // print_r($fileitem);

    


//     $fileclassname=$fileitem["classname"];
// print_r($db);
    $codetable=new baseclass($db);
    $codetable->set_property("ctable",$data->ctable) ;
//     //set properties 
//     if (isset($data->cutoffstart)){
//         $file->set_property("cutoffstart",$data->cutoffstart) ;
//         $file->set_property("cutoffend",$data->cutoffend) ;
//         $file->set_property($data->colname,"") ;
//     } else {
//         $file->set_property($data->colname,$data->colvalue) ;
//     }
//     //set field to search
    
    
     
    
    
// } else {

//     echo '{';
//         echo '"message": "File Type was not sent."';
//     echo '}';
//    return;

// }






// query products
// echo $fileuploads->PRIMARY_KEY;
// if (isset($data->cutoffstart)){
//     $stmt = $file->readDateRange($from_record_num, $records_per_page);
// } else {
// print_r($db);
$cols = $codetable->readCTColumns($db, $from_record_num, $records_per_page);
$fldspec =  $codetable->readCTColumnsSpec();
// }

$num = count($cols);
 
// check if more than 0 record found

if($num>0){
 
    
    // $gsysmenuid_arr["records"]=$cols;
    $gsysmenuid_arr["fldspecs"]=$fldspec;
    $gsysmenuid_arr=array_merge($gsysmenuid_arr,$cols);
    echo json_encode($gsysmenuid_arr);
}
 
else{
    echo json_encode(
        array("message" => "No records found.")
    );
}
?>