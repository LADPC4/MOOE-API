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





$mooedisbursements->set_property("schguid",$data->schguid) ;
$mooedisbursements->set_property("dismonth",$data->fundmonth) ;
$mooedisbursements->set_property("fundyear",$data->fundyear) ;

$schools->set_schguid($data->schguid) ;


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

$signatory2=$schools->getschheadsign($schinfo["ES"],$schinfo["JHS"],$schinfo["SHS"]);
$schinfo["signatory2"]=$signatory2;

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
//, , , ,,, 
$entry=array(
    "fundyear"=>"",
    "dismonth"=>"",
    "disrefdate"=>"",
    "payee"=>"",
    "payeetin"=>"",
    "vattype"=>"",
    "trantype"=>"",
    "WV010"=>"",
    "WV020"=>"", 							
    "WB080"=>"",
    "WC157"=>"",
    "WC640"=>"",
    "totaltax"=>"",
    "grossamount"=>""

);

 

// query transactions 
$stmt = $mooedisbursements->genBIR2307($from_record_num, $records_per_page);
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
    $totals=array(
        "WV010"=>0,
        "WV020"=>0, 							
        "WB080"=>0,
        "WC157"=>0,
        "WC640"=>0,
        "totaltax"=>0,
        "grossamount"=>0
    );
    $tWV010=0;
    $tWV020=0;							
    $tWB080=0;
    $tWC157=0;
    $tWC640=0;
    $ttotaltax=0;
    $tgrossamount=0;
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $recctr=$recctr+1;
        $entry=array(
            "recctr"=>$recctr,
            "fundyear"=>$row["fundyear"],
            "dismonth"=>$row["dismonth"],
            "disrefdate"=>$row["disrefdate"],
            "payee"=>$row["payee"],
            "payeetin"=>$row["payeetin"],
            "vattype"=>$row["vattype"],
            "trantype"=>$row["trantype"],
            "WV010"=>number_format($row["WV010"], 2, '.', ''),
            "WV020"=>number_format($row["WV020"], 2, '.', ''), 							
            "WB080"=>number_format($row["WB080"], 2, '.', ''),
            "WC157"=>number_format($row["WC157"], 2, '.', ''),
            "WC640"=>number_format($row["WC640"], 2, '.', ''),
            "totaltax"=>number_format($row["totaltax"], 2, '.', ''),
            "grossamount"=>number_format($row["grossamount"], 2, '.', '')
        
        );
        //add to totals 

        $tWV010=$tWV010+$row["WV010"];
        $tWV020=$tWV020+$row["WV020"];						
        $tWB080=$tWB080+$row["WB080"];
        $tWC157=$tWC157+$row["WC157"];
        $tWC640=$tWC640+$row["WC640"];
        $ttotaltax=$ttotaltax+$row["totaltax"];
        $tgrossamount=$tgrossamount+$row["grossamount"];
        

        // $RunningBalance=number_format($RunningBalance-$row["netamount"], 2, '.', '');
        // $entry["balance"]=$RunningBalance;
        
        
        
        
        // array_push( $gsysmenuid_arr["bir2307"], $entry);
        array_push($bir2307,$entry);
       
    }
    $totals["WV010"]=number_format($tWV010, 2, '.', '');
    $totals["WV020"]=number_format($tWV020, 2, '.', ''); 							
    $totals["WB080"]=number_format($tWB080, 2, '.', '');
    $totals["WC157"]=number_format($tWC157, 2, '.', '');
    $totals["WC640"]=number_format($tWC640, 2, '.', '');
    $totals["totaltax"]=number_format($ttotaltax, 2, '.', '');
    $totals["grossamount"]=number_format($tgrossamount, 2, '.', '');
 
    $gsysmenuid_arr=array();
   
    // print_r($bir2307);
    // print_r($totals);
    // print_r($schinfo);
    
    $gsysmenuid_arr["totals"]=array();
    $gsysmenuid_arr["schinfo"]=array();
    $gsysmenuid_arr["bir2307"]=array();
    $gsysmenuid_arr["bir2307"]= $bir2307;
    $gsysmenuid_arr["totals"]=$totals;
    $gsysmenuid_arr["schinfo"]= $schinfo;
    

    echo json_encode($gsysmenuid_arr);




    
    
    
    
  
}
?>