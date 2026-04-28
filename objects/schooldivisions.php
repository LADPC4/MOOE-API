<?php

/**
 * schooldivisions.class.php
 * 
 **/
class schooldivisions {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "schooldivisions";
	//auto generated
    public $lasterror=null;
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('schdivid'=>'schdivid','divdescription'=>'divdescription','schregid'=>'schregid','divcode'=>'divcode','rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();


	protected $schdivid = null;
	protected $divdescription = null;
	protected $schregid = null;
    protected $rectimestamp = null;
    protected $divcode = null;

    


	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_schdivid($pArg='0') {
		IF ( $this->schdivid !== $pArg){
			$this->schdivid=$pArg; $this->FIELD_MODIFIED['schdivid']=1;
		}
	}
	public function set_divdescription($pArg='0') {
		IF ( $this->divdescription !== $pArg){
			$this->divdescription=$pArg; $this->FIELD_MODIFIED['divdescription']=1;
		}
	}
	public function set_schregid($pArg='0') {
		IF ( $this->schregid !== $pArg){
			$this->schregid=$pArg; $this->FIELD_MODIFIED['schregid']=1;
		}
	}
    public function set_divcode($pArg='0') {
		IF ( $this->divcode !== $pArg){
			$this->divcode=$pArg; $this->FIELD_MODIFIED['divcode']=1;
		}
    }
    

    
	public function get_schdivid() { return (string) $this->schdivid; }
	public function get_divdescription() { return (string) $this->divdescription; }
	public function get_schregid() { return (string) $this->schregid; }
	public function get_rectimestamp() { return (string) $this->rectimestamp; }
    public function get_divcode() { return (string) $this->divcode; }
    


 
    
    
    

//create
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                divdescription=:divdescription,
                schregid=:schregid,  
                divcode=:divcode
               ";
 
    // prepare query
   //echo $query;
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->divdescription=htmlspecialchars(strip_tags($this->divdescription));
    $this->schregid=htmlspecialchars(strip_tags($this->schregid));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
 
    // bind values
   
    $stmt->bindParam(":divdescription", $this->divdescription); 
    $stmt->bindParam(":schregid", $this->schregid); 
    $stmt->bindParam(":divcode", $this->divcode);
    

    // execute query
    if($stmt->execute()){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
}

//update 
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                divdescription=:divdescription,
                schregid=:schregid,  
                divcode=:divcode
            WHERE
                schdivid = :schdivid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // echo $this->ghouserules;
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	$this->divdescription=htmlspecialchars(strip_tags($this->divdescription));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
	
 
    // bind values
   
    $stmt->bindParam(":divdescription", $this->divdescription); 
    $stmt->bindParam(":schregid", $this->schregid); 
    $stmt->bindParam(":divcode", $this->divcode);
    
 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
        return true;
    }
    //print_r($stmt->errorInfo());
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }

//delete 
function delete(){
 
    // update query
    $query = "delete from 
                " . $this->table_name . "
           
            WHERE
                schdivid = :schdivid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":schdivid", $this->schdivid);

 
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
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name . " 
                
            WHERE
                schdivid = :schdivid
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":schdivid", $this->schdivid);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->schdivid= $row['schdivid'];
    $this->divdescription= $row['divdescription'];
    
    $this->schregid= $row['schregid'];
    $this->divcode= $row['divcode'];
    $this->rectimestamp= $row['rectimestamp'];
    

   }

// read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name .  " 
                
            ORDER BY divdescription  DESC
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
    //read all 
    public function readAll(){
 
        // select query
           
        
        
        $query = "SELECT
                    " . implode (', a.',  $this->FIELD_NAME ) . "
                    , b.schregdescription

                FROM
                    " . $this->table_name .  " a 
                    inner join schoolregions b on a.schregid = b.schregid
                    
                ORDER BY divdescription  DESC
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind variable values
     
        // execute query
        $stmt->execute();
     
        // return values from database
        return $stmt;
    }
    public function readByReg(){
 
        // select query
           
        
        
        $query = "SELECT
                    " . implode (', a.',  $this->FIELD_NAME ) . "
                    , b.schregdescription

                FROM
                    " . $this->table_name .  " a 
                    inner join schoolregions b on a.schregid = b.schregid
                where a.schregid=:schregid
                ORDER BY divdescription  DESC
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind variable values
        $stmt->bindParam(":schregid", $this->schregid);
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
                divcode= :divcode
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":divcode", $this->divcode);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->schdivid= $row['schdivid'];
    $this->divcode= $row['divcode'];
    $this->divdescription= $row['divdescription'];
    $this->schregid= $row['schregid'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
