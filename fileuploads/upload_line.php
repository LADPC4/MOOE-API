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
$datachunk = json_decode(file_get_contents("php://input"));





if (empty($datachunk)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

//create loop for each data in chunk
echo '{';
echo '"response": [' ;

$dctr=1;
foreach ($datachunk->data as $data) {
    //print_r($data);


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
        
        // $file=new $fileclassname($db);
        //validate cols
        if ($file->validate($data->colheaders,$data->rowstr)==false) {
            $status="0";
            $msg="Invalid File upload Format <br/>".$file->lasterror;
            // if ($dctr>1){
            //     echo ",";
            // }
            // echo '{';
            //     echo '"status": "'.$status.'",';
            //     echo '"sheetId": "'.$data->sheetId.'",';
            //     echo '"rowId": "'.$data->rowId.'",';
            //     echo '"message": "'.$msg.'"';
            // echo '}';
        // return;
        } else {
            //set Properties
            $file->set_properties($data->colheaders,$data->rowstr);
            $file->set_property("FileName",$data->filename);
            
            //mock upload
            // echo '{';
            //     echo '"status": "1",';
            //     echo '"sheetId": "'.$data->sheetId.'",';
            //     echo '"rowId": "'.$data->rowId.'",';
            //     echo '"message": "Test Upload"';
            // echo '}';
            //  return ; 

            // echo "readone class";
            $tmprec=$file->readOne();
            

            //check if data exists
            
            if (($tmprec) && ($deleterecords=='N')){
                //record exists!";
                if ($file->update()==false){
                    $status="0";
                    $msg="Failed to update record";
                }
                
            } else {
                //insert to database
                
                if ($file->create()==false){
                    $status="0";
                    $msg="Failed to add record";
                }
            }
            
        }

        //convert xls date cells to string
        // echo (ExcelToPHPObject("44153"));
        if ($dctr>1){
            echo ",";
        }
        echo '{';
            echo '"status": "'.$status.'",';
            echo '"sheetId": "'.$data->sheetId.'",';
            echo '"rowId": "'.$data->rowId.'",';
            echo '"message": "'.$msg.' : '.$file->lasterror.'"';
        echo '}';
        // return;
        
    }
    $dctr=$dctr+1;;
}
echo ']';
    echo '}' 

?>