<?php

/**
 * transactions.class.php
 * 
 **/
class transactions {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "transactions";
	//auto generated
    public $lasterror=null;
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('tranid'=>'tranid','recowner'=>'recowner','recstatus'=>'recstatus','remarks'=>'remarks','rectimestamp'=>'rectimestamp','sysuser'=>'sysuser',);
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
    protected static $FOREIGN_KEYS = array();
    
    protected $tranid = null;
	protected $recowner = null;
	protected $recstatus = null;
	protected $remarks = null;
    protected $rectimestamp = null;
    protected $sysuser = null;
    

    


	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_tranid($pArg='0') {
		IF ( $this->tranid !== $pArg){
			$this->tranid=$pArg; $this->FIELD_MODIFIED['tranid']=1;
		}
	}
	public function set_recowner($pArg='0') {
		IF ( $this->recowner !== $pArg){
			$this->recowner=$pArg; $this->FIELD_MODIFIED['recowner']=1;
		}
	}
	public function set_recstatus($pArg='0') {
		IF ( $this->recstatus !== $pArg){
			$this->recstatus=$pArg; $this->FIELD_MODIFIED['recstatus']=1;
		}
    }
    public function set_remarks($pArg='0') {
		IF ( $this->remarks !== $pArg){
			$this->remarks=$pArg; $this->FIELD_MODIFIED['remarks']=1;
		}
	}
    public function set_sysuser($pArg='0') {
		IF ( $this->sysuser !== $pArg){
			$this->sysuser=$pArg; $this->FIELD_MODIFIED['sysuser']=1;
		}
    }
    

    
	public function get_tranid() { return (string) $this->tranid; }
	public function get_recowner() { return (string) $this->recowner; }
	public function get_recstatus() { return (string) $this->recstatus; }
	public function get_remarks() { return (string) $this->remarks; }
	public function get_rectimestamp() { return (string) $this->rectimestamp; }
    public function get_sysuser() { return (string) $this->sysuser; }
    
    


 
    
    
    

//create
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                recowner=:recowner,
                recstatus=:recstatus,
                remarks=:remarks,
                sysuser=:sysuser
               ";
 
    // prepare query
   //echo $query;
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->recowner=htmlspecialchars(strip_tags($this->recowner));
    $this->recstatus=htmlspecialchars(strip_tags($this->recstatus));
    $this->remarks=htmlspecialchars(strip_tags($this->remarks));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
 
    // bind values
   
    $stmt->bindParam(":recowner", $this->recowner); 
    $stmt->bindParam(":recstatus", $this->recstatus); 
    $stmt->bindParam(":remarks", $this->remarks); 
    $stmt->bindParam(":sysuser", $this->sysuser); 
   
    

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
                recowner=:recowner,
                recstatus=:recstatus,
                remarks=:remarks
            WHERE
                tranid = :tranid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // echo $this->ghouserules;
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
    $this->recowner=htmlspecialchars(strip_tags($this->recowner));
    $this->remarks=htmlspecialchars(strip_tags($this->remarks));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
	
 
    // bind values
   
    $stmt->bindParam(":recowner", $this->recowner); 
    $stmt->bindParam(":recstatus", $this->recstatus); 
    $stmt->bindParam(":remarks", $this->remarks); 
    
 
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
                tranid = :tranid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":tranid", $this->tranid);

 
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
                tranid = :tranid
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":tranid", $this->tranid);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->tranid= $row['tranid'];
    $this->recowner= $row['recowner'];
    
    $this->recstatus= $row['recstatus'];
    $this->rectimestamp= $row['rectimestamp'];
    

   }

// read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "select a.tranid, date(a.rectimestamp) transactiondate, c.name , a.remarks
            from transactions a inner join 
                 mooerequests b on a.recowner=b.requestid inner join 
                 ct_wfstatus c on a.recstatus=c.id
            where a.recowner=:recowner
            order by a.rectimestamp asc";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(":recowner", $this->recowner); 
    // $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}
public function readPagingD($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "select a.tranid, date(a.rectimestamp) transactiondate, c.name , a.remarks
            from transactions a inner join 
                 mooedisbursements b on a.recowner = b.mooedisid inner join 
                 ct_wfstatus c on a.recstatus=c.id
            where a.recowner=:recowner
            order by a.rectimestamp asc";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(":recowner", $this->recowner); 
    // $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
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
                    
                where recstatus <> 'H' and recstatus <> 'X'
                order by recowner asc
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
    $query = "SELECT COUNT(*) as total_rows 
    from transactions a inner join 
         mooerequests b on a.recowner=b.requestid inner join 
         ct_wfstatus c on a.recstatus=c.id
    where a.recowner=:recowner";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(":recowner", $this->recowner); 
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}
public function countD(){
    $query = "SELECT COUNT(*) as total_rows 
    from transactions a inner join 
    mooedisbursements b on a.recowner = b.mooedisid inner join 
         ct_wfstatus c on a.recstatus=c.id
    where a.recowner=:recowner";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(":recowner", $this->recowner); 
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}


           

}
