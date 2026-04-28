<?php

/**
 * fundconfirm.class.php
 * 
 **/
class fundconfirm {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "fundconfirm";
	//auto generated
    public $lasterror=null;
	public static $PRIMARY_KEY = array('fundackid'=>'fundackid');
	private $FIELD_NAME = array('fundackid'=>'fundackid',  'fundguid'=>'fundguid', 'schguid'=>'schguid',  'ackdate'=>'ackdate', 'ctmor'=>'ctmor','receivername'=>'receivername','receivercontact'=>'receivercontact',  'guserid'=>'guserid', 'rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //fundguid, fundguid, divguid, schoolguid, paps, totalamount, transferdate, fundyear, mooerequest, rectimestamp

	// protected $fundguid = null;
	// protected $schdivid = null;
	// protected $divguid = null;
    // protected $schoolguid = null;
    // protected $paps = null;
	// protected $totalamount = null;
	// protected $transferdate = null;
    // protected $fundyear = null;
    // protected $mooerequest = null;
    // protected $guserid = null;
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
    public function get_property($pName) { return (string) $this->properties[pName]; }


	// public function set_fundguid($pArg='0') {
	// 	IF ( $this->fundguid !== $pArg){
	// 		$this->fundguid=$pArg; $this->FIELD_MODIFIED['fundguid']=1;
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
    // public function set_guserid($pArg='0') {
	// 	IF ( $this->guserid !== $pArg){
	// 		$this->guserid=$pArg; $this->FIELD_MODIFIED['guserid']=1;
	// 	}
    // }
    
	// public function get_fundguid() { return (string) $this->fundguid; }
	// public function get_schdivid() { return (string) $this->schdivid; }
	// public function get_divguid() { return (string) $this->divguid; }
    // public function get_schoolguid() { return (string) $this->schoolguid; }
    // public function get_paps() { return (string) $this->paps; }
	// public function get_totalamount() { return (string) $this->totalamount; }
	// public function get_transferdate() { return (string) $this->divguid; }
	// public function get_fundyear() { return (string) $this->fundyear; }
    // public function get_mooerequest() { return (string) $this->mooerequest; }
    // public function get_guserid() { return (string) $this->guserid; }
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
function createSelFlds(){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    // print_r($arr);
    foreach ($arr as $key => $value) {
        if ($fistitem>1){
            $fld_list=$fld_list.",";
        }
        $fld_list=$fld_list.$key;
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
    // $stmt->bindParam(":fundguid", $this->fundguid); 
    
    // $stmt->bindParam(":schoolguid", $this->schoolguid); 
    // $stmt->bindParam(":paps", $this->paps);
    // $stmt->bindParam(":totalamount", $this->totalamount); 
    // $stmt->bindParam(":guserid", $this->guserid);
    // $stmt->bindParam(":transferdate", $this->transferdate); 
    // $stmt->bindParam(":fundyear", $this->fundyear); 
    // // $stmt->bindParam(":rectimestamp", $this->rectimestamp); 
    // $stmt->bindParam(":mooerequest", $this->mooerequest); 

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
                fundguid = :fundguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":fundguid", $this->fundguid);

 
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
   
    $query = "SELECT
                " . $this->createSelFlds() . "
            FROM
                " . $this->table_name . " 
                
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
            
            
            
            $query = "SELECT
                        " . implode (', ',  $this->FIELD_NAME ) . "
                    FROM
                        " . $this->table_name .  " 
                        
                    ORDER BY schdivid  DESC
                    LIMIT ?, ?";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind variable values
            $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        
            // execute query
            $stmt->execute();
        
            // return values from database
            return $stmt;
    }
    //read by division
    public function readfundconfirmByDiv(){
 
        // select query
        
        
        
        $query = "SELECT
                    " . implode (', ',  $this->FIELD_NAME ) . "
                FROM
                    " . $this->table_name .  " 
                where schdivid=:schdivid
                ORDER BY totalamount  asc
                ";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(":schdivid", $this->schdivid);
        
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }
    //read all 
    public function readAll(){
 
        // select query
           
        
        
        $query = "SELECT
                    " . implode (', ',  $this->FIELD_NAME ) . "
                FROM
                    " . $this->table_name .  " 
                    
                ORDER BY schdivid  DESC
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind variable values
     
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
    $this->fundguid= $row['fundguid'];
    $this->schoolguid= $row['schoolguid'];
    $this->schdivid= $row['schdivid'];
    $this->divguid= $row['divguid'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
