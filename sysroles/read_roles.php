<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/sysroles.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$sysroles = new sysroles($db);
$data = json_decode(file_get_contents("php://input"));
// echo $data;
// query products
$sysroles->set_roleguid($data->roleguid) ;
$stmt = $sysroles->readRoles();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $sysroles_arr=array();
    $sysroles_arr["records"]=array();
    $sysroles_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 	$sysroles_item=$row;
        //$sysroles_item=array(
        //    "id" => $id,
        //    "name" => $name,
        //    "description" => html_entity_decode($description),
        //    "price" => $price,
        //    "category_id" => $category_id,
        //    "category_name" => $category_name
        //);
 
        array_push($sysroles_arr["records"], $sysroles_item);
    }
 
 
    // include paging
    $total_rows=$sysroles->count();
    $page_url="{$home_url}sysroles/read_roles.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $sysroles_arr["paging"]=$paging;
 
    echo json_encode($sysroles_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Roles found.")
    );
}
?>