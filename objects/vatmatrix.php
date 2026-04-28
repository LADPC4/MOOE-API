<?php

/**
 * vatmatrix.class.php
 * 
 **/
class vatmatrix {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "ct_vatmatrix";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('vmguid'=>'vmguid');
	private $FIELD_NAME = array('vmguid'=>'vmguid',  'trantype'=>'trantype', 'vattype'=>'vattype', 'bir2306'=>'bir2306', 'bir2307'=>'bir2307', 'vatvalue'=>'vatvalue',  'taxoverride'=>'taxoverride',    'rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    

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
    $tblprfx=$tblprfx.".";
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
function createWhereQry(){
    $arr=$this->FIELD_NAME;
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
    if ($fld_list=="") $fld_list=" 1 ";
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
                vmguid = :vmguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":vmguid", $this->vmguid);

 
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
   public function readMatrix($from_record_num, $records_per_page){
 
            // select query
            
            
            $tblprfx="a" ; 
            $query = "SELECT " 
                       .$this->createSelFlds($tblprfx) . "
                FROM
                    "  .$this->table_name . " " . $tblprfx ."

                order by trantype asc , vattype asc";
            //  echo $query;
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
            // bind query parameters
            $this->bind($stmt);
            // bind variable values
            // $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
            // $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
        
            // execute query
            $stmt->execute();
        
            // return values from database
            return $stmt;
    }
    public function GetVATTypes(){
 
        // select query
        
        
       
        $query = "select distinct vattype from  " . $this->table_name ."  group by vattype" ;
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        // $this->bind($stmt);
        // bind variable values
        
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }  
    public function Vatcount(){
        $query = "SELECT distinct vattype, COUNT(*) as total_rows FROM " . $this->table_name . "  group by vattype ";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $row['total_rows'];
    }
    public function GetTranTypes(){
 
        // select query
        
        
       
        $query = "select distinct trantype,taxoverride from  " . $this->table_name ."  group by trantype, taxoverride" ;
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        // $this->bind($stmt);
        // bind variable values
        
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }  
    public function TranTypecount(){
        $query = "SELECT distinct trantype, COUNT(*) as total_rows FROM " . $this->table_name . "  group by trantype ";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $row['total_rows'];
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
        "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.bir2306=b.papguid 
    
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
    $this->vmguid= $row['vmguid'];
    $this->schoolguid= $row['schoolguid'];
    $this->trantype= $row['trantype'];
    $this->divguid= $row['divguid'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
