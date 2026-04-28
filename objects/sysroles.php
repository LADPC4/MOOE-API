<?php

/**
 * sysroles.class.php
 * 
 **/
class sysroles {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "sysroles";
	//auto generated
    public $lasterror=null;
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('roleguid'=>'roleguid','roledescription'=>'roledescription','roletype'=>'roletype','rolegroup'=>'rolegroup','rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
    protected static $FOREIGN_KEYS = array();
    
    protected $roleguid = null;
	protected $roledescription = null;
	protected $roletype = null;
    protected $rolegroup = null;
    protected $rectimestamp = null;

    


	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_roleguid($pArg='0') {
		IF ( $this->roleguid !== $pArg){
			$this->roleguid=$pArg; $this->FIELD_MODIFIED['roleguid']=1;
		}
	}
	public function set_roledescription($pArg='0') {
		IF ( $this->roledescription !== $pArg){
			$this->roledescription=$pArg; $this->FIELD_MODIFIED['roledescription']=1;
		}
	}
	public function set_roletype($pArg='0') {
		IF ( $this->roletype !== $pArg){
			$this->roletype=$pArg; $this->FIELD_MODIFIED['roletype']=1;
		}
	}
    
    

    
	public function get_roleguid() { return (string) $this->roleguid; }
	public function get_roledescription() { return (string) $this->roledescription; }
	public function get_roletype() { return (string) $this->roletype; }
    public function get_rolegroup() { return (string) $this->rolegroup; }
	public function get_rectimestamp() { return (string) $this->rectimestamp; }
    


 
    
    
    

//create
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                roledescription=:roledescription,
                roletype=:roletype,  
                divcode=:divcode
               ";
 
    // prepare query
   //echo $query;
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->roledescription=htmlspecialchars(strip_tags($this->roledescription));
    $this->roletype=htmlspecialchars(strip_tags($this->roletype));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
 
    // bind values
   
    $stmt->bindParam(":roledescription", $this->roledescription); 
    $stmt->bindParam(":roletype", $this->roletype); 
   
    

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
                roledescription=:roledescription,
                roletype=:roletype
            WHERE
                roleguid = :roleguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // echo $this->ghouserules;
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	$this->roledescription=htmlspecialchars(strip_tags($this->roledescription));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
	
 
    // bind values
   
    $stmt->bindParam(":roledescription", $this->roledescription); 
    $stmt->bindParam(":roletype", $this->roletype); 
    
 
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
                roleguid = :roleguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":roleguid", $this->roleguid);

 
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
                roleguid = :roleguid
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":roleguid", $this->roleguid);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->roleguid= $row['roleguid'];
    $this->roledescription= $row['roledescription'];
    
    $this->roletype= $row['roletype'];
    $this->rolegroup= $row['rolegroup'];
    $this->rectimestamp= $row['rectimestamp'];
    

   }

// read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name .  " 
            where    roletype <> 'X'
            ORDER BY roledescription  DESC
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
    public function readSigninRoles(){
 
        // select query
           
        
        
        $query = "SELECT
                    " . implode (', ',  $this->FIELD_NAME ) . "
                FROM
                    " . $this->table_name .  " 
                    
                where roletype <> 'H' and roletype <> 'X'
                order by roledescription asc
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind variable values
     
        // execute query
        $stmt->execute();
     
        // return values from database
        return $stmt;
    }
    public function readRoles(){
 
        // select query
           
        
        
        $query = "SELECT
                   a.roleguid, a.roledescription, a.roletype
                FROM
                    " . $this->table_name .  " a inner join 
                    sysrolehierarchy b on a.roleguid=b.childroleguid
             
              
                    
                where roletype <> 'X' and b.roleguid=:roleguid
                order by roledescription asc
                ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":roleguid", $this->roleguid);
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



           

}
