<?php

/**
 * schoolregions.class.php
 * 
 **/
class schoolregions {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "schoolregions";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('schregid'=>'schregid');
	private $FIELD_NAME = array('schregid'=>'schregid',  'schregdescription'=>'schregdescription',  'rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //schregid, schregid, divguid, schoolguid, paps, totalamount, transferdate, fundyear, mooerequest, rectimestamp

	// protected $schregid = null;
	// protected $schregdescription = null;
	// protected $divguid = null;
    // protected $schoolguid = null;
    // protected $paps = null;
	// protected $totalamount = null;
	// protected $transferdate = null;
    // protected $fundyear = null;
    // protected $mooerequest = null;
    // protected $userguid = null;
    // protected $rectimestamp = null;

    protected $properties =array();

    
    


	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        
    }

    //set property 

    public function set_property($pName, $pArg='0') {
        //chek if array exists 
        if (isset($this->properties[$pName])) {
            $this->properties[$pName]=$pArg;
        } else {
            $newprop=array($pName=>$pArg);
            $this->properties=array_merge($this->properties,$newprop);
        }	
	}
    public function get_property($pName) { return (string) $this->properties[$pName]; }


	// public function set_schregid($pArg='0') {
	// 	IF ( $this->schregid !== $pArg){
	// 		$this->schregid=$pArg; $this->FIELD_MODIFIED['schregid']=1;
	// 	}
	// }
	// public function set_schregdescription($pArg='0') {
	// 	IF ( $this->schregdescription !== $pArg){
	// 		$this->schregdescription=$pArg; $this->FIELD_MODIFIED['schregdescription']=1;
	// 	}
	// }
	// public function set_divguid($pArg='0') {
	// 	IF ( $this->divguid !== $pArg){
	// 		$this->divguid=$pArg; $this->FIELD_MODIFIED['divguid']=1;
	// 	}
	// }
    // public function set_schoolguid($pArg='0') {
	// 	IF ( $this->schoolguid !== $pArg){
	// 		$this->schoolguid=$pArg; $this->FIELD_MODIFIED['schoolguid']=1;
	// 	}
    // }
    // public function set_paps($pArg='0') {
	// 	IF ( $this->paps !== $pArg){
	// 		$this->paps=$pArg; $this->FIELD_MODIFIED['paps']=1;
	// 	}
	// }
	// public function set_totalamount($pArg='0') {
	// 	IF ( $this->totalamount !== $pArg){
	// 		$this->totalamount=$pArg; $this->FIELD_MODIFIED['totalamount']=1;
	// 	}
	// }
	// public function set_transferdate($pArg='0') {
	// 	IF ( $this->transferdate !== $pArg){
	// 		$this->transferdate=$pArg; $this->FIELD_MODIFIED['transferdate']=1;
	// 	}
	// }
    // public function set_fundyear($pArg='0') {
	// 	IF ( $this->fundyear !== $pArg){
	// 		$this->fundyear=$pArg; $this->FIELD_MODIFIED['fundyear']=1;
	// 	}
    // }
    // public function set_mooerequest($pArg='0') {
	// 	IF ( $this->mooerequest !== $pArg){
	// 		$this->mooerequest=$pArg; $this->FIELD_MODIFIED['mooerequest']=1;
	// 	}
    // }
    // public function set_userguid($pArg='0') {
	// 	IF ( $this->userguid !== $pArg){
	// 		$this->userguid=$pArg; $this->FIELD_MODIFIED['userguid']=1;
	// 	}
    // }
    
	// public function get_schregid() { return (string) $this->schregid; }
	// public function get_schregdescription() { return (string) $this->schregdescription; }
	// public function get_divguid() { return (string) $this->divguid; }
    // public function get_schoolguid() { return (string) $this->schoolguid; }
    // public function get_paps() { return (string) $this->paps; }
	// public function get_totalamount() { return (string) $this->totalamount; }
	// public function get_transferdate() { return (string) $this->divguid; }
	// public function get_fundyear() { return (string) $this->fundyear; }
    // public function get_mooerequest() { return (string) $this->mooerequest; }
    // public function get_userguid() { return (string) $this->userguid; }
    // public function get_rectimestamp() { return (string) $this->rectimestamp; }
    

//create insert/update field and bindings
function createUpdFlds(){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            if ($fistitem>1){
                $fld_list=$fld_list.",";
            }
            $fld_list=$fld_list.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    return $fld_list;
}
function createSelFlds($tblprfx=""){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    if ($tblprfx!="") $tblprfx=$tblprfx.".";
    // print_r($arr);
    foreach ($arr as $key => $value) {
        if ($fistitem>1){
            $fld_list=$fld_list.",";
        }
        $fld_list=$fld_list.$tblprfx.$key;
        $fistitem=$fistitem+1;
    }
    return $fld_list;
}

function createIDQry($tblprfx){
    $arr=$this->PRIMARY_KEY;
    $fld_list="";
    $fistitem=1;
    if ($tblprfx!="") $tblprfx=$tblprfx.".";
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            if ($fistitem>1){
                $fld_list=$fld_list." and ";
            }
            $fld_list=$fld_list.$tblprfx.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    return $fld_list;
}
function createWhereQry($tblprfx=""){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    if ($tblprfx!="") $tblprfx=$tblprfx.".";
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            if ($fistitem>1){
                $fld_list=$fld_list." and ";
            } 
            if ($fistitem==1) {
                $fld_list=$fld_list." WHERE ";
            }
            $fld_list=$fld_list.$tblprfx.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    return $fld_list;
}


//Bind
function bind(&$stmt){
 
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        
        // $fld_list=$fld_list.$key."=:".$value;
        if (isset($PRIMARY_KEY[$key])) {
            //do nothing 
        } else {
            
            if (isset( $this->properties[$key])) {
                $stmt->bindParam(":".$key, $this->properties[$key]); 
            }
        }
        
    }
    

}
function bindID(&$stmt){
    $arr=$this->PRIMARY_KEY;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            $stmt->bindParam(":".$key, $this->properties[$key]); 
        }
        

    }
    

}
  
function sanitize(){

    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        
        // $fld_list=$fld_list.$key."=:".$value;
        if (isset($PRIMARY_KEY[$key])) {
            //do nothing 
        } else {
            if (isset( $this->properties[$key])) {
                $this->properties[$key]=htmlspecialchars(strip_tags($this->properties[$key])); 
            }
            
        }
        
    }

}
    

//create
function create(){
 
    // query to insert record

    $query = "INSERT INTO " . $this->table_name . " SET ".$this->createUpdFlds();
 
    // prepare query
   //echo $query;
    $stmt = $this->conn->prepare($query);
    // sanitize
    $this->sanitize();
    // bind values
    $this->bind($stmt);
    
    // $this->divguid=htmlspecialchars(strip_tags($this->divguid));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
 
   
   
  


    // execute query
    if($stmt->execute()){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
}

//update 
function update(){
 
   // query to insert record
   $tblprfx="" ;
   $query = "Update " . $this->table_name . " SET ".$this->createUpdFlds()."  where ".$this->createIDQry($tblprfx);
 
   // prepare query
//   echo $query;
   $stmt = $this->conn->prepare($query);
   // sanitize
   $this->sanitize();
   // bind values
   $this->bind($stmt);

   // execute query
   if($stmt->execute()){
       return true;
   }
   $this->lasterror=implode(" ",$stmt->errorInfo());
   return false;
     
   }

//delete 
function delete(){
 
    // update query
    $tblprfx="" ; 
    $query = "delete from 
                " . $this->table_name . "
           
            WHERE ".$this->createIDQry($tblprfx);
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $this->bind($stmt);
 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }
//Read One 
// function readOne(){
 
//     // query to read single record
//     $tblprfx="a" ; 
//     $query = "SELECT
//                 " . $this->createSelFlds($tblprfx) . "
//                 ,b.schdescription,c.papsdescription papsdesc, d.fundackid
//                 ,e.requestid ,  CONCAT(DATE(e.rectimestamp),' | ',c.papsdescription ) reqdesc
//             FROM
//                 " . $this->table_name . " " . $tblprfx ." inner join 
//                 schools b on a.schguid=b.schguid inner join 
//                 papcodes c on a.paps=c.papguid left join 
//                 fundconfirm d on a.schregid=d.schregid left  join
//                 mooerequests e on a.mooerequest=e.requestid 
                
//             WHERE ".$this->createIDQry($tblprfx);
 
//     // prepare query statement
    
//     $stmt = $this->conn->prepare( $query );
//     // echo $query; 
//     // bind id of product to be updated
   
//     $this->bindID($stmt);
//     // execute query
//     $stmt->execute();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     // print_r($row);
//     $item_arr=$row;
//     // get retrieved row
//     return $item_arr ;
    

//    }
//    //Read Division Dash board 
//     function readAllocatedTransferred(){

//         // query to read single record
//         $tblprfx="a" ; 
//         $query = "select gaayear,c.schregdescription,
//                         ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
//                         ifnull(ROUND(sum(d.totalamount)/1000000,2),0) Transferred, 
//                         ifnull(ROUND(((sum(d.totalamount)/sum(gaatotal)) ),2),0) TransferStatus,
//                         ifnull(ROUND(sum(e.grossamount)/1000000,2),0) Utilized,
//                         ifnull(ROUND(((sum(e.grossamount)/sum(d.totalamount)) ),2),0) UtilizationStatus,
//                         ifnull(ROUND(
//                         sum(case 
//                                   when e.liquidated='y' 
//                                    then e.grossamount 
//                                    else 0 
//                                end ) /1000000
//                         ,2),0) Liquidated,
//                          ifnull(ROUND(
//                          sum(case 
//                                   when e.liquidated='y' 
//                                    then e.grossamount 
//                                    else 0 
//                                end ) /1000000
//                         ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus
                            
//                     from gaallocation a inner join 
//                         schools b on a.schguid = b.schguid inner join 
//                         schooldivisions c on b.schregdescription = c.schregdescription left join 
//                         schoolregions d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
//                         mooedisbursements e on d.schregid = e.schregid
//                                         where c.schregdescription=:schregdescription and gaayear=:gaayear
//                     group by gaayear,c.schregdescription";
    
//         // prepare query statement
        
//         $stmt = $this->conn->prepare( $query );
    
//         // bind id of product to be updated
    
//         $gaayear=$this->get_property("gaayear");
//         $stmt->bindParam(":gaayear", $gaayear); 
//         $this->bind($stmt);
//         // execute query
//         $stmt->execute();
//         $row = $stmt->fetch(PDO::FETCH_ASSOC);
//         // print_r($row);
//         $item_arr=$row;
//         // get retrieved row
//         return $item_arr ;
    

//    }
//    function readRegAllocatedTransferred(){

//     // query to read single record
//     $tblprfx="a" ; 
//     $query = "select gaayear,f.schregid,
//                     ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
//                     ifnull(ROUND(sum(d.totalamount)/1000000,2),0) Transferred, 
//                     ifnull(ROUND(((sum(d.totalamount)/sum(gaatotal)) ),2),0) TransferStatus,
//                     ifnull(ROUND(sum(e.grossamount)/1000000,2),0) Utilized,
//                     ifnull(ROUND(((sum(e.grossamount)/sum(d.totalamount)) ),2),0) UtilizationStatus,
//                     ifnull(ROUND(
//                     sum(case 
//                               when e.liquidated='y' 
//                                then e.grossamount 
//                                else 0 
//                            end ) /1000000
//                     ,2),0) Liquidated,
//                      ifnull(ROUND(
//                      sum(case 
//                               when e.liquidated='y' 
//                                then e.grossamount 
//                                else 0 
//                            end ) /1000000
//                     ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus
                        
//                 from gaallocation a inner join 
//                     schools b on a.schguid = b.schguid inner join 
//                     schooldivisions c on b.schregdescription = c.schregdescription left join 
//                     schoolregions d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
//                     mooedisbursements e on d.schregid = e.schregid inner join 
//                     schoolregions f on c.schregid = f.schregid
                    
//                                     where f.schregid=:schregid and gaayear=:gaayear
//                 group by gaayear,f.schregid";

//     // prepare query statement
    
//     $stmt = $this->conn->prepare( $query );

//     // bind id of product to be updated

//     $gaayear=$this->get_property("gaayear");
//     $schregid=$this->get_property("schregid");
//     $stmt->bindParam(":gaayear", $gaayear); 
//     $stmt->bindParam(":schregid", $schregid); 
//     $this->bind($stmt);
//     // execute query
//     $stmt->execute();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     // print_r($row);
//     $item_arr=$row;
//     // get retrieved row
//     return $item_arr ;


// }

//    //Read Top 10 Schools High Utilization
//    function readTopHighUtils(){

//         // query to read single record
//         $tblprfx="a" ; 
//         $query = "select  gaayear,c.schregdescription,b.schdescription,

//                     ROUND(sum(ifnull(gaatotal,0))/1000000,2) Allocated, 
//                     ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
//                     ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
//                     ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
//                     ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
//                     ,b.schguid,
//                     ROUND(((sum(ifnull(gaatotal,0)) - sum(ifnull(d.totalamount,0)) ) / sum(ifnull(gaatotal,0))),2) GAABalance,
//                     ifnull(ROUND((sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)))/sum(ifnull(d.totalamount,0)) ,2),0) FundBalance,
//                     ifnull(ROUND(
//                     sum(case 
//                               when e.liquidated='y' 
//                                then e.grossamount 
//                                else 0 
//                            end ) /1000000
//                     ,2),0) Liquidated,
//                      ifnull(ROUND(
//                      sum(case 
//                               when e.liquidated='y' 
//                                then e.grossamount 
//                                else 0 
//                            end ) /1000000
//                     ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus

//                     from gaallocation a inner join 
//                         schools b on a.schguid = b.schguid inner join 
//                         schooldivisions c on b.schregdescription = c.schregdescription left join 
//                         schoolregions d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
//                         mooedisbursements e on d.schregid = e.schregid
//                                         where c.schregdescription=:schregdescription and gaayear=:gaayear
//                     group by gaayear,c.schregdescription,b.schguid
//                     order by 7 desc  ,schdescription asc 
//                     limit 0,10";

//         // prepare query statement
        
//         $stmt = $this->conn->prepare( $query );

//         // bind id of product to be updated

//         $gaayear=$this->get_property("gaayear");
//         $stmt->bindParam(":gaayear", $gaayear); 
//         $this->bind($stmt);
//         // execute query
//         $stmt->execute();
//         return $stmt;


//     }

//     //Read Top 10 Schools Low Utilization
//     function readTopLowUtils(){

//         // query to read single record
//         $tblprfx="a" ; 
//         $query = "select  gaayear,c.schregdescription,b.schdescription,

//                     ROUND(sum(ifnull(gaatotal,0))/1000000,2) Allocated, 
//                     ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
//                     ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
//                     ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
//                     ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
//                     ,b.schguid,
//                     ROUND(((sum(ifnull(gaatotal,0)) - sum(ifnull(d.totalamount,0)) ) / sum(ifnull(gaatotal,0))),2) GAABalance,
//                     ifnull(ROUND((sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)))/sum(ifnull(d.totalamount,0)) ,2),0) FundBalance,
//                     ifnull(ROUND(
//                     sum(case 
//                               when e.liquidated='y' 
//                                then e.grossamount 
//                                else 0 
//                            end ) /1000000
//                     ,2),0) Liquidated,
//                      ifnull(ROUND(
//                      sum(case 
//                               when e.liquidated='y' 
//                                then e.grossamount 
//                                else 0 
//                            end ) /1000000
//                     ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus

//                     from gaallocation a inner join 
//                         schools b on a.schguid = b.schguid inner join 
//                         schooldivisions c on b.schregdescription = c.schregdescription left join 
//                         schoolregions d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
//                         mooedisbursements e on d.schregid = e.schregid
//                                         where c.schregdescription=:schregdescription and gaayear=:gaayear
//                     group by gaayear,c.schregdescription,b.schguid
//                     order by 7 asc  ,schdescription asc 
//                     limit 0,10";

//         // prepare query statement
        
//         $stmt = $this->conn->prepare( $query );

//         // bind id of product to be updated

//         $gaayear=$this->get_property("gaayear");
//         $stmt->bindParam(":gaayear", $gaayear); 
//         $this->bind($stmt);
//         // execute query
//         $stmt->execute();
//         return $stmt;


//     }
//     //Read Top 10 Schools High Utilization
//    function readSchoolUtils(){

//     // query to read single record
//     $tblprfx="a" ; 
//     $query = "select  gaayear,c.schregdescription,
//                     ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
//                     ifnull(ROUND(sum(d.totalamount)/1000000,2),0) Transferred, 
//                     ifnull(ROUND(((sum(d.totalamount)/sum(gaatotal)) ),2),0) TransferStatus,
//                     ifnull(ROUND(sum(e.grossamount)/1000000,2),0) Utilized,
//                     ifnull(ROUND(((sum(e.grossamount)/sum(d.totalamount)) ),2),0) UtilizationStatus ,
//                     ifnull(ROUND(
//                     sum(case 
//                               when e.liquidated='y' 
//                                then e.grossamount 
//                                else 0 
//                            end ) /1000000
//                     ,2),0) Liquidated,
//                      ifnull(ROUND(
//                      sum(case 
//                               when e.liquidated='y' 
//                                then e.grossamount 
//                                else 0 
//                            end ) /1000000
//                     ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus
                        
//                 from gaallocation a inner join 
//                     schools b on a.schguid = b.schguid inner join 
//                     schooldivisions c on b.schregdescription = c.schregdescription left join 
//                     schoolregions d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
//                     mooedisbursements e on d.schregid = e.schregid
//                 where b.schguid=:schguid and gaayear=:gaayear
//                 group by gaayear,c.schregdescription,b.schguid
//                 order by 7 desc  ,schdescription asc 
//                 limit 0,10";

//     // prepare query statement
    
//     $stmt = $this->conn->prepare( $query );

//     // bind id of product to be updated

//     $gaayear=$this->get_property("gaayear");
//     $stmt->bindParam(":gaayear", $gaayear); 
//     $this->bind($stmt);
//     // execute query
//     $stmt->execute();
//         $row = $stmt->fetch(PDO::FETCH_ASSOC);
//         // print_r($row);
//         $item_arr=$row;
//         // get retrieved row
//         return $item_arr ;


// }
// function readSchoolBalance($gaafield='gaatotal'){

//     // query to read single record
//     $tblprfx="a" ; 

//     // $query = "select gaayear,c.schregdescription,b.schdescription,

//     //             ROUND(sum(ifnull(gaatotal,0))/1000000,2) Allocated, 
//     //             ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
//     //             ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
//     //             ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
//     //             ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
//     //             ,b.schguid,
//     //             (sum(ifnull(gaatotal,0)) - sum(ifnull(d.totalamount,0)) )  GAABalance,
//     //             sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)) FundBalance
//     //         from gaallocation a inner join 
//     //         schools b on a.schguid = b.schguid inner join 
//     //         schooldivisions c on b.schregdescription = c.schregdescription left join 
//     //         schoolregions d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
//     //         mooedisbursements e on d.schregid = e.schregid

//     //             where b.schguid=:schguid and gaayear=:gaayear
//     //             group by gaayear,c.schregdescription,b.schguid
//     //             order by 7 desc  ,schdescription asc 
//     //             limit 0,10";
//     $query = "select gaayear,c.schregdescription,b.schdescription,

//                     ROUND(sum(ifnull(".$gaafield.",0))/1000000,2) Allocated, 
//                     ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
//                     ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(".$gaafield.",0))) ),2) TransferStatus,
//                     ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
//                     ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
//                     ,b.schguid,
//                     (sum(ifnull(".$gaafield.",0)) - sum(ifnull(d.totalamount,0)) )  GAABalance,
//                     sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)) FundBalance
//                 from gaallocation a inner join 
//                 schools b on a.schguid = b.schguid inner join 
//                 schooldivisions c on b.schregdescription = c.schregdescription left join 
//                 schoolregions d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
//                 mooedisbursements e on d.schregid = e.schregid

//                     where b.schguid=:schguid and gaayear=:gaayear
//                     group by gaayear,c.schregdescription,b.schguid
//                     order by 7 desc  ,schdescription asc 
//                     limit 0,10";
//     // prepare query statement
    
//     $stmt = $this->conn->prepare( $query );
//     // echo $query;
//     // bind id of product to be updated

//     $gaayear=$this->get_property("gaayear");
//     $stmt->bindParam(":gaayear", $gaayear); 
//     $this->bind($stmt);
//     // execute query
//     $stmt->execute();
//         $row = $stmt->fetch(PDO::FETCH_ASSOC);
//         // print_r($row);
//         $item_arr=$row;
//         // get retrieved row
//         return $item_arr ;


// }

// function readFundBalance(){

//     // query to read single record
//     $tblprfx="a" ; 
//     $query = "select a.totalamount , 
//                     ifnull(sum(b.grossamount),0) Utilized, 
//                     ifnull(a.totalamount - ifnull(sum(b.grossamount),0),0) Balance
//                 from schoolregions a inner join 
//                     mooedisbursements b on a.schregid = b.schregid
//                 where ".$this->createWhereQry($tblprfx)."
                

//             ";

//     // prepare query statement b.schguid = :schguid and a.schregid= schregid
    
//     $stmt = $this->conn->prepare( $query );

//     // bind id of product to be updated

//     // $gaayear=$this->get_property("gaayear");
//     // $stmt->bindParam(":gaayear", $gaayear); 
//     $this->bind($stmt);
//     // execute query
//     $stmt->execute();
//         $row = $stmt->fetch(PDO::FETCH_ASSOC);
//         // print_r($row);
//         $item_arr=$row;
//         // get retrieved row
//         return $item_arr ;


// }



    // read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
            // select query
            
            
            $tblprfx="a" ; 
            $query = "SELECT " 
                       .$this->createSelFlds($tblprfx) . "
                      
                FROM
                    "  .$this->table_name . " " . $tblprfx ." 
                    
                ".$this->createWhereQry( $tblprfx)."
                order by rectimestamp desc
                LIMIT :L1, :L2";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
            // echo $query;
            // bind query parameters
            $this->bind($stmt);
            // bind variable values
            $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
        
            // execute query
            $stmt->execute();
        
            // return values from database
            return $stmt;
    }
//     public function readUnConfirmdPaging($from_record_num, $records_per_page){
 
//         // select query
        
        
//         $tblprfx="a" ; 
//         $query = "SELECT " 
//                    .$this->createSelFlds($tblprfx) . " , b.papsdescription, 
//                    concat(  a.transferdate , ' | ', b.papsdescription ) datedesc

//             FROM
//                 "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.paps=b.papguid 
                
//             WHERE ".$this->createWhereQry()."

//             LIMIT :L1, :L2";
    
//         // prepare query statement
//         $stmt = $this->conn->prepare( $query );
//         // bind query parameters
//         $this->bind($stmt);
//         // bind variable values
//         $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
//         $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
    
//         // execute query
//         $stmt->execute();
    
//         // return values from database
//         return $stmt;
// }


// used for paging user
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

// public function UnConfirmdcount(){
//     $tblprfx = "a";
//     $query = "SELECT COUNT(*) as total_rows FROM
//         "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.paps=b.papguid 
    
//         WHERE ".$this->createWhereQry();
 
//     $stmt = $this->conn->prepare( $query );
//     $this->bind($stmt);
//     $stmt->execute();
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
//     return $row['total_rows'];
// }

// //get by group code 
// function getbycode(){
 
//     // query to read single record
//     $query = "SELECT
//                 " . implode (', ',  $this->FIELD_NAME ) . "
//             FROM
//                 " . $this->table_name . " 
                
//             WHERE
//                 schoolguid= :schoolguid
//             LIMIT
//                 0,1";
 
//     // prepare query statement
    
//     $stmt = $this->conn->prepare( $query );
 
//     // bind id of product to be updated
   
//     $stmt->bindParam(":schoolguid", $this->schoolguid);
//     // execute query
//     $stmt->execute();
 
//     // get retrieved row
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
//     // set values to object properties
//     $this->schregid= $row['schregid'];
//     $this->schoolguid= $row['schoolguid'];
//     $this->schregdescription= $row['schregdescription'];
//     $this->divguid= $row['divguid'];
//     $this->rectimestamp= $row['rectimestamp'];
//    }
   

           

}
