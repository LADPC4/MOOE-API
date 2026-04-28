<?php

/**
 * sysdivusers.class.php
 * 
 **/
class sysdivusers {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "sysdivusers";
	//auto generated
    public $lasterror=null;
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('ggmid'=>'ggmid','gdivision'=>'gdivision','gsysuserid'=>'gsysuserid','gsysrole'=>'gsysrole','rectimestamp'=>'rectimestamp', 'gstatus'=>'gstatus', 'gschool'=>'gschool');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //ggmid, gdivision, gsysuserid, gsysrole, gtimestamp, gstatus, gschool

	protected $ggmid = null;
	protected $gdivision = null;
	protected $gsysuserid = null;
    protected $rectimestamp = null;
    protected $gsysrole = null;
    protected $gstatus = null;
    protected $gschool = null;
    


	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_ggmid($pArg='0') {
		IF ( $this->ggmid !== $pArg){
			$this->ggmid=$pArg; $this->FIELD_MODIFIED['ggmid']=1;
		}
	}
	public function set_gdivision($pArg='0') {
		IF ( $this->gdivision !== $pArg){
			$this->gdivision=$pArg; $this->FIELD_MODIFIED['gdivision']=1;
		}
	}
	public function set_gsysuserid($pArg='0') {
		IF ( $this->gsysuserid !== $pArg){
			$this->gsysuserid=$pArg; $this->FIELD_MODIFIED['gsysuserid']=1;
		}
	}
    public function set_gsysrole($pArg='0') {
		IF ( $this->gsysrole !== $pArg){
			$this->gsysrole=$pArg; $this->FIELD_MODIFIED['gsysrole']=1;
		}
    }
    public function set_gstatus($pArg='0') {
		IF ( $this->gstatus !== $pArg){
			$this->gstatus=$pArg; $this->FIELD_MODIFIED['gstatus']=1;
		}
	}
    public function set_gschool($pArg='0') {
		IF ( $this->gschool !== $pArg){
			$this->gschool=$pArg; $this->FIELD_MODIFIED['gschool']=1;
		}
    }

    
	public function get_ggmid() { return (string) $this->ggmid; }
	public function get_gdivision() { return (string) $this->gdivision; }
	public function get_gsysuserid() { return (string) $this->gsysuserid; }
	public function get_rectimestamp() { return (string) $this->rectimestamp; }
    public function get_gsysrole() { return (string) $this->gsysrole; }
    public function get_gstatus() { return (string) $this->gstatus; }
    public function get_gschool() { return (string) $this->gschool; }
    


 
    
    
    

//create
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                gdivision=:gdivision,
                gsysuserid=:gsysuserid,  
                gsysrole=:gsysrole,
                gschool=:gschool
               ";
 
    // prepare query
   //echo $query;
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->gdivision=htmlspecialchars(strip_tags($this->gdivision));
    $this->gsysuserid=htmlspecialchars(strip_tags($this->gsysuserid));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
 
    // bind values
   
    $stmt->bindParam(":gdivision", $this->gdivision); 
    $stmt->bindParam(":gsysuserid", $this->gsysuserid); 
    $stmt->bindParam(":gsysrole", $this->gsysrole);
    $stmt->bindParam(":gschool", $this->gschool);
    

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
                gdivision=:gdivision,
                gsysuserid=:gsysuserid,  
                gsysrole=:gsysrole,
                gstatus=:gstatus,  
                gschool=:gschool
            WHERE
                ggmid = :ggmid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // echo $this->ghouserules;
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	$this->gdivision=htmlspecialchars(strip_tags($this->gdivision));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
	
 
    // bind values
   
    $stmt->bindParam(":gdivision", $this->gdivision); 
    $stmt->bindParam(":gsysuserid", $this->gsysuserid); 
    $stmt->bindParam(":gsysrole", $this->gsysrole);
    $stmt->bindParam(":gstatus", $this->gstatus);
    $stmt->bindParam(":gschool", $this->gschool);
    
 
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
                ggmid = :ggmid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":ggmid", $this->ggmid);

 
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
                ggmid = :ggmid
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":ggmid", $this->ggmid);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->ggmid= $row['ggmid'];
    $this->gdivision= $row['gdivision'];
    
    $this->gsysuserid= $row['gsysuserid'];
    $this->gsysrole= $row['gsysrole'];
    $this->rectimestamp= $row['rectimestamp'];
    

   }

// read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name .  " 
                
            ORDER BY gdivision  DESC
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
                    inner join schoolregions b on a.gsysuserid = b.gsysuserid
                    
                ORDER BY gdivision  DESC
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
                gsysrole= :gsysrole
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":gsysrole", $this->gsysrole);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->ggmid= $row['ggmid'];
    $this->gsysrole= $row['gsysrole'];
    $this->gdivision= $row['gdivision'];
    $this->gsysuserid= $row['gsysuserid'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
