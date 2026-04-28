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
include_once '../objects/funds.php';
include_once '../objects/schools.php';
include_once '../objects/schacctejs.php';
include_once '../objects/mooedisbursements.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$mooedisbursements = new mooedisbursements($db);
$fundbalance = new fundbalance($db);
$funds = new funds($db);
$schools = new schools($db);
$schacctejs = new schacctejs($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
// echo ("Nelson ");

$fundbalance->set_property("fundyear",$data->fundyear) ;
$fundbalance->set_property("fundmonth",$data->dismonth) ;
$fundbalance->set_property("schguid",$data->schguid) ;

$funds->set_property("fundyear",$data->fundyear) ;
$funds->set_property("fundmonth",$data->dismonth) ;
$funds->set_property("schguid",$data->schguid) ;
$funds->set_property("schacctguid",$data->schacctguid) ;
 


$mooedisbursements->set_property("schguid",$data->schguid) ;
$mooedisbursements->set_property("dismonth",$data->dismonth) ;
$mooedisbursements->set_property("fundyear",$data->fundyear) ;
$mooedisbursements->set_property("schacctguid",$data->schacctguid) ;

$schools->set_schguid($data->schguid) ;

$schacctejs->set_property("ejsguid",$data->schacctguid) ;

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}
//getschoo info 
// $schinfo=$schools->readOne();
$schinfo=$schools->readOne();
// print_r($schinfo);

$schacctinfo=$schacctejs->readOne();
$signatory2=$schools->getschheadsign($schacctinfo["es"],$schacctinfo["jhs"],$schacctinfo["shs"]);
$schinfo["signatory2"]=$signatory2;

$monthNum  = $data->dismonth;
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March
$schinfo["month"]=$monthName;
$schinfo["maintbal"]=$schacctinfo["maintbal"];

$regmooetrtotal=0;
$othfundtrtotal=0;
// CIBR Entries 
$RunningBalance=0;
$recctr=0;
$CIBR=array();

$entry=array(
    "trandate"=>"",
    "checkno"=>"",
    "payee"=>"",
    "particulars"=>"",
    "deposit"=>"",
    "regmooe"=>"",
    "otherfunds"=>"",
    "balance"=>"",
    "f2020101000"=>"", 							
    "f5020101000"=>"",
    "f5020201000"=>"",
    "f5020301000"=>"",
    "f5020399000"=>"",
    "f5020401000"=>"",
    "f5020402000"=>"",
    "f5021203000"=>"",
    "acctdesc"=>"",
    "acctcode"=>"",
    "amt"=>"",
    "trantype"=>"",
    "mooe"=>""

);
// query fund Beginning balance
$fbrow = $fundbalance->readOne();
// print_r($fbrow);
$fmooebal=0;
$fothbal=0;
$fbtrandate="";

//  print_r($fbrow);

if ($fbrow) {
    if(count($fbrow)>0){
        // $fbrow = $fbstmt->fetch(PDO::FETCH_ASSOC);
        // $ftrow["totalamount"]=number_format($ftrow["totalamount"], 2, '.', '')
        // print_r($schacctinfo);
        if ($schacctinfo["es"]=="Y"){
            $fmooebal=$fmooebal + $fbrow["esbegbal"];
        }
        if ($schacctinfo["jhs"]=="Y"){
            $fmooebal=$fmooebal + $fbrow["jhsbegbal"];
        }
        if ($schacctinfo["shs"]=="Y"){
            $fmooebal=$fmooebal + $fbrow["shsbegbal"];
        }
        // $fmooebal=number_format($fbrow["regmooebegbal"], 2, '.', '');
        $fmooebal=number_format($fmooebal, 2, '.', '');
        
        
        $fothbal=number_format($fbrow["otherfundbegbal"], 2, '.', '');
        $fbtrandate=$data->fundyear."-". str_pad($data->dismonth, 2, "0", STR_PAD_LEFT)."-01" ;//substr($fbrow["rectimestamp"],0,10);
        $regmooetrtotal=$regmooetrtotal+$fmooebal; //$fbrow["regmooebegbal"];
        $othfundtrtotal=$othfundtrtotal+$fbrow["otherfundbegbal"];
    }
}





$fbalarr=array(); 
$entry["trandate"]=$fbtrandate;
$entry["particulars"]="Balance Forwarded";
$entry["regmooe"]=number_format($fmooebal, 2, '.', '');
$entry["mooe"]="Y";
// $RunningBalance=$RunningBalance+$fmooebal;
// $entry["balance"]=$RunningBalance;
$entry["trantype"]="+";
$recctr=$recctr+1;
$CIBR[$fbtrandate."-".str_pad($recctr, 2, "0", STR_PAD_LEFT)]=array();
array_push($CIBR[$fbtrandate."-".str_pad($recctr, 2, "0", STR_PAD_LEFT)],$entry);
// print_r($CIBR);
// array_push($fbalarr,array("otherfundbegbal"=>$fothbal));
$entry=array(
    "trandate"=>"",
    "checkno"=>"",
    "payee"=>"",
    "particulars"=>"",
    "deposit"=>"",
    "regmooe"=>"",
    "otherfunds"=>"",
    "balance"=>"",
    "f2020101000"=>"", 							
    "f5020101000"=>"",
    "f5020201000"=>"",
    "f5020301000"=>"",
    "f5020399000"=>"",
    "f5020401000"=>"",
    "f5020402000"=>"",
    "f5021203000"=>"",
    "acctdesc"=>"",
    "acctcode"=>"",
    "amt"=>"",
    "trantype"=>"",
    "mooe"=>""

);

$entry["trandate"]=$fbtrandate;
$entry["particulars"]="Balance Forwarded";
$entry["otherfunds"]=number_format($fothbal, 2, '.', '');
// $RunningBalance=$RunningBalance+$fothbal;
// $entry["balance"]=$RunningBalance;
$entry["mooe"]="N";
$entry["trantype"]="+";
$recctr=$recctr+1;
$CIBR[$fbtrandate."-".str_pad($recctr, 2, "0", STR_PAD_LEFT)]=array();
array_push($CIBR[$fbtrandate."-".str_pad($recctr, 2, "0", STR_PAD_LEFT)],$entry);
// print_r($CIBR);
// array_push($fbalarr,array("totalbegbal"=>$fmooebal+$fmooebal));

// query fund transfer balance
$funds->set_property("fundyear",null) ;
$funds->set_property("trfryear",$data->fundyear) ;



$ftstmt = $funds->readCibrFunds();
// print_r($ftstmt);
$ftnum = $ftstmt->rowCount();
// echo $ftnum;
if($ftnum>0){
    while ($ftrow = $ftstmt->fetch(PDO::FETCH_ASSOC)){
        $entry=array(
            "trandate"=>"",
            "checkno"=>"",
            "payee"=>"",
            "particulars"=>"",
            "deposit"=>"",
            "regmooe"=>"",
            "otherfunds"=>"",
            "balance"=>"",
            "f2020101000"=>"", 							
            "f5020101000"=>"",
            "f5020201000"=>"",
            "f5020301000"=>"",
            "f5020399000"=>"",
            "f5020401000"=>"",
            "f5020402000"=>"",
            "f5021203000"=>"",
            "acctdesc"=>"",
            "acctcode"=>"",
            "amt"=>"",
            "trantype"=>"",
            "mooe"=>""
        
        );
        $entry["trandate"]=$ftrow["transferdate"];
        $entry["checkno"]="";
        $entry["payee"]="";
        $entry["particulars"]="Fund Transferred From SDO";
        $ftrow["totalamount"]=number_format($ftrow["totalamount"], 2, '.', '');
        $entry["deposit"]=number_format($ftrow["totalamount"], 2, '.', '');;
        $entry["regmooe"]="";
        $entry["otherfunds"]="";
       
        if ($ftrow["regmooe"]=='Y'){
            $entry["regmooe"]=number_format($ftrow["totalamount"], 2, '.', '');
            $entry["mooe"]="Y";
            $regmooetrtotal=$regmooetrtotal+$ftrow["totalamount"];

        } else {
            $entry["otherfunds"]=number_format($ftrow["totalamount"], 2, '.', '');
            $entry["mooe"]="N";
            $othfundtrtotal=$othfundtrtotal+$ftrow["totalamount"];
        }
        // $RunningBalance=$RunningBalance+$ftrow["totalamount"];
        // $entry["balance"]=$RunningBalance;
        $entry["f2020101000"]=""; 							
        $entry["f5020101000"]="";
        $entry["f5020201000"]="";
        $entry["f5020301000"]="";
        $entry["f5020399000"]="";
        $entry["f5020401000"]="";
        $entry["f5020402000"]="";
        $entry["f5021203000"]="";
        $entry["acctdesc"]="";
        $entry["acctcode"]="";
        $entry["amt"]="";
        $entry["trantype"]="+";
        $recctr=$recctr+1;
        $CIBR[$ftrow["transferdate"]."-".str_pad($recctr, 2, "0", STR_PAD_LEFT)]=array();
        
        array_push($CIBR[$ftrow["transferdate"]."-".str_pad($recctr, 2, "0", STR_PAD_LEFT)],$entry);
        // extract($row);
 	    // $gsysmenuid_item=$row;
        
    }
}

// print_r($CIBR);

// query transactions 
$stmt = $mooedisbursements->readTransactions($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $gsysmenuid_arr=array();
    // $gsysmenuid_arr["records"]=array();
    // $gsysmenuid_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $entry=array(
            "trandate"=>"",
            "checkno"=>"",
            "payee"=>"",
            "particulars"=>"",
            "deposit"=>"",
            "regmooe"=>"",
            "otherfunds"=>"",
            "balance"=>"",
            "f2020101000"=>"", 							
            "f5020101000"=>"",
            "f5020201000"=>"",
            "f5020301000"=>"",
            "f5020399000"=>"",
            "f5020401000"=>"",
            "f5020402000"=>"",
            "f5021203000"=>"",
            "acctdesc"=>"",
            "acctcode"=>"",
            "amt"=>"",
            "trantype"=>"",
            "mooe"=>""  
        
        );
        $entry["trandate"]=$row["disrefdate"];
        $entry["checkno"]=$row["disreferenceno"];
        $entry["payee"]=$row["payee"];
        $entry["particulars"]=$row["particulars"];
        $row["netamount"]=number_format($row["netamount"], 2, '.', '');
        $entry["deposit"]="";
        $entry["regmooe"]="";
        $entry["otherfunds"]="";

        if ($row["regmooe"]=='Y'){
            $entry["regmooe"]=$row["netamount"];
            $entry["mooe"]="Y";
        } else {
            $entry["otherfunds"]=$row["netamount"];
            $entry["mooe"]="N";
        }
        // $RunningBalance=number_format($RunningBalance-$row["netamount"], 2, '.', '');
        // $entry["balance"]=$RunningBalance;
        
        $entry["f2020101000"]=number_format($row["bir2306"] + $row["bir2307"], 2, '.', '')  ; 	
        
        switch ($row["coacode"]) {
            case "5020101000": 
                $entry["f5020101000"]=$row["grossamount"];
                break;
            case "5020201000": 
                $entry["f5020201000"]=$row["grossamount"];
                break;
            case "5020301000": 
                $entry["f5020301000"]=$row["grossamount"];
                break;
            case "5020399000": 
                $entry["f5020399000"]=$row["grossamount"];
                break;

            case "5020401000": 
                $entry["f5020401000"]=$row["grossamount"];
                break;
            case "5020402000": 
                $entry["f5020402000"]=$row["grossamount"];
                break;
            case "5021203000": 
                $entry["f5021203000"]=$row["grossamount"];
                break;	
            default:
                $entry["acctdesc"]=$row["coadesc"];
                $entry["acctcode"]=$row["coacode"];
                $entry["amt"]=$row["grossamount"];
                break;
                
        }
        
        
        $entry["trantype"]="-";
        $recctr=$recctr+1;
        $CIBR[$row["disrefdate"]."-".str_pad($recctr, 2, "0", STR_PAD_LEFT)]=array();
        array_push($CIBR[$row["disrefdate"]."-".str_pad($recctr, 2, "0", STR_PAD_LEFT)],$entry);
       
    }
 
 
    //Read recap 
    $rcstmt = $mooedisbursements->readRecap();
    $rcnum = $rcstmt->rowCount();
    
    // check if more than 0 record found
    $recap=array();
    $recaptotal=0;
    if($rcnum>0){
        while ($rcrow = $rcstmt->fetch(PDO::FETCH_ASSOC)){
            $recaptotal=$recaptotal+$rcrow["grossamt"];
            extract($rcrow);
             $rc_item=$rcrow;
             array_push( $recap, $rc_item);
        }
    }







    $gsysmenuid_arr["cibr"]=array();
    $gsysmenuid_arr["totals"]=array();
    $gsysmenuid_arr["endbal"]=array();
    $gsysmenuid_arr["schinfo"]=array();
    $gsysmenuid_arr["schinfo"]["schacctinfo"]=array();
    $gsysmenuid_arr["schacctinfo"]=array();
    $gsysmenuid_arr["recap"]=array();
    
    
    
    // array_push( $gsysmenuid_arr["begbalances"], $fbalarr);
    // array_push( $gsysmenuid_arr["transfers"], $ftalarr);
    ksort($CIBR);
    $CIBRSorted=array();

    $deptotal=0;
    $regmooetotal=0;
    $othtotal=0;
    $taxtotal=0;
    $coa1total=0;
    $coa2total=0;
    $coa3total=0;
    $coa4total=0;
    $coa5total=0;
    $coa6total=0;
    $coa7total=0;
    $amttotal=0;
    foreach ($CIBR as $key => $value) {
        $record=$value[0];
        $recamount=0;
        if ($record["mooe"]=='Y'){
            $recamount=$record["regmooe"];
            
        } else {
            $recamount=$record["otherfunds"];
        }
        if($record["trantype"]=="+"){
            // if ($record["regmooe"]!="") $regmooetotal=$regmooetotal+$record["regmooe"];
            // if ($record["otherfunds"]!="") $othtotal=$othtotal+$record["otherfunds"];
            $RunningBalance=$RunningBalance+$recamount;
        } else {
            $RunningBalance=$RunningBalance-$recamount;
            if ($record["regmooe"]!="") $regmooetotal=$regmooetotal+$record["regmooe"];
            if ($record["otherfunds"]!="") $othtotal=$othtotal+$record["otherfunds"];
        }
        $record["balance"]=number_format($RunningBalance, 2, '.', '');
        if ($record["deposit"]!="") $deptotal=$deptotal+$record["deposit"];
        if ($record["f2020101000"]!="") $taxtotal=$taxtotal+$record["f2020101000"];
        if ($record["f5020101000"]!="") $coa1total=$coa1total+$record["f5020101000"];
        if ($record["f5020201000"]!="") $coa2total=$coa2total+$record["f5020201000"];
        if ($record["f5020301000"]!="") $coa3total=$coa3total+$record["f5020301000"];
        if ($record["f5020399000"]!="") $coa4total=$coa4total+$record["f5020399000"];
        if ($record["f5020401000"]!="") $coa5total=$coa5total+$record["f5020401000"];
        if ($record["f5020402000"]!="") $coa6total=$coa6total+$record["f5020402000"];
        if ($record["f5021203000"]!="") $coa7total=$coa7total+$record["f5021203000"];
        if ($record["amt"]!="") $amttotal=$amttotal+$record["amt"];
        
        array_push( $CIBRSorted, $record);
        

    }
    $breakdowntotal=($coa1total+$coa2total+$coa3total+$coa4total+$coa5total+$coa6total+$coa7total+$amttotal)-$taxtotal;
    $totals=array("deptotal"=>number_format($deptotal, 2, '.', ''),
                "regmooetotal"=>number_format($regmooetotal, 2, '.', ''),
                "othtotal"=>number_format($othtotal, 2, '.', ''),
                "taxtotal"=>number_format($taxtotal, 2, '.', ''),
                "coa1total"=>number_format($coa1total, 2, '.', ''),
                "coa2total"=>number_format($coa2total, 2, '.', ''),
                "coa3total"=>number_format($coa3total, 2, '.', ''),
                "coa4total"=>number_format($coa4total, 2, '.', ''),
                "coa5total"=>number_format($coa5total, 2, '.', ''),
                "coa6total"=>number_format($coa6total, 2, '.', ''),
                "coa7total"=>number_format($coa7total, 2, '.', ''),
                "amttotal"=>number_format($amttotal, 2, '.', ''),
                "recaptotal"=>number_format($recaptotal, 2, '.', ''),
                "breakdowntotal"=>number_format($breakdowntotal, 2, '.', '')
              );
                
    $RlessMBal=number_format($RunningBalance+$schinfo["maintbal"], 2, '.', '');
    $regmooeendbal=number_format($regmooetrtotal-$regmooetotal, 2, '.', '');
    $othfundendbal=number_format($othfundtrtotal-$othtotal, 2, '.', '');
    $endbal=array("regmooeendbal"=>$regmooeendbal,
                  "othfundendbal"=>$othfundendbal,
                  "endingbalance"=>$RunningBalance,
                  "RlessMBal"=>$RlessMBal

                 );
    array_push( $gsysmenuid_arr["cibr"], $CIBRSorted);
    array_push( $gsysmenuid_arr["totals"], $totals);
    array_push( $gsysmenuid_arr["endbal"], $endbal);
    array_push( $gsysmenuid_arr["schinfo"], $schinfo);
    array_push( $gsysmenuid_arr["schinfo"]["schacctinfo"], $schacctinfo);
    
    array_push( $gsysmenuid_arr["recap"], $recap);
    
    
    
    // $paging=array_merge($paging,$fbalarr);
    // $paging=array_merge($paging,$totalrecarr);
    // $paging=array_merge($paging,$recpp);
    // $paging=array_merge($paging,$fromrecnumarr);
    // $paging=array_merge($paging,$untilrecnumarr);
    // $gsysmenuid_arr["paging"]=$paging;
 
    echo json_encode($gsysmenuid_arr);
}
else{
//     $regmooetotal=$regmooetrtotal;
//     $othtotal=$othfundtrtotal;
    $gsysmenuid_arr=array();
    $gsysmenuid_arr["cibr"]=array();
    $gsysmenuid_arr["totals"]=array();
    $gsysmenuid_arr["endbal"]=array();
    $gsysmenuid_arr["schinfo"]=array();
    $gsysmenuid_arr["schinfo"]["schacctinfo"]=array();
    
    $gsysmenuid_arr["recap"]=array();

//     $totals=array("deptotal"=>number_format(0, 2, '.', ''),
//     "regmooetotal"=>number_format(0, 2, '.', ''),
//     "othtotal"=>number_format(0, 2, '.', ''),
//     "taxtotal"=>number_format(0, 2, '.', ''),
//     "coa1total"=>number_format(0, 2, '.', ''),
//     "coa2total"=>number_format(0, 2, '.', ''),
//     "coa3total"=>number_format(0, 2, '.', ''),
//     "coa4total"=>number_format(0, 2, '.', ''),
//     "coa5total"=>number_format(0, 2, '.', ''),
//     "coa6total"=>number_format(0, 2, '.', ''),
//     "coa7total"=>number_format(0, 2, '.', ''),
//     "amttotal"=>number_format(0, 2, '.', ''),
//     "recaptotal"=>number_format(0, 2, '.', ''),
//     "breakdowntotal"=>number_format(0, 2, '.', '')




    
//   );

    
//     $RlessMBal=number_format($RunningBalance+$schinfo["maintbal"], 2, '.', '');
//     $regmooeendbal=number_format($regmooetrtotal-$regmooetotal, 2, '.', '');
//     $othfundendbal=number_format($othfundtrtotal-$othtotal, 2, '.', '');
//     $endbal=array("regmooeendbal"=>$regmooeendbal,
//                   "othfundendbal"=>$othfundendbal,
//                   "endingbalance"=>$RunningBalance,
//                   "RlessMBal"=>$RlessMBal

//                  );

ksort($CIBR);
$CIBRSorted=array();

$deptotal=0;
$regmooetotal=0;
$othtotal=0;
$taxtotal=0;
$coa1total=0;
$coa2total=0;
$coa3total=0;
$coa4total=0;
$coa5total=0;
$coa6total=0;
$coa7total=0;
$amttotal=0;
foreach ($CIBR as $key => $value) {
    $record=$value[0];
    $recamount=0;
    if ($record["mooe"]=='Y'){
        $recamount=$record["regmooe"];
        
    } else {
        $recamount=$record["otherfunds"];
    }
    if($record["trantype"]=="+"){
        // if ($record["regmooe"]!="") $regmooetotal=$regmooetotal+$record["regmooe"];
        // if ($record["otherfunds"]!="") $othtotal=$othtotal+$record["otherfunds"];
        $RunningBalance=$RunningBalance+$recamount;
    } else {
        $RunningBalance=$RunningBalance-$recamount;
        if ($record["regmooe"]!="") $regmooetotal=$regmooetotal+$record["regmooe"];
        if ($record["otherfunds"]!="") $othtotal=$othtotal+$record["otherfunds"];
    }
    $record["balance"]=number_format($RunningBalance, 2, '.', '');
    if ($record["deposit"]!="") $deptotal=$deptotal+$record["deposit"];
    if ($record["f2020101000"]!="") $taxtotal=$taxtotal+$record["f2020101000"];
    if ($record["f5020101000"]!="") $coa1total=$coa1total+$record["f5020101000"];
    if ($record["f5020201000"]!="") $coa2total=$coa2total+$record["f5020201000"];
    if ($record["f5020301000"]!="") $coa3total=$coa3total+$record["f5020301000"];
    if ($record["f5020399000"]!="") $coa4total=$coa4total+$record["f5020399000"];
    if ($record["f5020401000"]!="") $coa5total=$coa5total+$record["f5020401000"];
    if ($record["f5020402000"]!="") $coa6total=$coa6total+$record["f5020402000"];
    if ($record["f5021203000"]!="") $coa7total=$coa7total+$record["f5021203000"];
    if ($record["amt"]!="") $amttotal=$amttotal+$record["amt"];
    
    array_push( $CIBRSorted, $record);
    

}
$breakdowntotal=($coa1total+$coa2total+$coa3total+$coa4total+$coa5total+$coa6total+$coa7total+$amttotal)-$taxtotal;
$totals=array("deptotal"=>number_format($deptotal, 2, '.', ''),
            "regmooetotal"=>number_format($regmooetotal, 2, '.', ''),
            "othtotal"=>number_format($othtotal, 2, '.', ''),
            "taxtotal"=>number_format($taxtotal, 2, '.', ''),
            "coa1total"=>number_format($coa1total, 2, '.', ''),
            "coa2total"=>number_format($coa2total, 2, '.', ''),
            "coa3total"=>number_format($coa3total, 2, '.', ''),
            "coa4total"=>number_format($coa4total, 2, '.', ''),
            "coa5total"=>number_format($coa5total, 2, '.', ''),
            "coa6total"=>number_format($coa6total, 2, '.', ''),
            "coa7total"=>number_format($coa7total, 2, '.', ''),
            "amttotal"=>number_format($amttotal, 2, '.', ''),
            "recaptotal"=>number_format(0, 2, '.', ''),
            "breakdowntotal"=>number_format($breakdowntotal, 2, '.', '')
          );
            
$RlessMBal=number_format($RunningBalance+$schinfo["maintbal"], 2, '.', '');
$regmooeendbal=number_format($regmooetrtotal-$regmooetotal, 2, '.', '');
$othfundendbal=number_format($othfundtrtotal-$othtotal, 2, '.', '');
$endbal=array("regmooeendbal"=>$regmooeendbal,
              "othfundendbal"=>$othfundendbal,
              "endingbalance"=>$RunningBalance,
              "RlessMBal"=>$RlessMBal

             );




    // array_push( $gsysmenuid_arr["cibr"], $CIBRSorted);
    // array_push( $gsysmenuid_arr["totals"], $totals);
    // array_push( $gsysmenuid_arr["endbal"], $endbal);
    // array_push( $gsysmenuid_arr["schinfo"], $schinfo);
    // print_r($CIBRSorted);
    array_push( $gsysmenuid_arr["cibr"], $CIBRSorted);
    array_push( $gsysmenuid_arr["totals"], $totals);
    array_push( $gsysmenuid_arr["endbal"], $endbal);
    array_push( $gsysmenuid_arr["schinfo"], $schinfo);
    array_push( $gsysmenuid_arr["schinfo"]["schacctinfo"], $schacctinfo);
    
    array_push( $gsysmenuid_arr["recap"], 0);

    echo json_encode($gsysmenuid_arr);
    // echo json_encode(
    //     array("message" => "No records found.")
    // );
}
?>