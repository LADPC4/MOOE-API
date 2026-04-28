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
include_once '../objects/fundbalance.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$fundbalance = new fundbalance($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
// echo ("Nelson ");

if (empty($data)) {
    echo '{';
         echo '"message": "No Data Sent."';
     echo '}';
    return;
 }
  
$fundbalance->set_property("fundmonth",$data->dismonth) ;
$fundbalance->set_property("fundyear",$data->fundyear) ;
$fundbalance->set_property("schguid",$data->schguid) ;


// $fundbalance->set_property("confirmed","N") ;


// query products
$preview = $fundbalance->closingPreview($from_record_num, $records_per_page);

$prev_stmt=$preview["prevbal"];
$fund_stmt=$preview["funds"];
$disb_stmt=$preview["disbs"];

$gsysmenuid_arr=array();


$num = $prev_stmt->rowCount();
$num2 = $fund_stmt->rowCount();
$num3 = $disb_stmt->rowCount();

$rtbal=0;
$restbal=0;
$rjhstbal=0;
$rshstbal=0;
$rothtbal=0;

// echo $fundmonth;
$schguid=$data->schguid;
$schdivid="";
$fbguid="";
// check if more than 0 record found
if($num>0){
    $gsysmenuid_arr["prevrecords"]=array();
    while ($row = $prev_stmt->fetch(PDO::FETCH_ASSOC)){    
        extract($row);
 	    // print_r($row);
        $row["esbegbal"]=(is_null($row["esbegbal"])) ? (0) : ($row["esbegbal"]);
        $row["jhsbegbal"]=(is_null($row["jhsbegbal"])) ? (0) : ($row["jhsbegbal"]);
        $row["shsbegbal"]=(is_null($row["shsbegbal"])) ? (0) : ($row["shsbegbal"]);
        $row["otherfundbegbal"]=(is_null($row["otherfundbegbal"])) ? (0) : ($row["otherfundbegbal"]);
        $gsysmenuid_item=$row;
        array_push($gsysmenuid_arr["prevrecords"], $gsysmenuid_item);
        $tmp1=(is_null($row["regmooebegbal"])) ? (0) : ($row["regmooebegbal"]);
        $rtbal=$rtbal+$tmp1;
        $tmp2=(is_null($row["esbegbal"])) ? (0) : ($row["esbegbal"]);
        $restbal=$restbal+$tmp2;
        $tmp3=(is_null($row["jhsbegbal"])) ? (0) : ($row["jhsbegbal"]);
        $rjhstbal=$rjhstbal+$tmp3;
        $tmp4=(is_null($row["shsbegbal"])) ? (0) : ($row["shsbegbal"]);
        $rshstbal=$rshstbal+$tmp4;
        $tmp5=(is_null($row["otherfundbegbal"])) ? (0) : ($row["otherfundbegbal"]);
        $rothtbal=$rothtbal+$tmp5;
        $schdivid=$row["schdivid"];
        $fbguid=$row["fbguid"];
        
    }
    
} else {
    echo '{';
        echo '"status": "0",';
        echo '"message": "This month has No previous closing/beginning balance please close or select another month or create a manual entry for this month."';
    echo '}';
    return;
        
    $gsysmenuid_arr["prevrecords"]=array();
    //return failed no previous closing 
}
// echo $rtbal;

if($num2>0){
    $gsysmenuid_arr["fundrecords"]=array();
    while ($row = $fund_stmt->fetch(PDO::FETCH_ASSOC)){    
        extract($row);

 	    $gsysmenuid_item=$row;
        array_push($gsysmenuid_arr["fundrecords"], $gsysmenuid_item);
        // print_r($row);
        if ($row["regmooe"]=='Y'){
            if ($row["es"]=='Y'){ 
                //echo (is_null($row["totalfunds"])) ? (0) : ($row["totalfunds"])+$restbal;

               // echo $restbal+(is_null($row["totalfunds"])) ? (0) : ($row["totalfunds"]);
                $restbal=(is_null($row["totalfunds"])) ? (0) : ($row["totalfunds"]) + $restbal;
                // echo $row["totalfunds"]; 
                // $rtbal=$rtbal+$restbal;
            }
            if ($row["jhs"]=='Y'){ 
                $rjhstbal=(is_null($row["totalfunds"])) ? (0) : ($row["totalfunds"]) + $rjhstbal;
                // $rtbal=$rtbal+$rjhstbal;
            }
            if ($row["shs"]=='Y'){ 
                
                $shsf= (is_null($row["totalfunds"])) ? (0) : ($row["totalfunds"]);
                // echo $rshstbal + $shsf; 
                $rshstbal=$rshstbal+$shsf;
                // $rtbal=$rtbal+$rshstbal;
                // echo $rshstbal;
            }
            $tmp=(is_null($row["totalfunds"])) ? (0) : ($row["totalfunds"]);
            // echo $tmp;
            $rtbal=$rtbal+$tmp;
            // echo $rtbal;
             
        } else {
            $tmp=(is_null($row["totalfunds"])) ? (0) : ($row["totalfunds"]);
            $rothtbal=$rothtbal+$tmp;
        }

    }
    
} else {
    $gsysmenuid_arr["fundrecords"]=array();
}
if($num3>0){
    $gsysmenuid_arr["disbrecords"]=array();
    // echo $rshstbal;
    while ($row = $disb_stmt->fetch(PDO::FETCH_ASSOC)){    
        extract($row);
 	    $gsysmenuid_item=$row;
        array_push($gsysmenuid_arr["disbrecords"], $gsysmenuid_item);
        if ($row["regmooe"]=='Y'){
            if ($row["es"]=='Y'){ 
                $tmp1=(is_null($row["totaldisbursments"])) ? (0) : ($row["totaldisbursments"]);
                $restbal=$restbal+$tmp1;
            }
            if ($row["jhs"]=='Y'){ 
                $tmp2=(is_null($row["totaldisbursments"])) ? (0) : ($row["totaldisbursments"]);
                $rjhstbal=$rjhstbal+$tmp2;
            }
            if ($row["shs"]=='Y'){ 
                $tmp3=(is_null($row["totaldisbursments"])) ? (0) : ($row["totaldisbursments"]);
                $rshstbal=$rshstbal+$tmp3;
                // echo $rshstbal;
            }
            $tmp=(is_null($row["totaldisbursments"])) ? (0) : ($row["totaldisbursments"]);
            // echo $tmp;
            $rtbal=$rtbal+$tmp;
             
        } else {
            $tmp=(is_null($row["totaldisbursments"])) ? (0) : ($row["totaldisbursments"]);
            $rothtbal=$rothtbal+$tmp;
        }
    }
    
} else {
    $gsysmenuid_arr["disbrecords"]=array();
}
// echo $fundmonth;
$closemonth=$data->dismonth;
$fundmonth=$data->dismonth;
$fundyear=$data->fundyear;
if ($fundmonth==12){
    $fundmonth=1;
    $fundyear=$fundyear+1;
} else {
    $fundmonth=$fundmonth+1;
}
// echo $rshstbal;
$gsysmenuid_arr["preview"]=array("regmooebegbal"=>$rtbal,
                                "esbegbal"=>$restbal,
                                "jhsbegbal"=>$rjhstbal,
                                "shsbegbal"=>$rshstbal,
                                "otherfundbegbal"=>$rothtbal,
                                "dismonth"=>$fundmonth,
                                "fundyear"=>$fundyear,
                                "schguid"=>$schguid,
                                "schdivid"=>$schdivid,
                                "closed"=>"N",
                                "closemonth"=>$closemonth,
                                "fbguid"=>$fbguid
                            );

echo json_encode($gsysmenuid_arr);
?>