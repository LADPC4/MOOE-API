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
include_once '../objects/mooedisbursements.php';
include_once '../objects/ct_chartofacc.php';

 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$mooedisbursements = new mooedisbursements($db);
$coa = new chartofacc($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
// echo ("Nelson ");





// $mooedisbursements->set_property("schregid",$data->schregid) ;
// $mooedisbursements->set_property("dismonth",$data->fundmonth) ;
$mooedisbursements->set_property("fundyear",$data->fundyear) ;

// $schools->set_schguid($data->schguid) ;


if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}




// $monthNum  = $data->fundmonth;
// $dateObj   = DateTime::createFromFormat('!m', $monthNum);
// $monthName = $dateObj->format('F'); // March

$recctr=0;

//Prep chart of accounts

$coastmt = $coa->readPaging(0,10000);
$coanum = $coastmt->rowCount();
$coarows=array();
$gtotals=array();
$stotals=array();
$stotals["ES"]=array();
$stotals["JHS"]=array();
$stotals["SHS"]=array();
$ltotals=array();
$ltotals["ES"]=0;
$ltotals["JHS"]=0;
$ltotals["SHS"]=0;
$ltotals["GT"]=0;


while ($coarow = $coastmt->fetch(PDO::FETCH_ASSOC)){
    // print_r($coarow );
    $tcoacode=$coarow["coacode"];
    $coarows[$coarow["coacode"]]=array("coacode"=>$coarow["coacode"],"desc"=>$coarow["coadesc"], "amount"=>'');
    $gtotals[$coarow["coacode"]]=0;
    $stotals["ES"][$tcoacode]=0;
    $stotals["JHS"][$tcoacode]=0;
    $stotals["SHS"][$tcoacode]=0;
    // array_push($coarows[$coarow["coacode"]],$coarow);
}
 

// query transactions 
$stmt = $mooedisbursements->genCOOEMain();
$num = $stmt->rowCount();

$DOOE=array();
$DOOE["ES"]=array();
$DOOE["JHS"]=array();
$DOOE["SHS"]=array();


 
// check if more than 0 record found
if($num>0){
 
    // products array
    $gsysmenuid_arr=array();
    // $gsysmenuid_arr["records"]=array();
    // $gsysmenuid_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
   
    $recctr=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        if (array_key_exists($row["slevel"],$recctr)==false) {
            $recctr[$row["slevel"]]=0;
        }
        $recctr[$row["slevel"]]+=1;
        $row["recctr"]=$recctr[$row["slevel"]];
        
        $entry["coa"] =array();
        $thiscoarows= $coarows;
        //fetch details 
        



        $detstmt=$mooedisbursements->genCOOEDetails($row["schregid"],$data->fundyear,$row["slevel"]);
        // echo $detstmt->rowCount();
        while ($detrow = $detstmt->fetch(PDO::FETCH_ASSOC)){
            $thiscoa =  $thiscoarows[$detrow["coacode"]];
            $thiscoa["amount"] = $detrow["total_utils"];
            $thiscoarows[$detrow["coacode"]] = $thiscoa ;
            $thislevel=$row["slevel"];
            $thiscode=$detrow["coacode"];
            if (array_key_exists($thiscode,$stotals[$thislevel])==false) {
                $stotals[$thislevel][$thiscode]=0;
            }
            $gtotals[$thiscode]+=$thiscoa["amount"];
            $stotals[$thislevel][$thiscode]+=$thiscoa["amount"];
            $ltotals[$thislevel]+=$thiscoa["amount"];
            $ltotals["GT"]+=$thiscoa["amount"];
        }
        $thistotalutuils=0;
        $uetstmt=$mooedisbursements->genCOOEDivTotalUtils($row["schregid"],$data->fundyear,$row["slevel"]);
        $unum = $uetstmt->rowCount();
        // echo$row["schregid"]."|".$data->fundyear."|".$row["slevel"] ;
        if($unum>0){
            $urow = $uetstmt->fetch(PDO::FETCH_ASSOC);
            // print_r($urow);
            $row["total_utils"]=$urow["total_utils"];
            // echo $row["total_utils"];

        }
        $entry = $row;
        $entry["coa"] =$thiscoarows ;
     
        array_push($DOOE[$row["slevel"]],$entry);

       
    }
   
 
    $gsysmenuid_arr=array();
   
    // print_r($bir2307);
    // print_r($totals);
    // print_r($schinfo);
    
    $gsysmenuid_arr["totals"]=array();
    $gsysmenuid_arr["schinfo"]=array();
    $gsysmenuid_arr["DOOE"]=array();
    $gsysmenuid_arr["coarows"]=array();
    $gsysmenuid_arr["ltotals"]=array();
    $gsysmenuid_arr["DOOE"]= $DOOE;
    $gsysmenuid_arr["totals"]["gtotals"]=$gtotals;
    $gsysmenuid_arr["totals"]["stotals"]=$stotals;
    $gsysmenuid_arr["coarows"]=$coarows;
    $gsysmenuid_arr["ltotals"]=$ltotals;
    

    echo json_encode($gsysmenuid_arr);




    
    
    
    
  
}
?>