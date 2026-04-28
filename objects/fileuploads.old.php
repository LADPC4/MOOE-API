<?php

/**
 * gamegroups.class.php
 * 
 **/
class fileuploads {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "fileuploads";
	//auto generated
    //fileguid, filename, contenttype, rectimestamp
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('fileguid'=>'fileguid','filename'=>'filename','contenttype'=>'contenttype','filesize'=>'filesize','rectimestamp'=>'rectimestamp','userguid'=>'userguid','recowner'=>'recowner');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();


	protected $fileguid = null;
    protected $filename = null;
    protected $filesize = null;
	protected $contenttype = null;
    protected $rectimestamp = null;
    protected $userguid = null;
    protected $recowner = null;
    
	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_fileguid($pArg='0') {
		IF ( $this->fileguid !== $pArg){
			$this->fileguid=$pArg; $this->FIELD_MODIFIED['fileguid']=1;
		}
	}
	public function set_filename($pArg='0') {
		IF ( $this->filename !== $pArg){
			$this->filename=$pArg; $this->FIELD_MODIFIED['filename']=1;
		}
    }
    public function set_filesize($pArg='0') {
		IF ( $this->filesize !== $pArg){
			$this->filesize=$pArg; $this->FIELD_MODIFIED['filesize']=1;
		}
	}
	public function set_contenttype($pArg='0') {
		IF ( $this->contenttype !== $pArg){
			$this->contenttype=$pArg; $this->FIELD_MODIFIED['contenttype']=1;
		}
    }
    public function set_userguid($pArg='0') {
		IF ( $this->userguid !== $pArg){
			$this->userguid=$pArg; $this->FIELD_MODIFIED['userguid']=1;
		}
    }
    public function set_recowner($pArg='0') {
		IF ( $this->recowner !== $pArg){
			$this->recowner=$pArg; $this->FIELD_MODIFIED['recowner']=1;
		}
	}
    
    
	public function get_fileguid() { return (string) $this->fileguid; }
	public function get_filename() { return (string) $this->filename; }
    public function get_contenttype() { return (string) $this->contenttype; }
    public function get_filesize() { return (string) $this->filesize; }
    public function get_rectimestamp() { return (string) $this->rectimestamp; }
    public function get_userguid() { return (string) $this->userguid; }
    public function get_recowner() { return (string) $this->userguid; }
	

//create

function sanitize(){
   $this->fileguid=htmlspecialchars(strip_tags($this->fileguid));
   $this->filename=htmlspecialchars(strip_tags($this->filename));
   $this->filesize=htmlspecialchars(strip_tags($this->filesize));
   $this->contenttype=htmlspecialchars(strip_tags($this->contenttype));
  
   
}
//Bind
function bind(&$stmt){
 
    $stmt->bindParam(":fileguid", $this->fileguid); 
    $stmt->bindParam(":filename", $this->filename); 
    $stmt->bindParam(":filesize", $this->filesize); 
    $stmt->bindParam(":contenttype", $this->contenttype); 
    $stmt->bindParam(":userguid", $this->userguid);
    $stmt->bindParam(":recowner", $this->recowner); 
    
    


}

function create(){
 
    // query to insert record
    $query = "INSERT INTO " . $this->table_name . "
        SET fileguid=:fileguid,filename=:filename,
            contenttype=:contenttype,
            filesize=:filesize,userguid=:userguid,recowner=:recowner
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

   public function readPaging($from_record_num, $records_per_page){
 
    // select query
    
    
    $tblprfx="a" ; 
    $query = "SELECT " 
               .$this->createSelFlds($tblprfx) . "
               
        FROM
            "  .$this->table_name . " " . $tblprfx ." 
            
        WHERE ".$this->createWhereQry($tblprfx)."
";

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
