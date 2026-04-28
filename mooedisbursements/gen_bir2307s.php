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
include_once '../objects/schools.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$mooedisbursements = new mooedisbursements($db);
$schools = new schools($db);


// get posted data
$data = json_decode(file_get_contents("php://input"));
// echo ("Nelson ");


// echo "Test";


// $mooedisbursements->set_property("schguid",$data->schguid) ;
$mooedisbursements->set_property("dismonth",$data->fundmonth) ;
$mooedisbursements->set_property("fundyear",$data->fundyear) ;
$mooedisbursements->set_property("schguid",$data->schguid) ;

// $schools->set_schguid($data->schguid) ;


if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}
//getschoo info 
// $schinfo=$schools->readOne();
// $schinfo=$schools->readOne();
// print_r($schinfo);

// $signatory2=$schools->getschheadsign($schinfo["ES"],$schinfo["JHS"],$schinfo["SHS"]);
// $schinfo["signatory2"]=$signatory2;

$monthNum  = $data->fundmonth;
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March
$schinfo["month"]=$monthName;

$regmooetrtotal=0;
$othfundtrtotal=0;
// CIBR Entries 
$RunningBalance=0;
$recctr=0;
$bir2307=array();
$bir2307["es"]["vat"]=array();
$bir2307["es"]["nonvat"]=array();
$bir2307["jhs"]["vat"]=array();
$bir2307["jhs"]["nonvat"]=array();
$bir2307["shs"]["vat"]=array();
$bir2307["shs"]["nonvat"]=array();
// $bir2307["records"]=array();
//, , , ,,, 
$entry=array(
    "fundyear"=>"",
    "papsdescription"=>"",
    "es"=>"",
    "jhs"=>"",
    "shs"=>"",
    "dismonth"=>"",
    "schdescription"=>"",
    "schoolid"=>"",
    
    "WV010"=>"",
    "WV020"=>"", 							
    "WB084"=>"",
    "WC157"=>"",
    "WC640"=>"",
    "totaltax"=>"",
    "grossamount"=>""

);

 

// query transactions 
$stmt = $mooedisbursements->genBIR2307s($from_record_num, $records_per_page);
// print_r($stmt);
$num = $stmt->rowCount();
// echo $num; 
// check if more than 0 record found
if($num>0){
 
    // products array
    $gsysmenuid_arr=array();
    // $gsysmenuid_arr["records"]=array();
    // $gsysmenuid_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    $totals=array(
        "WV010e"=>0,
        "WV020e"=>0, 							
        "WB084e"=>0,
        "WB080e"=>0,
        "WC157e"=>0,
        "WC640e"=>0,
        "totaltaxe"=>0,
        "WV010j"=>0,
        "WV020j"=>0, 							
        "WB084j"=>0,
        "WB080j"=>0,
        "WC157j"=>0,
        "WC640j"=>0,
        "totaltaxj"=>0,
        "WV010s"=>0,
        "WV020s"=>0, 							
        "WB084s"=>0,
        "WB080s"=>0,
        "WC157s"=>0,
        "WC640s"=>0,
        "totaltaxs"=>0,
        "grossamount"=>0,
        "netamount"=>0
    );
    $tWV010=0;
    $tWV020=0;							
    $tWB084=0;
    $tWB080=0;
    $tWC157=0;
    $tWC640=0;
    $tWI640=0;
    $tWI157=0;
    $ttotaltax=0;
    $ttotalnetamt=0;
    $ttotalgrossamount=0;

    $teWV010=0;
    $teWV020=0;							
    $teWB084=0;
    $teWB080=0;
    $teWC157=0;
    $teWC640=0;
    $teWI640=0;
    $teWI157=0;
    $tetotaltax=0;
    $tetotalnetamt=0;
    $tetotalgrossamount=0;

    $tjWV010=0;
    $tjWV020=0;							
    $tjWB084=0;							
    $tjWB080=0;
    $tjWC157=0;
    $tjWC640=0;
    $tjWI640=0;
    $tjWI157=0;
    $tjtotaltax=0;
    $tjtotalnetamt=0;
    $tjtotalgrossamount=0;

    $tsWV010=0;
    $tsWV020=0;							
    $tsWB084=0;							
    $tsWB080=0;
    $tsWC157=0;
    $tsWC640=0;
    $tsWI640=0;
    $tsWI157=0;
    $tstotaltax=0;
    $tstotalnetamt=0;
    $tstotalgrossamount=0;

    $tgrossamount=0;
    
    $ectr=0;
    $jctr=0;
    $sctr=0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $recctr=$recctr+1;
        // fd.fundyear,  pc.papsdescription ,pc.es,pc.jhs,pc.shs,  dismonth,  sc.schdescription, sc.schoolid
        $entry=array(
            "recctr"=>$recctr,
            "fundyear"=>$row["fundyear"],
            "papsdescription"=>$row["papsdescription"],
            "es"=>$row["es"],
            "jhs"=>$row["jhs"],
            "shs"=>$row["shs"],
            "dismonth"=>$row["dismonth"],
            // "schdescription"=>$row["schdescription"],
            "schoolid"=>$row["schoolid"],
            "disreferenceno"=>$row["disreferenceno"],
            "disrefdate"=>$row["disrefdate"],
            "payee"=>$row["payee"], 
            "payeetin"=>$row["payeetin"],
            "particulars"=>$row["particulars"],
            "trantype"=>$row["trantype"],
            "vattype"=>$row["vattype"],
            "WV010"=>number_format($row["WV010"], 2, '.', ''),
            "WV020"=>number_format($row["WV020"], 2, '.', ''), 							
            "WB084"=>number_format($row["WB084"], 2, '.', ''),
            "WB080"=>number_format($row["WB080"], 2, '.', ''),
            "WC157"=>number_format($row["WC157"], 2, '.', ''),
            "WC640"=>number_format($row["WC640"], 2, '.', ''),
            "WI640"=>number_format($row["WI640"], 2, '.', ''),
            "WI157"=>number_format($row["WI157"], 2, '.', ''),
            "totaltax"=>number_format($row["totaltax"], 2, '.', ''),
            "grossamount"=>number_format($row["grossamount"], 2, '.', ''),
            "netamount"=>number_format($row["grossamount"] - $row["totaltax"], 2, '.', '')

            
        
        );
        //add to totals 
        if ($row["es"]=='Y') {
            $ectr=$ectr+1;
            $teWV010=$teWV010+$row["WV010"];
            $teWV020=$teWV020+$row["WV020"];						
            $teWB084=$teWB084+$row["WB084"];
            $teWB080=$teWB080+$row["WB080"];
            $teWC157=$teWC157+$row["WC157"];
            $teWC640=$teWC640+$row["WC640"];
            $teWI640=$teWI640+$row["WI640"];
            $teWI157=$teWI157+$row["WI157"];
            $tetotaltax=$tetotaltax+$row["totaltax"];
            $tetotalnetamt=$tetotalnetamt+$row["grossamount"] - $row["totaltax"];
            $tetotalgrossamount=$tetotalgrossamount+$row["grossamount"];
            $entry["ctr"]=$ectr;
            if ($row["vattype"]=='VAT'){
                array_push($bir2307["es"]["vat"],$entry);
            } else {
                array_push($bir2307["es"]["nonvat"],$entry);
            }
            
        }
        if ($row["jhs"]=='Y') {
            $jctr=$jctr+1;
            $tjWV010=$tjWV010+$row["WV010"];
            $tjWV020=$tjWV020+$row["WV020"];						
            $tjWB084=$tjWB084+$row["WB084"];
            $tjWB080=$tjWB080+$row["WB080"];
            $tjWC157=$tjWC157+$row["WC157"];
            $tjWC640=$tjWC640+$row["WC640"];
            $tjWI640=$tjWI640+$row["WI640"];
            $tjWI157=$tjWI157+$row["WI157"];
            $tjtotaltax=$tjtotaltax+$row["totaltax"];
            $tjtotalnetamt=$tjtotalnetamt+$row["grossamount"] - $row["totaltax"];
            $tjtotalgrossamount=$tjtotalgrossamount+$row["grossamount"];
            $entry["ctr"]=$jctr;
            if ($row["vattype"]=='VAT'){
                array_push($bir2307["jhs"]["vat"],$entry);
            } else {
                array_push($bir2307["jhs"]["nonvat"],$entry);
            }
        }
        if ($row["shs"]=='Y') {
            $sctr=$sctr+1;
            $tsWV010=$tsWV010+$row["WV010"];
            $tsWV020=$tsWV020+$row["WV020"];						
            $tsWB084=$tsWB084+$row["WB084"];
            $tsWB080=$tsWB080+$row["WB080"];
            $tsWC157=$tsWC157+$row["WC157"];
            $tsWC640=$tsWC640+$row["WC640"];
            $tsWI640=$tsWI640+$row["WI640"];
            $tsWI157=$tsWI157+$row["WI157"];
            $tstotaltax=$tstotaltax+$row["totaltax"];
            $tstotalnetamt=$tstotalnetamt+$row["grossamount"] - $row["totaltax"];
            $tstotalgrossamount=$tstotalgrossamount+$row["grossamount"];
            $entry["ctr"]=$sctr;
            if ($row["vattype"]=='VAT'){
                array_push($bir2307["shs"]["vat"],$entry);
            } else {
                array_push($bir2307["shs"]["nonvat"],$entry);
            }
        }
        
        // array_push($bir2307["records"],$entry);


        $tgrossamount=$tgrossamount+$row["grossamount"];
        

        // $RunningBalance=number_format($RunningBalance-$row["netamount"], 2, '.', '');
        // $entry["balance"]=$RunningBalance;
        
        
        
        
        // array_push( $gsysmenuid_arr["bir2307"], $entry);
        
       
    }

    $tWV010=$teWV010+$tjWV010+$tsWV010;
    $tWV020=$teWV020+$tjWV020+$tsWV020;							
    $tWB084=$teWB084+$tjWB084+$tsWB084;
    $tWC157=$teWC157+$tjWC157+$tsWC157;
    $tWC640=$teWC640+$tjWC640+$tsWC640;
    $tWI157=$teWI157+$tjWI157+$tsWI157;
    $tWI640=$teWI640+$tjWI640+$tsWI640;
    $ttotaltax=$tetotaltax+$tjtotaltax+$tstotaltax;
    $ttotalnetamt=$tetotalnetamt+$tjtotalnetamt+$tstotalnetamt;
    $ttotalgrossamount=$tetotalgrossamount+$tjtotalgrossamount+$tstotalgrossamount;

    $totals["WV010e"]=number_format($teWV010, 2, '.', '');
    $totals["WV020e"]=number_format($teWV020, 2, '.', ''); 							
    $totals["WB084e"]=number_format($teWB084, 2, '.', '');
    $totals["WB080e"]=number_format($teWB084, 2, '.', '');
    $totals["WC157e"]=number_format($teWC157, 2, '.', '');
    $totals["WC640e"]=number_format($teWC640, 2, '.', '');
    $totals["WI157e"]=number_format($teWI157, 2, '.', '');
    $totals["WI640e"]=number_format($teWI640, 2, '.', '');
    $totals["totaltaxe"]=number_format($tetotaltax, 2, '.', '');
    $totals["totalnetamte"]=number_format($tetotalnetamt, 2, '.', '');
    $totals["totalgrossamounte"]=number_format($tetotalgrossamount, 2, '.', '');

    $totals["WV010j"]=number_format($tjWV010, 2, '.', '');
    $totals["WV020j"]=number_format($tjWV020, 2, '.', ''); 							
    $totals["WB084j"]=number_format($tjWB084, 2, '.', '');
    $totals["WB080j"]=number_format($tjWB084, 2, '.', '');
    $totals["WC157j"]=number_format($tjWC157, 2, '.', '');
    $totals["WC640j"]=number_format($tjWC640, 2, '.', '');
    $totals["WI157j"]=number_format($teWI157, 2, '.', '');
    $totals["WI640j"]=number_format($teWI640, 2, '.', '');
    $totals["totaltaxj"]=number_format($tjtotaltax, 2, '.', '');
    $totals["totalnetamtj"]=number_format($tjtotalnetamt, 2, '.', '');
    $totals["totalgrossamountj"]=number_format($tjtotalgrossamount, 2, '.', '');

    $totals["WV010s"]=number_format($tsWV010, 2, '.', '');
    $totals["WV020s"]=number_format($tsWV020, 2, '.', ''); 							
    $totals["WB084s"]=number_format($tsWB084, 2, '.', '');
    $totals["WB080s"]=number_format($tsWB084, 2, '.', '');
    $totals["WC157s"]=number_format($tsWC157, 2, '.', '');
    $totals["WC640s"]=number_format($tsWC640, 2, '.', '');
    $totals["WI157s"]=number_format($teWI157, 2, '.', '');
    $totals["WI640s"]=number_format($teWI640, 2, '.', '');
    $totals["totaltaxs"]=number_format($tstotaltax, 2, '.', '');
    $totals["totalnetamts"]=number_format($tstotalnetamt, 2, '.', '');
    $totals["totalgrossamounts"]=number_format($tstotalgrossamount, 2, '.', '');

    $totals["WV010"]=number_format($tWV010, 2, '.', '');
    $totals["WV020"]=number_format($tWV020, 2, '.', ''); 							
    $totals["WB084"]=number_format($tWB084, 2, '.', '');
    $totals["WB080"]=number_format($tWB080, 2, '.', '');
    $totals["WC157"]=number_format($tWC157, 2, '.', '');
    $totals["WC640"]=number_format($tWC640, 2, '.', '');
    $totals["WI157"]=number_format($tWI157, 2, '.', '');
    $totals["WI640"]=number_format($tWI640, 2, '.', '');
    $totals["totaltax"]=number_format($ttotaltax, 2, '.', '');
    $totals["totalgrossamount"]=number_format($ttotaltax, 2, '.', '');
    $totals["totalnetamt"]=number_format($ttotalnetamt, 2, '.', '');

    $totals["grossamount"]=number_format($tgrossamount, 2, '.', '');
 
    $gsysmenuid_arr=array();
   
    // print_r($bir2307);
    // print_r($totals);
    // print_r($schinfo);
    
    $gsysmenuid_arr["totals"]=array();
    // $gsysmenuid_arr["schinfo"]=array();
    $gsysmenuid_arr["bir2307"]=array();
    $gsysmenuid_arr["bir2307"]= $bir2307;
    $gsysmenuid_arr["totals"]=$totals;
    // $gsysmenuid_arr["schinfo"]= $schinfo;
    

    echo json_encode($gsysmenuid_arr);




    
    
    
    
  
}

?>