<?php

/**
 * workflow.class.php
 * 
 **/
class workflow {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "ct_workflow";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('wfguid'=>'wfguid');
	private $FIELD_NAME = array('wfguid'=>'wfguid',  'type'=>'type', 'status'=>'status', 'wforder'=>'wforder', 'wfprint'=>'wfprint','wfedit'=>'wfedit', 'description'=>'description', 'completed'=>'completed',   'rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //wfguid, `type`, `status`, wforder, description, completed, rectimestamp

	// protected $wfguid = null;
	// protected $type = null;
	// protected $divguid = null;
    // protected $schoolguid = null;
    // protected $wforder = null;
	// protected $description = null;
	// protected $completed = null;
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


	// public function set_wfguid($pArg='0') {
	// 	IF ( $this->wfguid !== $pArg){
	// 		$this->wfguid=$pArg; $this->FIELD_MODIFIED['wfguid']=1;
	// 	}
	// }
	// public function set_type($pArg='0') {
	// 	IF ( $this->type !== $pArg){
	// 		$this->type=$pArg; $this->FIELD_MODIFIED['type']=1;
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
    // public function set_wforder($pArg='0') {
	// 	IF ( $this->wforder !== $pArg){
	// 		$this->wforder=$pArg; $this->FIELD_MODIFIED['wforder']=1;
	// 	}
	// }
	// public function set_description($pArg='0') {
	// 	IF ( $this->description !== $pArg){
	// 		$this->description=$pArg; $this->FIELD_MODIFIED['description']=1;
	// 	}
	// }
	// public function set_completed($pArg='0') {
	// 	IF ( $this->completed !== $pArg){
	// 		$this->completed=$pArg; $this->FIELD_MODIFIED['completed']=1;
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
    
	// public function get_wfguid() { return (string) $this->wfguid; }
	// public function get_type() { return (string) $this->type; }
	// public function get_divguid() { return (string) $this->divguid; }
    // public function get_schoolguid() { return (string) $this->schoolguid; }
    // public function get_wforder() { return (string) $this->wforder; }
	// public function get_description() { return (string) $this->description; }
	// public function get_completed() { return (string) $this->divguid; }
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

function createIDQry(){
    $arr=$this->PRIMARY_KEY;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            if ($fistitem>1){
                $fld_list=$fld_list." and ";
            }
            $fld_list=$fld_list.$key."=:".$value;
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
    $wher="";
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            if ($wher=="") $wher=" WHERE ";
            if ($fistitem>1){
                $fld_list=$fld_list." and ";
            }
            $fld_list=$tblprfx.$fld_list.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    return $wher.$fld_list;
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

   $query = "Update " . $this->table_name . " SET ".$this->createUpdFlds()."  where ".$this->createIDQry();
 
   // prepare query
  //echo $query;
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
    $query = "delete from 
                " . $this->table_name . "
           
            WHERE
                wfguid = :wfguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":wfguid", $this->wfguid);

 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }
//Read One 
function readOne(){
 
    // query to read single record
    $tblprfx="a" ; 
    $query = "SELECT
                " . $this->createSelFlds($tblprfx) . "
            FROM
                " . $this->table_name . " " . $tblprfx ." 
                
            WHERE ".$this->createIDQry();
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $this->bindID($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    if ($row["completed"]=="Y") {
        $row["completed"]=array("on");
    } 
    $item_arr=$row;
    
    // get retrieved row
    return $item_arr ;
    

   }
   //Read Division Dash board 
    function readAllocatedTransferred(){

        // query to read single record
        $tblprfx="a" ; 
        $query = "select gaayear,c.type,
                        ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
                        ifnull(ROUND(sum(d.description)/1000000,2),0) Transferred, 
                        ifnull(ROUND(((sum(d.description)/sum(gaatotal)) ),2),0) TransferStatus,
                        ifnull(ROUND(sum(e.grossamount)/1000000,2),0) Utilized,
                        ifnull(ROUND(((sum(e.grossamount)/sum(d.description)) ),2),0) UtilizationStatus,
                        ifnull(ROUND(
                        sum(case 
                                  when e.liquidated='y' 
                                   then e.grossamount 
                                   else 0 
                               end ) /1000000
                        ,2),0) Liquidated,
                         ifnull(ROUND(
                         sum(case 
                                  when e.liquidated='y' 
                                   then e.grossamount 
                                   else 0 
                               end ) /1000000
                        ,2),0) / (ifnull(ROUND(sum(d.description)/1000000,2),0)) LiquidatedStatus
                            
                    from gaallocation a inner join 
                        schools b on a.status = b.status inner join 
                        schooldivisions c on b.type = c.type left join 
                        workflow d on b.status = d.status and d.fundyear = a.gaayear left join 
                        mooedisbursements e on d.wfguid = e.wfguid
                                        where c.type=:type and gaayear=:gaayear
                    group by gaayear,c.type";
    
        // prepare query statement
        
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
    
        $gaayear=$this->get_property("gaayear");
        $stmt->bindParam(":gaayear", $gaayear); 
        $this->bind($stmt);
        // execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;
    

   }

   //Read Top 10 Schools High Utilization
   function readTopHighUtils(){

        // query to read single record
        $tblprfx="a" ; 
        $query = "select  gaayear,c.type,b.schdescription,

                    ROUND(sum(ifnull(gaatotal,0))/1000000,2) Allocated, 
                    ROUND(sum(ifnull(d.description,0))/1000000,2) Transferred, 
                    ROUND(((sum(ifnull(d.description,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
                    ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
                    ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.description,0))) ),2),0) UtilizationStatus
                    ,b.status,
                    ROUND(((sum(ifnull(gaatotal,0)) - sum(ifnull(d.description,0)) ) / sum(ifnull(gaatotal,0))),2) GAABalance,
                    ifnull(ROUND((sum(ifnull(d.description,0))-sum(ifnull(e.grossamount,0)))/sum(ifnull(d.description,0)) ,2),0) FundBalance,
                    ifnull(ROUND(
                    sum(case 
                              when e.liquidated='y' 
                               then e.grossamount 
                               else 0 
                           end ) /1000000
                    ,2),0) Liquidated,
                     ifnull(ROUND(
                     sum(case 
                              when e.liquidated='y' 
                               then e.grossamount 
                               else 0 
                           end ) /1000000
                    ,2),0) / (ifnull(ROUND(sum(d.description)/1000000,2),0)) LiquidatedStatus

                    from gaallocation a inner join 
                        schools b on a.status = b.status inner join 
                        schooldivisions c on b.type = c.type left join 
                        workflow d on b.status = d.status and d.fundyear = a.gaayear left join 
                        mooedisbursements e on d.wfguid = e.wfguid
                                        where c.type=:type and gaayear=:gaayear
                    group by gaayear,c.type,b.status
                    order by 7 desc  ,schdescription asc 
                    limit 0,10";

        // prepare query statement
        
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated

        $gaayear=$this->get_property("gaayear");
        $stmt->bindParam(":gaayear", $gaayear); 
        $this->bind($stmt);
        // execute query
        $stmt->execute();
        return $stmt;


    }

    //Read Top 10 Schools Low Utilization
    function readTopLowUtils(){

        // query to read single record
        $tblprfx="a" ; 
        $query = "select  gaayear,c.type,b.schdescription,

                    ROUND(sum(ifnull(gaatotal,0))/1000000,2) Allocated, 
                    ROUND(sum(ifnull(d.description,0))/1000000,2) Transferred, 
                    ROUND(((sum(ifnull(d.description,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
                    ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
                    ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.description,0))) ),2),0) UtilizationStatus
                    ,b.status,
                    ROUND(((sum(ifnull(gaatotal,0)) - sum(ifnull(d.description,0)) ) / sum(ifnull(gaatotal,0))),2) GAABalance,
                    ifnull(ROUND((sum(ifnull(d.description,0))-sum(ifnull(e.grossamount,0)))/sum(ifnull(d.description,0)) ,2),0) FundBalance,
                    ifnull(ROUND(
                    sum(case 
                              when e.liquidated='y' 
                               then e.grossamount 
                               else 0 
                           end ) /1000000
                    ,2),0) Liquidated,
                     ifnull(ROUND(
                     sum(case 
                              when e.liquidated='y' 
                               then e.grossamount 
                               else 0 
                           end ) /1000000
                    ,2),0) / (ifnull(ROUND(sum(d.description)/1000000,2),0)) LiquidatedStatus

                    from gaallocation a inner join 
                        schools b on a.status = b.status inner join 
                        schooldivisions c on b.type = c.type left join 
                        workflow d on b.status = d.status and d.fundyear = a.gaayear left join 
                        mooedisbursements e on d.wfguid = e.wfguid
                                        where c.type=:type and gaayear=:gaayear
                    group by gaayear,c.type,b.status
                    order by 7 asc  ,schdescription asc 
                    limit 0,10";

        // prepare query statement
        
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated

        $gaayear=$this->get_property("gaayear");
        $stmt->bindParam(":gaayear", $gaayear); 
        $this->bind($stmt);
        // execute query
        $stmt->execute();
        return $stmt;


    }
    //Read Top 10 Schools High Utilization
   function readSchoolUtils(){

    // query to read single record
    $tblprfx="a" ; 
    $query = "select  gaayear,c.type,
                    ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
                    ifnull(ROUND(sum(d.description)/1000000,2),0) Transferred, 
                    ifnull(ROUND(((sum(d.description)/sum(gaatotal)) ),2),0) TransferStatus,
                    ifnull(ROUND(sum(e.grossamount)/1000000,2),0) Utilized,
                    ifnull(ROUND(((sum(e.grossamount)/sum(d.description)) ),2),0) UtilizationStatus ,
                    ifnull(ROUND(
                    sum(case 
                              when e.liquidated='y' 
                               then e.grossamount 
                               else 0 
                           end ) /1000000
                    ,2),0) Liquidated,
                     ifnull(ROUND(
                     sum(case 
                              when e.liquidated='y' 
                               then e.grossamount 
                               else 0 
                           end ) /1000000
                    ,2),0) / (ifnull(ROUND(sum(d.description)/1000000,2),0)) LiquidatedStatus
                        
                from gaallocation a inner join 
                    schools b on a.status = b.status inner join 
                    schooldivisions c on b.type = c.type left join 
                    workflow d on b.status = d.status and d.fundyear = a.gaayear left join 
                    mooedisbursements e on d.wfguid = e.wfguid
                where b.status=:status and gaayear=:gaayear
                group by gaayear,c.type,b.status
                order by 7 desc  ,schdescription asc 
                limit 0,10";

    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated

    $gaayear=$this->get_property("gaayear");
    $stmt->bindParam(":gaayear", $gaayear); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;


}
function readSchoolBalance(){

    // query to read single record
    $tblprfx="a" ; 
    $query = "select gaayear,c.type,b.schdescription,

                ROUND(sum(ifnull(gaatotal,0))/1000000,2) Allocated, 
                ROUND(sum(ifnull(d.description,0))/1000000,2) Transferred, 
                ROUND(((sum(ifnull(d.description,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
                ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
                ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.description,0))) ),2),0) UtilizationStatus
                ,b.status,
                (sum(ifnull(gaatotal,0)) - sum(ifnull(d.description,0)) )  GAABalance,
                sum(ifnull(d.description,0))-sum(ifnull(e.grossamount,0)) FundBalance
            from gaallocation a inner join 
            schools b on a.status = b.status inner join 
            schooldivisions c on b.type = c.type left join 
            workflow d on b.status = d.status and d.fundyear = a.gaayear left join 
            mooedisbursements e on d.wfguid = e.wfguid

                where b.status=:status and gaayear=:gaayear
                group by gaayear,c.type,b.status
                order by 7 desc  ,schdescription asc 
                limit 0,10";

    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated

    $gaayear=$this->get_property("gaayear");
    $stmt->bindParam(":gaayear", $gaayear); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;


}

function readFundBalance(){

    // query to read single record
    $tblprfx="a" ; 
    $query = "select a.description , 
                    ifnull(sum(b.grossamount),0) Utilized, 
                    ifnull(a.description - ifnull(sum(b.grossamount),0),0) Balance
                from workflow a inner join 
                    mooedisbursements b on a.wfguid = b.wfguid
                 ".$this->createWhereQry($tblprfx)."
                

            ";

    // prepare query statement b.status = :status and a.wfguid= wfguid
    
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated

    // $gaayear=$this->get_property("gaayear");
    // $stmt->bindParam(":gaayear", $gaayear); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;


}



    // read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
            // select query
            
            
            $tblprfx="a" ; 
            $query = "SELECT " 
                       .$this->createSelFlds($tblprfx) . " ,
                       b.description flowtype , c.name
                      
                FROM
                    "  .$this->table_name . " " . $tblprfx ." inner join 
                    ct_flowtypes b on a.type=b.ftypeid inner join 
                    ct_wfstatus c on a.status=c.id
                    
                ".$this->createWhereQry( $tblprfx)."
                order by a.rectimestamp desc
                LIMIT :L1, :L2";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
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
    public function readUnConfirmdPaging($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . " , b.wforderdescription, 
                   concat(  a.completed , ' | ', b.wforderdescription ) datedesc

            FROM
                "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.wforder=b.papguid 
                
            WHERE ".$this->createWhereQry()."

            LIMIT :L1, :L2";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
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


// used for paging user
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function UnConfirmdcount(){
    $tblprfx = "a";
    $query = "SELECT COUNT(*) as total_rows FROM
        "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.wforder=b.papguid 
    
        WHERE ".$this->createWhereQry();
 
    $stmt = $this->conn->prepare( $query );
    $this->bind($stmt);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

//get by group code 
function getbycode(){
 
    // query to read single record
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name . " 
                
            WHERE
                schoolguid= :schoolguid
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":schoolguid", $this->schoolguid);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->wfguid= $row['wfguid'];
    $this->schoolguid= $row['schoolguid'];
    $this->type= $row['type'];
    $this->divguid= $row['divguid'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
