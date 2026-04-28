<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/transactions.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$transactions = new transactions($db);
 
// query products
$data = json_decode(file_get_contents("php://input"));
$transactions->set_recowner($data->recowner);

$stmt = $transactions->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $transactions_arr=array();
    $transactions_arr["records"]=array();
    $transactions_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 	$transactions_item=$row;
        //$transactions_item=array(
        //    "id" => $id,
        //    "name" => $name,
        //    "description" => html_entity_decode($description),
        //    "price" => $price,
        //    "category_id" => $category_id,
        //    "category_name" => $category_name
        //);
 
        array_push($transactions_arr["records"], $transactions_item);
    }
 
 
    // include paging
    $total_rows=$transactions->count();
    $page_url="{$home_url}transactions/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $transactions_arr["paging"]=$paging;
 
    echo json_encode($transactions_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Records Found.")
    );
}
?>