<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/schooldivisions.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$schooldivisions = new schooldivisions($db);
$data = json_decode(file_get_contents("php://input"));
 
 
// print_r($data);
// query products
if (isset($data->schregid)){
    // set ID property of product to be edited
    $schooldivisions->set_schregid($data->schregid);
    $stmt = $schooldivisions->readByReg();
} else {
    $stmt = $schooldivisions->readAll();
}

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $schooldivisions_arr=array();
    $schooldivisions_arr["records"]=array();
    $schooldivisions_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 	$schooldivisions_item=$row;
        //$schooldivisions_item=array(
        //    "id" => $id,
        //    "name" => $name,
        //    "description" => html_entity_decode($description),
        //    "price" => $price,
        //    "category_id" => $category_id,
        //    "category_name" => $category_name
        //);
 
        array_push($schooldivisions_arr["records"], $schooldivisions_item);
    }
 
 
    // include paging
    $total_rows=$schooldivisions->count();
    $page_url="{$home_url}schooldivisions/read_all.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $schooldivisions_arr["paging"]=$paging;
 
    echo json_encode($schooldivisions_arr);
}
 
else{
    echo json_encode(
        array("message" => "No users found.")
    );
}
?>