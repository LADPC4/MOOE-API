<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/funds.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$funds = new funds($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$funds->set_property('schdivid',$data->schdivid);
$funds->set_property('gaayear',$data->gaayear);

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}

$gatotal=0;
$gttotal=0;
$gutotal=0;
$gltotal=0;
$gb1total=0;
$gb2total=0;
$gb3total=0;
$gb4total=0;
$gb5total=0;

// read the details of product to be edited

$es_stmt=$funds->readDivSchoolESUtils();

// $stmt = $funds->readPaging($from_record_num, $records_per_page);
$esnum = $es_stmt->rowCount();
// check if more than 0 record found
$es_arr=array();
$es_arr["records"]=array();


$atotal=0;
$ttotal=0;
$utotal=0;
$ltotal=0;
$b1total=0;
$b2total=0;
$b3total=0;
$b4total=0;
$b5total=0;
       


if($esnum>0){
 
    
    while ($row = $es_stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
        if($row["Transferred"]>0){
          $row["lstatus"]=($row["Liquidated"]/$row["Transferred"])*100;
        } else {
         $row["lstatus"]=0;
        }
        $b1=$row["ES_Allocated"]-$row["Transferred"];
        $b2=$row["ES_Allocated"]-$row["Liquidated"];
        $b3=$row["Transferred"]-$row["Liquidated"];
         //utilized total
        $b4=$row["Transferred"]-$row["Utilized"];
        $b5=$row["Transferred"]-$row["Liquidated"];
        $row["b1"]=$b1;
        $row["b2"]=$b2;
        $row["b3"]=$b3;
        //utilized total
        $row["b4"]=$b4;
        $row["b5"]=$b5;
 	     $es_item=$row;
       
        $atotal+=$row["ES_Allocated"];
        $ttotal+=$row["Transferred"];
        $utotal+=$row["Utilized"];
        $ltotal+=$row["Liquidated"];
        $b1total+=$b1;
        $b2total+=$b2;
        $b3total+=$b3;
        $b4total+=$b4;
        $b5total+=$b5;

        if ($row["ES_Allocated"]>0) {
        array_push($es_arr["records"], $es_item);
        }
    }
    $gatotal+=$atotal;
    $gttotal+=$ttotal;
    $gutotal+=$utotal;
    $gltotal+=$ltotal;
    $gb1total+=$b1total;
    $gb2total+=$b2total;
    $gb3total+=$b3total;
    $gb4total+=$b4total;
    $gb5total+=$b5total;
    $lstattotal=0;
    if (($ttotal==0) || ($ltotal==0)) {
        $lstattotal=0;
    }
    $es_arr["totals"]=array("atotal"=>$atotal,"ttotal"=>$ttotal,
                            "utotal"=>$utotal,"ltotal"=>$ltotal, "lstattotal"=>($lstattotal*100), 
                            "b1total"=>$b1total,
                            "b2total"=>$b2total,
                            "b3total"=>$b3total,
                            "b4total"=>$b4total,
                            "b5total"=>$b5total
                           );

}

$jhs_stmt=$funds->readDivSchoolJHSUtils();

// $stmt = $funds->readPaging($from_record_num, $records_per_page);
$jhsnum = $jhs_stmt->rowCount();
// check if more than 0 record found
$jhs_arr=array();
$jhs_arr["records"]=array();
$atotal=0;
$ttotal=0;
$utotal=0;
$ltotal=0;
$b1total=0;
$b2total=0;
$b3total=0;
$b4total=0;
$b5total=0;

if($jhsnum>0){
 
    
    while ($row = $jhs_stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
        if($row["Transferred"]>0){
         $row["lstatus"]=($row["Liquidated"]/$row["Transferred"])*100;
         } else {
         $row["lstatus"]=0;
         }
         $b1=$row["JHS_Allocated"]-$row["Transferred"];
        $b2=$row["JHS_Allocated"]-$row["Liquidated"];
        $b3=$row["Transferred"]-$row["Liquidated"];
         //utilized total
         $b4=$row["Transferred"]-$row["Utilized"];
         $b5=$row["Transferred"]-$row["Liquidated"];
         $row["b1"]=$b1;
         $row["b2"]=$b2;
         $row["b3"]=$b3;
         //utilized total
         $row["b4"]=$b4;
         $row["b5"]=$b5;
         
 	     $jhs_item=$row;
         $atotal+=$row["JHS_Allocated"];
         $ttotal+=$row["Transferred"];
         $utotal+=$row["Utilized"];
         $ltotal+=$row["Liquidated"];
         $b1total+=$b1;
         $b2total+=$b2;
         $b3total+=$b3;
         $b4total+=$b4;
         $b5total+=$b5;
         if ($row["JHS_Allocated"]>0) {
            array_push($jhs_arr["records"], $jhs_item);
         }
    }
    $gatotal+=$atotal;
    $gttotal+=$ttotal;
    $gutotal+=$utotal;
    $gltotal+=$ltotal;
    $gb1total+=$b1total;
    $gb2total+=$b2total;
    $gb3total+=$b3total;
    $gb4total+=$b4total;
    $gb5total+=$b5total;
    $lstattotal=0;
    if (($ttotal==0) || ($ltotal==0)) {
        $lstattotal=0;
    }
    $jhs_arr["totals"]=array("atotal"=>$atotal,"ttotal"=>$ttotal,"utotal"=>$utotal,"ltotal"=>$ltotal,"lstattotal"=>($lstattotal*100), 
    "b1total"=>$b1total,
    "b2total"=>$b2total,
    "b3total"=>$b3total,
    "b4total"=>$b4total,
    "b5total"=>$b5total);
}


$shs_stmt=$funds->readDivSchoolSHSUtils();

// $stmt = $funds->readPaging($from_record_num, $records_per_page);
$shsnum = $shs_stmt->rowCount();
// check if more than 0 record found
$shs_arr=array();
$shs_arr["records"]=array();

$atotal=0;
$ttotal=0;
$utotal=0;
$ltotal=0;
$b1total=0;
$b2total=0;
$b3total=0;
$b4total=0;
$b5total=0;

if($shsnum>0){
 
    
    while ($row = $shs_stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
        if($row["Transferred"]>0){
         $row["lstatus"]=($row["Liquidated"]/$row["Transferred"])*100;
        } else {
            $row["lstatus"]=0;
        }
        $b1=$row["SHS_Allocated"]-$row["Transferred"];
        $b2=$row["SHS_Allocated"]-$row["Liquidated"];
        $b3=$row["Transferred"]-$row["Liquidated"];
         //utilized total
         $b4=$row["Transferred"]-$row["Utilized"];
         $b5=$row["Transferred"]-$row["Liquidated"];
         $row["b1"]=$b1;
         $row["b2"]=$b2;
         $row["b3"]=$b3;
         //utilized total
         $row["b4"]=$b4;
         $row["b5"]=$b5;
 	     $shs_item=$row;
         $atotal+=$row["SHS_Allocated"];
         $ttotal+=$row["Transferred"];
         $utotal+=$row["Utilized"];
         $ltotal+=$row["Liquidated"];
         $b1total+=$b1;
         $b2total+=$b2;
         $b3total+=$b3;
         $b4total+=$b4;
         $b5total+=$b5;
         if ($row["SHS_Allocated"]>0) {
            array_push($shs_arr["records"], $shs_item);
         }
    }
    $gatotal+=$atotal;
    $gttotal+=$ttotal;
    $gutotal+=$utotal;
    $gltotal+=$ltotal;
    $gb1total+=$b1total;
    $gb2total+=$b2total;
    $gb3total+=$b3total;
    $gb4total+=$b4total;
    $gb5total+=$b5total;
    $lstattotal=0;
    if (($ttotal==0) || ($ltotal==0)) {
        $lstattotal=0;
    } 
    $shs_arr["totals"]=array("atotal"=>$atotal,"ttotal"=>$ttotal,"utotal"=>$utotal,"ltotal"=>$ltotal,"lstattotal"=>($lstattotal*100), 
    "b1total"=>$b1total,
    "b2total"=>$b2total,
    "b3total"=>$b3total,
    "b4total"=>$b4total,
    "b5total"=>$b5total);
}



$funds_arr=array(); 
$funds_arr["es"]=array(); 
array_push($funds_arr["es"], $es_arr);

$funds_arr["jhs"]=array(); 
array_push($funds_arr["jhs"], $jhs_arr);

$funds_arr["shs"]=array(); 
array_push($funds_arr["shs"], $shs_arr);


$funds_arr["gtotals"]=array("gatotal"=>$gatotal,"gttotal"=>$gttotal,"gutotal"=>$gutotal,"gltotal"=>$gltotal,
"glstattotal"=>(($gltotal/$gttotal)*100), 
"gb1total"=>$gb1total,
"gb2total"=>$gb2total,
"gb3total"=>$gb3total,
"gb4total"=>$gb4total,
"gb5total"=>$gb5total);

echo json_encode($funds_arr);
?>