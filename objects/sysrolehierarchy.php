<?php

/**
 * sysrolehierarchy.class.php
 * 
 **/
class sysrolehierarchy {

	//Create Connection property
	private $conn;
	//declare table roleguid
   	private $table_sysrolehierarchy = "sysrolehierarchy";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('srhguid'=>'srhguid');
	private $FIELD_roleguid = array('srhguid'=>'srhguid',  'roleguid'=>'roleguid', 'childroleguid'=>'childroleguid', 'rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //srhguid, roleguid, childroleguid, rectimestamp

	// protected $sysrolehierarchy = null;
	// protected $roleguid = null;
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

    public function set_property($proleguid, $pArg='0') {
        //chek if array exists 
        if (isset($this->properties[$proleguid])) {
            $this->properties[$proleguid]=$pArg;
        } else {
            $newprop=array($proleguid=>$pArg);
            $this->properties=array_merge($this->properties,$newprop);
        }	
	}
    public function get_property($proleguid) { return (string) $this->properties[$proleguid]; }


	// public function set_sysrolehierarchy($pArg='0') {
	// 	IF ( $this->sysrolehierarchy !== $pArg){
	// 		$this->sysrolehierarchy=$pArg; $this->FIELD_MODIFIED['sysrolehierarchy']=1;
	// 	}
	// }
	// public function set_roleguid($pArg='0') {
	// 	IF ( $this->roleguid !== $pArg){
	// 		$this->roleguid=$pArg; $this->FIELD_MODIFIED['roleguid']=1;
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
    
	// public function get_sysrolehierarchy() { return (string) $this->sysrolehierarchy; }
	// public function get_roleguid() { return (string) $this->roleguid; }
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
    $arr=$this->FIELD_roleguid;
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
    $arr=$this->FIELD_roleguid;
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
    $arr=$this->FIELD_roleguid;
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
 
    $arr=$this->FIELD_roleguid;
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

    $arr=$this->FIELD_roleguid;
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

    $query = "INSERT INTO " . $this->table_sysrolehierarchy . " SET ".$this->createUpdFlds();
 
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

   $query = "Update " . $this->table_sysrolehierarchy . " SET ".$this->createUpdFlds()."  where ".$this->createIDQry();
 
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

    $where=$this->createWhereQry();
    if ($where=="") return false;
    $query = "delete from 
                " . $this->table_sysrolehierarchy . "
           
             ".$where;
 
    // prepare query statement
    // echo $query;
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
function readOne(){
 
    // query to read single record
    $tblprfx="a" ; 
    $query = "SELECT
                " . $this->createSelFlds($tblprfx) . "
            FROM
                " . $this->table_sysrolehierarchy . " " . $tblprfx ." 
                
            WHERE ".$this->createIDQry();
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $this->bindID($stmt);
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
            $query = "select distinct a.roleguid, b.roledescription
                      from sysrolehierarchy a inner join 
                  sysroles b on a.roleguid=b.roleguid inner join 
                  sysroles c on a.childroleguid=c.roleguid
            
                
                ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
            // bind query parameters
            $this->bind($stmt);
            // // bind variable values
            // $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
            // $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
        
            // execute query
            $stmt->execute();
        
            // return values from database
            return $stmt;
    }
    
    public function readrolehierarchy(){
 
        // select query
        
        
        $tblprfx="a" ; 
        $query = "select ". $this->createSelFlds($tblprfx) ."
            from sysrolehierarchy a inner join 
            sysroles b on a.roleguid=b.roleguid inner join 
            sysroles c on a.childroleguid=c.roleguid
                     
            ".$this->createWhereQry($tblprfx);
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        $this->bind($stmt);
        // // bind variable values
        // $stmt->bindParam(":roleguid", PDO::PARAM_STR);
        // $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }

// used for paging user
public function rolehierarchycount(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_sysrolehierarchy . " where 
    roleguid=:roleguid";
 
    $stmt = $this->conn->prepare( $query );
    $this->bind($stmt);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_sysrolehierarchy . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}



           

}
