<?php

//php ignore warnings
error_reporting(E_ERROR | E_PARSE);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/core.php';
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/sysdivusers.php';
include_once '../objects/msgtemplates.php';
$database = new Database();
$db = $database->getConnection();

// initialize object 
$sysdivusers = new sysdivusers($db);
$msgtemplate = new msgtemplates($db);
 
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
if (empty($data)) {
    echo '{';
         echo '"status": "1",';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
 

// set product property values
if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

//gdivision, gsysuserid, gsysrole, gschool
$enabled='N';
$sysdivusers->set_property("ggmid",$data->ggmid) ;
// $sysdivusers->set_property("gsysuserid",$data->gsysuserid) ;

if (count($data->gstatus)>0) {
    $sysdivusers->set_property("gstatus","Y") ;
    $enabled='Y';
} else {
    $sysdivusers->set_property("gstatus","N") ;
}
if (count($data->cluster)>0) {
    $sysdivusers->set_property("cluster","Y") ;
} else {
    $sysdivusers->set_property("cluster","N") ;
}
try {
    if (count($data->ES)>0) {
        $sysdivusers->set_property("ES","Y") ;
    } else {
        $sysdivusers->set_property("ES","N") ;
    }
    if (count($data->JHS)>0) {
        $sysdivusers->set_property("JHS","Y") ;
    } else {
        $sysdivusers->set_property("JHS","N") ;
    }
    if (count($data->SHS)>0) {
        $sysdivusers->set_property("SHS","Y") ;
    } else {
        $sysdivusers->set_property("SHS","N") ;
    }
} catch (Exception $e) {
    //continue if no schoo assignment
}



// $sysdivusers->set_property("schregid",$data->schregid) ;
$sysdivusers->set_property("gsysrole",$data->gsysrole) ;
$sysdivusers->set_property("schregid",$data->schregid) ;
$sysdivusers->set_property("gdivision",$data->schdivid) ;
$sysdivusers->set_property("gschool",$data->schguid) ;
// $sysdivusers->set_property("gschool",$data->gschool) ;



try{ 

    // create the user
    if($sysdivusers->update()){
        //fetch group info
        $msg="N/A";
        if ($enabled=='Y'){

            $userdata=$sysdivusers->readOne();
            $to=array(array($userdata["gemail"]=>$userdata["fullname"]));

            $msg="Email was sent successfuly.";
            //fetch template
            $msgtemplate->set_property("msgid","USRAPR");
            $tmplt=$msgtemplate->readOne();
            $subj=$tmplt["subject"];
            $content=$tmplt["template"];;

            // print_r($tmplt);
            // return;

            $sentok=sendMail($to,$subj,$content);
            if ($sentok==0) { 
                $msg="Email sending failed. Please inform system admin.  ";          
            } 

        }
        
        //return 
        echo '{';
            echo '"status": "1",';
            echo '"message": "User record has been saved.<br/> Send mail status ['.$msg.'] <br/> "';
        echo '}';
    }  else { // if unable to create the Group, tell the Group
        echo '{';
            echo '"status": "0",';
            echo '"message": "Unable to update record. ['.$sysdivusers->lasterror.']"';
        echo '}';
    }
}  catch(PDOException $e)
         {
         // roll back the transaction if something failed
        //  print_r( $gestmt->errorInfo());
        $sysdivusers->lasterror = $e->getMessage();
         echo '{';
            echo '"status": "0",';
            echo '"message": "Unable to update record. ['.$sysdivusers->lasterror.']"';
        echo '}';
        //  return false;  
         }
?>