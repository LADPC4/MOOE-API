<?php

/**
 * gamegroups.class.php
 * 
 **/
class ct_workflow {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "ct_workflow";
	//auto generated
    //wfguid, type, status, rectimestamp
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('wfguid'=>'wfguid','type'=>'type','status'=>'status','wforder'=>'wforder','wfprint'=>'wfprint','wfedit'=>'wfedit','rectimestamp'=>'rectimestamp','description'=>'description','completed'=>'completed');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();


	protected $wfguid = null;
    protected $type = null;
    protected $wforder = null;
	protected $status = null;
    protected $rectimestamp = null;
    protected $description = null;
    protected $completed = null;
    
	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_wfguid($pArg='0') {
		IF ( $this->wfguid !== $pArg){
			$this->wfguid=$pArg; $this->FIELD_MODIFIED['wfguid']=1;
		}
	}
	public function set_type($pArg='0') {
		IF ( $this->type !== $pArg){
			$this->type=$pArg; $this->FIELD_MODIFIED['type']=1;
		}
    }
    public function set_wforder($pArg='0') {
		IF ( $this->wforder !== $pArg){
			$this->wforder=$pArg; $this->FIELD_MODIFIED['wforder']=1;
		}
	}
	public function set_status($pArg='0') {
		IF ( $this->status !== $pArg){
			$this->status=$pArg; $this->FIELD_MODIFIED['status']=1;
		}
    }
    public function set_description($pArg='0') {
		IF ( $this->description !== $pArg){
			$this->description=$pArg; $this->FIELD_MODIFIED['description']=1;
		}
    }
    public function set_completed($pArg='0') {
		IF ( $this->completed !== $pArg){
			$this->completed=$pArg; $this->FIELD_MODIFIED['completed']=1;
		}
	}
    
    
	public function get_wfguid() { return (string) $this->wfguid; }
	public function get_type() { return (string) $this->type; }
    public function get_status() { return (string) $this->status; }
    public function get_wforder() { return (string) $this->wforder; }
    public function get_rectimestamp() { return (string) $this->rectimestamp; }
    public function get_description() { return (string) $this->description; }
    public function get_completed() { return (string) $this->description; }
	

//create

function sanitize(){
   $this->wfguid=htmlspecialchars(strip_tags($this->wfguid));
   $this->type=htmlspecialchars(strip_tags($this->type));
   $this->wforder=htmlspecialchars(strip_tags($this->wforder));
   $this->status=htmlspecialchars(strip_tags($this->status));
  
   
}
//Bind
function bind(&$stmt){
 
    $stmt->bindParam(":wfguid", $this->wfguid); 
    $stmt->bindParam(":type", $this->type); 
    $stmt->bindParam(":wforder", $this->wforder); 
    $stmt->bindParam(":status", $this->status); 
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":completed", $this->completed); 
    
    


}

function create(){
 
    // query to insert record
    $query = "INSERT INTO " . $this->table_name . "
        SET wfguid=:wfguid,type=:type,
            status=:status,
            wforder=:wforder,description=:description,completed=:completed
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
   //GetBeginning Workflow
   public function getWFStart(){
        $query = "select  `status` ,description,wforder
        from ct_workflow 
        where `type`=:type order by wforder asc 
        limit 0,1";
        // echo $query;
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":type", $this->type); 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['status'];
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
                    ct_workflow c on b.wfguid=c.wfguid
                
                where a.gsysuserid=?
            ORDER BY gorder  asc
            ";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $this->description);
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
