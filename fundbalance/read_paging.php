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


$fundbalance->set_property("schdivid",$data->schdivid) ;
$fundbalance->set_property("fundyear",$data->fundyear) ;
$schguid="";
$fundmonth="";
if (isset($data->schguid)){
    $schguid=$data->schguid;
}
if (isset($data->fundmonth)){
    $fundmonth=$data->fundmonth;
}
if ($schguid!=""){
    $fundbalance->set_property("schguid",$data->schguid) ;
}
if ($fundmonth!=""){
    $fundbalance->set_property("fundmonth",$data->fundmonth) ;
}

// $fundbalance->set_property("confirmed","N") ;

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}
 
// query products
$stmt = $fundbalance->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $gsysmenuid_arr=array();
    $gsysmenuid_arr["records"]=array();
    $gsysmenuid_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 	$gsysmenuid_item=$row;
        //$gsysmenuid_item=array(
        //    "id" => $id,
        //    "name" => $name,
        //    "description" => html_entity_decode($description),
        //    "price" => $price,
        //    "category_id" => $category_id,
        //    "category_name" => $category_name
        //);
 
        array_push($gsysmenuid_arr["records"], $gsysmenuid_item);
    }
 
 
    // include paging
    $total_rows=$fundbalance->count();
    $page_url="{$home_url}fundbalance/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $totalrecarr=array("totalcount"=>$total_rows);
    $fromrecnumarr=array("fromrecnum"=>$from_record_num+1);
    $untilrecnumarr=array("untilrecnum"=>$until_record_num+1);
    
    if ($total_rows>$records_per_page){
        $recpp=array("recperpage"=>$records_per_page);
    } else {
        $recpp=array("recperpage"=>$total_rows);
    }
    
    $paging=array_merge($paging,$totalrecarr);
    $paging=array_merge($paging,$recpp);
    $paging=array_merge($paging,$fromrecnumarr);
    $paging=array_merge($paging,$untilrecnumarr);
    $gsysmenuid_arr["paging"]=$paging;
 
    echo json_encode($gsysmenuid_arr);
}
 
else{
    echo json_encode(
        array("message" => "No records found.")
    );
}
?>