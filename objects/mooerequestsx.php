<?php

/**
 * gamegroups.class.php
 * 
 **/
class mooerequests {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "mooerequests";
	//auto generated
    //requestid, schoolid, periodcovered, rectimestamp
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('requestid'=>'requestid','schoolid'=>'schoolid','periodcovered'=>'periodcovered','totalamount'=>'totalamount','paps'=>'paps','rectimestamp'=>'rectimestamp','userguid'=>'userguid','reqstatus'=>'reqstatus');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();


	protected $requestid = null;
    protected $schoolid = null;
    protected $totalamount = null;
	protected $periodcovered = null;
    protected $rectimestamp = null;
    protected $userguid = null;
    protected $paps = null;
    protected $reqstatus = null;

    
	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_requestid($pArg='0') {
		IF ( $this->requestid !== $pArg){
			$this->requestid=$pArg; $this->FIELD_MODIFIED['requestid']=1;
		}
	}
	public function set_schoolid($pArg='0') {
		IF ( $this->schoolid !== $pArg){
			$this->schoolid=$pArg; $this->FIELD_MODIFIED['schoolid']=1;
		}
    }
    public function set_totalamount($pArg='0') {
		IF ( $this->totalamount !== $pArg){
			$this->totalamount=$pArg; $this->FIELD_MODIFIED['totalamount']=1;
		}
    }
    public function set_paps($pArg='0') {
		IF ( $this->paps !== $pArg){
			$this->paps=$pArg; $this->FIELD_MODIFIED['paps']=1;
		}
	}
	public function set_periodcovered($pArg='0') {
		IF ( $this->periodcovered !== $pArg){
			$this->periodcovered=$pArg; $this->FIELD_MODIFIED['periodcovered']=1;
		}
    }
    public function set_userguid($pArg='0') {
		IF ( $this->userguid !== $pArg){
			$this->userguid=$pArg; $this->FIELD_MODIFIED['userguid']=1;
		}
    }
    public function set_reqstatus($pArg='0') {
		IF ( $this->reqstatus !== $pArg){
			$this->reqstatus=$pArg; $this->FIELD_MODIFIED['reqstatus']=1;
		}
	}
    
    
	public function get_requestid() { return (string) $this->requestid; }
	public function get_schoolid() { return (string) $this->schoolid; }
    public function get_periodcovered() { return (string) $this->periodcovered; }
    public function get_totalamount() { return (string) $this->totalamount; }
    public function get_rectimestamp() { return (string) $this->rectimestamp; }
    public function get_userguid() { return (string) $this->userguid; }
    public function get_reqstatus() { return (string) $this->reqstatus; }
    public function get_paps() { return (string) $this->paps; }
    
	

//create

function sanitize(){
   $this->requestid=htmlspecialchars(strip_tags($this->requestid));
   $this->schoolid=htmlspecialchars(strip_tags($this->schoolid));
   $this->totalamount=htmlspecialchars(strip_tags($this->totalamount));
   $this->periodcovered=htmlspecialchars(strip_tags($this->periodcovered));
  
   
}
//Bind
function bind(&$stmt){
 
    $stmt->bindParam(":requestid", $this->requestid); 
    $stmt->bindParam(":schoolid", $this->schoolid); 
    $stmt->bindParam(":totalamount", $this->totalamount); 
    $stmt->bindParam(":paps", $this->paps);
    $stmt->bindParam(":periodcovered", $this->periodcovered); 
    $stmt->bindParam(":userguid", $this->userguid);
    $stmt->bindParam(":reqstatus", $this->reqstatus); 
    
    


}

function create(){
 
    // query to insert record
    $query = "INSERT INTO " . $this->table_name . "
        SET requestid=:requestid,schoolid=:schoolid,
            periodcovered=:periodcovered,
            totalamount=:totalamount,paps=:paps,userguid=:userguid,reqstatus=:reqstatus
    ";

    // prepare query
    $stmt = $this->conn->prepare($query);

    //echo json_encode($stmt);
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
                    mooerequests c on b.requestid=c.requestid
                
                where a.gsysuserid=?
            ORDER BY gorder  asc
            ";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $this->userguid);
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
    $this->rectimestamp= $row['rectimestamp'];
   }

}
