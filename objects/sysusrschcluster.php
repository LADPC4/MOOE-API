<?php

/**
 * sysusrschcluster.class.php
 * 
 **/
class sysusrschcluster {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "sysusrschcluster";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('susrschaguid'=>'susrschaguid');
	private $FIELD_NAME = array('susrschaguid'=>'susrschaguid',  'schdivid'=>'schdivid', 'schguid'=>'schguid', 'guserid'=>'guserid',  'rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //susrschaguid, schdivid, guserid, schguid, rectimestamp

	// protected $susrschaguid = null;
	// protected $schdivid = null;
	// protected $divguid = null;
    // protected $schoolguid = null;
    // protected $guserid = null;
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


	// public function set_susrschaguid($pArg='0') {
	// 	IF ( $this->susrschaguid !== $pArg){
	// 		$this->susrschaguid=$pArg; $this->FIELD_MODIFIED['susrschaguid']=1;
	// 	}
	// }
	// public function set_schdivid($pArg='0') {
	// 	IF ( $this->schdivid !== $pArg){
	// 		$this->schdivid=$pArg; $this->FIELD_MODIFIED['schdivid']=1;
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
    // public function set_guserid($pArg='0') {
	// 	IF ( $this->guserid !== $pArg){
	// 		$this->guserid=$pArg; $this->FIELD_MODIFIED['guserid']=1;
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
    
	// public function get_susrschaguid() { return (string) $this->susrschaguid; }
	// public function get_schdivid() { return (string) $this->schdivid; }
	// public function get_divguid() { return (string) $this->divguid; }
    // public function get_schoolguid() { return (string) $this->schoolguid; }
    // public function get_guserid() { return (string) $this->guserid; }
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
            // echo "{$key} => {$value} "; 
            // echo  $fld_list;
            if ($fistitem>1){
                $fld_list=$fld_list." and ";
            }
            $fld_list=$fld_list.$tblprfx.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    // echo  $fld_list;
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
//    echo $query;
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
           
            WHERE ".$this->createWhereQry();
 
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
function readOne(){
 
    // query to read single record
   
    

   }


  public function readPaging($from_record_num, $records_per_page){
 
            // select query
            
            
            $tblprfx="a" ; 
            $query = "SELECT  "  
                       .$this->createSelFlds($tblprfx) . "
                       ,b.divdescription, c.schdescription , c.schoolid 
                       ,d.glastname, d.gfirstname
                FROM
                    "  .$this->table_name . " " . $tblprfx ." inner join 
                    schooldivisions b  on a.schdivid=b.schdivid inner join 
                    schools c on a.schguid=c.schguid inner join 
                    sysusers d on a.guserid=d.guserid
                    
                    
                WHERE ".$this->createWhereQry($tblprfx)."
                order by a.rectimestamp desc
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
    public function readUnConfirmdPaging($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . " , b.guseriddescription, 
                   concat(  a.transferdate , ' | ', b.guseriddescription ) datedesc

            FROM
                "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.guserid=b.papguid 
                
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
        "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.guserid=b.papguid 
    
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
    $this->susrschaguid= $row['susrschaguid'];
    $this->schoolguid= $row['schoolguid'];
    $this->schdivid= $row['schdivid'];
    $this->divguid= $row['divguid'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
