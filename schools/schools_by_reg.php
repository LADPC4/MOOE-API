<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/schools.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$schools = new schools($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$schools->set_schregid($data->schregid);
$schools->set_schdivid($data->schdivid);
if (isset($data->searchname))
{
    $schools->set_schdescription($data->searchname);
} 



 
// query products
$stmt = $schools->readSchoolsByReg();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $schools_arr=array();
    $schools_arr["records"]=array();
    $schools_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 	$schools_item=$row;
        //$schools_item=array(
        //    "id" => $id,
        //    "name" => $name,
        //    "description" => html_entity_decode($description),
        //    "price" => $price,
        //    "category_id" => $category_id,
        //    "category_name" => $category_name
        //);
 
        array_push($schools_arr["records"], $schools_item);
    }
 
 
    // include paging
    $total_rows=$schools->count();
    $page_url="{$home_url}schools/schools_by_div.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $schools_arr["paging"]=$paging;
 
    echo json_encode($schools_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Schools found.")
    );
}
?>