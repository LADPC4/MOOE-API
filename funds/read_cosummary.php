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
include_once '../objects/funds.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$funds = new funds($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
// echo ("Nelson ");



// $funds->set_property("schguid",$data->schguid) ;
// $funds->set_property("confirmed","Y") ;

if (empty($data)) {
   echo '{';
        echo '"message": "No Data Sent."';
    echo '}';
   return;
}


$funds->set_property("fundyear",$data->fundyear) ;
$funds->set_property("schtype",$data->schtype) ;



// query products
$stmt = $funds->COSummary();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $gsysmenuid_arr=array();
    $gsysmenuid_arr["records"]=array();
    $gsysmenuid_arr["totals"]=array();
    $gsysmenuid_arr["paging"]=array();
    $t=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    $ttotalES=0;
    $ttotalJHS=0;
    $ttotalSHS=0;
    $ttotal=0;

    $ltotalES=0;
    $ltotalJHS=0;
    $ltotalSHS=0;
    $ltotal=0;

    $gtotalES=0;
    $gtotalJHS=0;
    $gtotalSHS=0;
    $gtotal=0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        // print_r($row);
        //$gsysmenuid_item=array(
        //    "id" => $id,
        //    "name" => $name,
        //    "description" => html_entity_decode($description),
        //    "price" => $price,
        //    "category_id" => $category_id,
        //    "category_name" => $category_name
        //);
        $gtotalES=$gtotalES+$row["TotalES"];
        $gtotalJHS=$gtotalJHS+$row["TotalJHS"];;
        $gtotalSHS=$gtotalSHS+$row["TotalSHS"];
        $gtotal=$gtotal+$row["TotalAllocation"];

        $ttotalES=$ttotalES+$row["TotalTransferredES"];
        $ttotalJHS=$ttotalJHS+$row["TotalTransferredJHS"];;
        $ttotalSHS=$ttotalSHS+$row["TotalTransferredSHS"];
        $ttotal=$ttotal+$row["TotalTransferredES"] + $row["TotalTransferredJHS"] + $row["TotalTransferredSHS"];

        $ltotalES=$ltotalES+$row["TotalLiquidES"];
        $ltotalJHS=$ltotalJHS+$row["TotalLiquidJHS"];;
        $ltotalSHS=$ltotalSHS+$row["TotalLiquidSHS"];
        $ltotal=$ltotal+$row["TotalLiquidES"] + $row["TotalLiquidJHS"] + $row["TotalLiquidSHS"];







        $row["TotalTransferred"]= number_format($row["TotalTransferredES"] + $row["TotalTransferredJHS"] + $row["TotalTransferredSHS"], 2, '.', '');
        $row["TotalLiquid"]= number_format($row["TotalLiquidES"] + $row["TotalLiquidJHS"] + $row["TotalLiquidSHS"], 2, '.', '');
        if ($row["TotalTransferredES"]>0 ){
            $row["PES"]=number_format(($row["TotalLiquidES"]/$row["TotalTransferredES"])*100, 2, '.', '');
        } else  {
            $row["PES"]=0;
        }
        if ($row["TotalTransferredJHS"]>0) {
            $row["PJHS"]=number_format(($row["TotalLiquidJHS"]/$row["TotalTransferredJHS"])*100, 2, '.', '');
        } else {
            $row["PJHS"]=0;
        }
        if ($row["TotalTransferredSHS"]>0) {
            $row["PSHS"]=number_format(($row["TotalLiquidSHS"]/$row["TotalTransferredSHS"])*100, 2, '.', '');
        } else {
            $row["PSHS"]=0;
        }
        if ($row["TotalTransferred"]>0) {
            $row["PLT"]=number_format(($row["TotalLiquid"]/$row["TotalTransferred"])*100, 2, '.', '');
        } else {
            $row["PLT"]=0;
        }
        
       
        

        $row["Balance"]=number_format(($row["TotalTransferred"]-$row["TotalLiquid"]), 2, '.', '');



        // $row["AveTransConfDays"]= number_format($row["AveTransConfDays"], 2, '.', '');
        // $row["SchoolswithFunds"]= number_format($row["SchoolswithFunds"], 2, '.', '');
        // $row["TotalSchools"]= number_format($row["TotalSchools"], 2, '.', '');
        // $row["TransferStatus"]= number_format($row["TransferStatus"], 2, '.', '');
        $gsysmenuid_item=$row;
        array_push($gsysmenuid_arr["records"], $gsysmenuid_item);
    }
 
      	
	$t["TotalES"]=$gtotalES;
    $t["TotalJHS"]=$gtotalJHS;
    $t["TotalSHS"]=$gtotalSHS;
    $t["TotalAllocation"]=$gtotal;

    $t["TotalTransferredES"]=$ttotalES;
    $t["TotalTransferredJHS"]=$ttotalJHS;
    $t["TotalTransferredSHS"]=$ttotalSHS;
    $t["TotalTransferred"]=$ttotalES+$ttotalJHS+$ttotalSHS;

    $t["TotalLiquidES"]=$ltotalES;
    $t["TotalLiquidJHS"]=$ltotalJHS;
    $t["TotalLiquidSHS"]=$ltotalSHS;
    $t["TotalLiquid"]= $ltotalES+$ltotalJHS+$ltotalSHS;

    $t["PES"]=number_format(($ltotalES/$ttotalES)*100, 2, '.', '');
    $t["PJHS"]=number_format(($ltotalJHS/$ttotalJHS)*100, 2, '.', '');
    $t["PSHS"]=number_format(($ltotalSHS/$ttotalSHS)*100, 2, '.', '');
    $t["PLT"]=number_format(($ltotal/$ttotal)*100, 2, '.', '');

    $t["Balance"]=$t["TotalTransferred"]-$t["TotalLiquid"];

    $gsysmenuid_arr["totals"]= $t;
    // include paging
    // $total_rows=$funds->OtherFundscount();
    // $page_url="{$home_url}funds/read_unconfirmedfunds.php?";
    // $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    // $totalrecarr=array("totalcount"=>$total_rows);
    // $fromrecnumarr=array("fromrecnum"=>$from_record_num+1);
    // $untilrecnumarr=array("untilrecnum"=>$until_record_num+1);
    
    // if ($total_rows>$records_per_page){
    //     $recpp=array("recperpage"=>$records_per_page);
    // } else {
    //     $recpp=array("recperpage"=>$total_rows);
    // }
    
    // $paging=array_merge($paging,$totalrecarr);
    // $paging=array_merge($paging,$recpp);
    // $paging=array_merge($paging,$fromrecnumarr);
    // $paging=array_merge($paging,$untilrecnumarr);
    // $gsysmenuid_arr["paging"]=$paging;
 
    echo json_encode($gsysmenuid_arr);
}
 
else{
    echo json_encode(
        array("message" => "No records found.")
    );
}
?>