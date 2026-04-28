<?php

/**
 * gamegroups.class.php
 * 
 **/
class sysmenus {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "sysmenus";
	//auto generated
    //gsysmenuid, gmenuname, gmenuroute, gtimestamp
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('gsysmenuid'=>'gsysmenuid','gmenuname'=>'gmenuname','gmenuroute'=>'gmenuroute','gfunction'=>'gfunction','gtimestamp'=>'gtimestamp','gadmin'=>'gadmin');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();


	protected $gsysmenuid = null;
	protected $gmenuname = null;
	protected $gmenuroute = null;
    protected $gtimestamp = null;
    protected $guserid = null;
	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_gsysmenuid($pArg='0') {
		IF ( $this->gsysmenuid !== $pArg){
			$this->gsysmenuid=$pArg; $this->FIELD_MODIFIED['gsysmenuid']=1;
		}
	}
	public function set_gmenuname($pArg='0') {
		IF ( $this->gmenuname !== $pArg){
			$this->gmenuname=$pArg; $this->FIELD_MODIFIED['gmenuname']=1;
		}
	}
	public function set_gmenuroute($pArg='0') {
		IF ( $this->gmenuroute !== $pArg){
			$this->gmenuroute=$pArg; $this->FIELD_MODIFIED['gmenuroute']=1;
		}
    }
    public function set_guserid($pArg='0') {
		IF ( $this->guserid !== $pArg){
			$this->guserid=$pArg; $this->FIELD_MODIFIED['guserid']=1;
		}
	}
    
    
	public function get_gsysmenuid() { return (string) $this->gsysmenuid; }
	public function get_gmenuname() { return (string) $this->gmenuname; }
	public function get_gmenuroute() { return (string) $this->gmenuroute; }
    public function get_gtimestamp() { return (string) $this->gtimestamp; }
    public function get_guserid() { return (string) $this->guserid; }
	

//create
function create(){
 
   
    return true;
     
   }

//update 
function update(){
 
   
    return true;
     
   }

//delete 
function delete(){
 
    
    return true;
     
   }
//Read One 
function readOne(){
 
    return true;
   }

// read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "select c.* 
                from sysdivusers a inner join
                    sysrolemenus  b on a.gsysrole =b.gsysrole join 
                    sysmenus c on b.gsysmenuid=c.gsysmenuid
                
                where a.gsysuserid=?
            ORDER BY gorder  asc
            ";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $this->guserid);
    // $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
    // $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}
public function readAll($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "select * 
                from sysmenus 
                
               
           
            ";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    // $stmt->bindParam(1, $this->guserid);
    // $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
    // $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
 
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
                groupcode= :groupcode
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":groupcode", $this->groupcode);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->groupid= $row['groupid'];
    $this->groupcode= $row['groupcode'];
    $this->groupname= $row['groupname'];
    $this->groupowner= $row['groupowner'];
    $this->gtimestamp= $row['gtimestamp'];
   }

}
