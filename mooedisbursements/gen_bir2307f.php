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
include_once '../objects/atc.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$mooedisbursements = new mooedisbursements($db);
$schools = new schools($db);
$atc = new atc($db);


// get posted data
$data = json_decode(file_get_contents("php://input"));
// echo ("Nelson ");





// $mooedisbursements->set_property("schguid",$data->schguid) ;
// $mooedisbursements->set_property("dismonth",$data->fundmonth) ;
$mooedisbursements->set_property("mooedisid",$data->mooedisid) ;

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

$monthNum  = $data->dismonth;
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
    "WB084"=>"",
    "WC157"=>"",
    "WC640"=>"",
    "totaltax"=>"",
    "grossamount"=>""

);

 

// query transactions 
$stmt = $mooedisbursements->genBIR2307f($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $gsysmenuid_arr=array();
    // $gsysmenuid_arr["records"]='';
    // $gsysmenuid_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    // $gsysmenuid_arr=array();
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $recctr=$recctr+1;
       
        
        $rec1=null;
        $rec2=null;
        // $RunningBalance=number_format($RunningBalance-$row["netamount"], 2, '.', '');
        // $entry["balance"]=$RunningBalance;
        $atc->set_property("atc",$row["ATC"]);
        $rec1=$atc->readOne();
        $atcdesc1=$rec1["description"];
        $atc->set_property("atc",$row["ATC2"]);
        $rec2=$atc->readOne();
        // print_r($row);
        $atcdesc2=$rec2["description"];

        $row["particulars"]=$atcdesc1;
        $row["particulars2"]=$atcdesc2;
        
        $gsysmenuid_arr["disbdetails"]=$row;
        // array_push( $gsysmenuid_arr["records"], $row);
        // array_push($bir2307,$entry);
       
    }
  
 
    
    // print_r($bir2307);
    // print_r($totals);
    // print_r($schinfo);
    
    // $gsysmenuid_arr["totals"]=array();
    // $gsysmenuid_arr["schinfo"]=array();
    // $gsysmenuid_arr["bir2307"]=array();
    // $gsysmenuid_arr["bir2307"]= $bir2307;
    // $gsysmenuid_arr["totals"]=$totals;
    $gsysmenuid_arr["schinfo"]= $schinfo;
    

    echo json_encode($gsysmenuid_arr);




    
    
    
    
  
}
?>