<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/papcodes.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$papcodes = new papcodes($db);
 
// query products
$stmt = $papcodes->readOthersPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $papcodes_arr=array();
    $papcodes_arr["records"]=array();
    $papcodes_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 	$papcodes_item=$row;
        //$papcodes_item=array(
        //    "id" => $id,
        //    "name" => $name,
        //    "description" => html_entity_decode($description),
        //    "price" => $price,
        //    "category_id" => $category_id,
        //    "category_name" => $category_name
        //);
 
        array_push($papcodes_arr["records"], $papcodes_item);
    }
 
 
    // include paging
    $total_rows=$papcodes->otherscount();
    $page_url="{$home_url}papcodes/read_otherspaging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $papcodes_arr["paging"]=$paging;
 
    echo json_encode($papcodes_arr);
}
 
else{
    echo json_encode(
        array("message" => "No users found.")
    );
}
?>