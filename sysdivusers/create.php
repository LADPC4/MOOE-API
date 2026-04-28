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
include_once '../objects/sysroles.php';
include_once '../objects/msgtemplates.php';
$database = new Database();
$db = $database->getConnection();

// initialize object 
$sysdivusers = new sysdivusers($db);
$sysroles = new sysroles($db);
$msgtemplate = new msgtemplates($db);
 
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values

//gdivision, gsysuserid, gsysrole, gschool

$sysdivusers->set_property("gdivision",$data->gdivision) ;
$sysdivusers->set_property("schregid",$data->schregid) ;
$sysdivusers->set_property("gsysuserid",$data->gsysuserid) ;
$sysdivusers->set_property("gsysrole",$data->gsysrole) ;
$sysdivusers->set_property("gschool",$data->gschool) ;
//School level Assignment

$sysdivusers->set_property("ES",$data->es) ;
$sysdivusers->set_property("JHS",$data->jhs) ;
$sysdivusers->set_property("SHS",$data->shs) ;

$sysroles->set_roleguid($data->gsysrole);

$sysroles->readOne();

// return; 
//set msg template
$msgtemplate->set_property("templatecode","USRAPR") ;
$template=$msgtemplate->readOneUnique();
// print_r($template);
// return; 
if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

try{ 

    // create the user
    if($sysdivusers->create()){
        //fetch group info

        //Send Mail
        $roletype=$sysroles->get_roletype();
        $rolegroup=$sysroles->get_rolegroup();
        $sysdivusers->getapprovers($roletype,$rolegroup);

        $stmt = $sysdivusers->getapprovers($roletype,$rolegroup);
        $num = $stmt->rowCount();
        // print_r($stmt);
        // echo $num;
        $msg="Email was sent successfuly.";
        if($num>0){
        
            // products array
            $to=array();
        
        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
           
                extract($row);
                $recepients=$row;
                $contact=array($recepients["gemail"]=>$recepients["Contact_Name"]);
               
                array_push($to, $contact);
            }
            // print_r($to);

            
            //fetch template
            $msgtemplate->set_property("msgid","USEREG");
            $tmplt=$msgtemplate->readOne();
            $subj=$tmplt["subject"];
            $content=$tmplt["template"];;

            // print_r($tmplt);
            // return;

            $sentok=sendMail($to,$subj,$content);
            if ($sentok==0) { 
                $msg="Email sending failed. Please inform system admin.  ";          
            } else {
                
            }




        }
        //return 
        echo '{';
            echo '"status": "1",';
            echo '"message": "Access Request has been sent.<br/> Send mail status ['.$msg.'] <br/>  Kindly wait for approval notification that will be sent via email."';
        echo '}';
    }  else { // if unable to create the Group, tell the Group
        echo '{';
            echo '"status": "0",';
            echo '"message": "Unable to Send your Access request. ['.$sysdivusers->lasterror.']"';
        echo '}';
    }
}  catch(PDOException $e)
         {
         // roll back the transaction if something failed
        //  print_r( $gestmt->errorInfo());
        $sysdivusers->lasterror = $e->getMessage();
         echo '{';
            echo '"status": "0",';
            echo '"message": "Unable to Send your Access request. ['.$sysdivusers->lasterror.']"';
        echo '}';
        //  return false;  
         }
?>