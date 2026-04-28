<?php

/**
 * papcodes.class.php
 * 
 **/
include_once '../objects/baseclass.php';
class papcodes extends baseclass {

	//Create Connection property
	protected $conn;
	//declare table name
    protected $table_name = "papcodes";
	//auto generated
    public $lasterror=null;
	protected  $PRIMARY_KEY = array('papguid'=>'papguid');
	protected $FIELD_NAME = array('papguid'=>'papguid','papscode'=>'papscode','papsdescription'=>'papsdescription','gaafield'=>'gaafield',
                                'regmooe'=>'regmooe', 'es'=>'es', 'jhs'=>'jhs', 'shs'=>'shs', 'fundassignment'=>'fundassignment' ,'rectimestamp'=>'rectimestamp');
	// protected $FIELD_MODIFIED = array();
	// protected $RESULT = array();
    // protected static $FOREIGN_KEYS = array();
    
    // protected $papguid = null;
	// protected $papscode = null;
	// protected $papsdescription = null;
    // protected $rectimestamp = null;

    


	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	// public function set_papguid($pArg='0') {
	// 	IF ( $this->papguid !== $pArg){
	// 		$this->papguid=$pArg; $this->FIELD_MODIFIED['papguid']=1;
	// 	}
	// }
	// public function set_papscode($pArg='0') {
	// 	IF ( $this->papscode !== $pArg){
	// 		$this->papscode=$pArg; $this->FIELD_MODIFIED['papscode']=1;
	// 	}
	// }
	// public function set_papsdescription($pArg='0') {
	// 	IF ( $this->papsdescription !== $pArg){
	// 		$this->papsdescription=$pArg; $this->FIELD_MODIFIED['papsdescription']=1;
	// 	}
	// }
    
    

    
	// public function get_papguid() { return (string) $this->papguid; }
	// public function get_papscode() { return (string) $this->papscode; }
	// public function get_papsdescription() { return (string) $this->papsdescription; }
	// public function get_rectimestamp() { return (string) $this->rectimestamp; }
    


 
    
    
    

// //create
// function create(){
 
//     // query to insert record
//     $query = "INSERT INTO
//                 " . $this->table_name . "
//             SET
//                 papscode=:papscode,
//                 papsdescription=:papsdescription,  
//                 divcode=:divcode
//                ";
 
//     // prepare query
//    //echo $query;
//     $stmt = $this->conn->prepare($query);
 
//     // sanitize
//     $this->papscode=htmlspecialchars(strip_tags($this->papscode));
//     $this->papsdescription=htmlspecialchars(strip_tags($this->papsdescription));
// 	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
 
//     // bind values
   
//     $stmt->bindParam(":papscode", $this->papscode); 
//     $stmt->bindParam(":papsdescription", $this->papsdescription); 
   
    

//     // execute query
//     if($stmt->execute()){
//         return true;
//     }
//     $this->lasterror=implode(" ",$stmt->errorInfo());
//     return false;
     
// }

// //update 
// function update(){
 
//     // update query
//     $query = "UPDATE
//                 " . $this->table_name . "
//             SET
//                 papscode=:papscode,
//                 papsdescription=:papsdescription
//             WHERE
//                 papguid = :papguid";
 
//     // prepare query statement
//     $stmt = $this->conn->prepare($query);
//     // echo $this->ghouserules;
 
//     // sanitize
//         //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
// 	$this->papscode=htmlspecialchars(strip_tags($this->papscode));
// 	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
	
 
//     // bind values
   
//     $stmt->bindParam(":papscode", $this->papscode); 
//     $stmt->bindParam(":papsdescription", $this->papsdescription); 
    
 
//     // execute query
//     if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
//         return true;
//     }
//     //print_r($stmt->errorInfo());
//     $this->lasterror=implode(" ",$stmt->errorInfo());
//     return false;
     
//    }

// //delete 
// function delete(){
 
//     // update query
//     $query = "delete from 
//                 " . $this->table_name . "
           
//             WHERE
//                 papguid = :papguid";
 
//     // prepare query statement
//     $stmt = $this->conn->prepare($query);
 
//     // sanitize
//         //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
//     // bind values
   
//     $stmt->bindParam(":papguid", $this->papguid);

 
//     // execute query
//     if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
//         return true;
//     }
//     $this->lasterror=implode(" ",$stmt->errorInfo());
//     return false;
     
//    }
// //Read One 
// function readOne(){
 
//     // query to read single record
//     $query = "SELECT
//                 " . implode (', ',  $this->FIELD_NAME ) . "
//             FROM
//                 " . $this->table_name . " 
                
//             WHERE
//                 papguid = :papguid
//             LIMIT
//                 0,1";
 
//     // prepare query statement
    
//     $stmt = $this->conn->prepare( $query );
 
//     // bind id of product to be updated
   
//     $stmt->bindParam(":papguid", $this->papguid);
//     // execute query
//     $stmt->execute();
 
//     // get retrieved row
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
//     // set values to object properties
//     $this->papguid= $row['papguid'];
//     $this->papscode= $row['papscode'];
    
//     $this->papsdescription= $row['papsdescription'];
//     $this->rectimestamp= $row['rectimestamp'];
    

//    }

// read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
    // select query
   	
    $whereclause="";
    
        if ($this->get_property('es')=='Y') {
            $whereclause=" a.es = :es";
            $es="Y";
        }
        if ($this->get_property('jhs')=='Y') {
            if ($whereclause !="") { $whereclause=$whereclause." or " ;}
            $whereclause=$whereclause." a.jhs = :jhs";
            $jhs="Y";
        
        }
        if ($this->get_property('shs')=='Y') {
            if ($whereclause !="") { $whereclause=$whereclause." or " ;}
            $whereclause=$whereclause." a.shs = :shs";
            $shs="Y";
        }
    
    
    
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name .  " a
            where regmooe='Y' ";
    if ($whereclause!="") {
        $query=$query." and (".$whereclause.")
                      ORDER BY paporder asc";

    } else {
        $query=$query."   ORDER BY paporder asc";

    }
    // prepare query statement
    // echo $query;
    $stmt = $this->conn->prepare( $query );
    
    // bind variable values
    // $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    // $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    if ($whereclause!="") {
        $es=$this->get_property("es");
        $jhs=$this->get_property("jhs");
        $shs=$this->get_property("shs");

        // if ($orgtable=="schools") {
        if ($this->get_property('es')=='Y') {
            $stmt->bindParam(":es", $es);
        
        }
        if ($this->get_property('jhs')=='Y') {
            $stmt->bindParam(":jhs", $jhs);
        
        
        }
        if ($this->get_property('shs')=='Y') {
            $stmt->bindParam(":shs", $shs);
        }
        // }
        

        

    } 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}
public function readOthersPaging($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name .  "  
            where regmooe='N'
            ORDER BY paporder asc
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
    // public function readSigninRoles(){
 
    //     // select query
           
        
        
    //     $query = "SELECT
    //                 " . implode (', ',  $this->FIELD_NAME ) . "
    //             FROM
    //                 " . $this->table_name .  " 
                    
    //             where papsdescription <> 'H' and papsdescription <> 'X'
    //             order by papscode asc
    //             ";
     
    //     // prepare query statement
    //     $stmt = $this->conn->prepare( $query );
     
    //     // bind variable values
     
    //     // execute query
    //     $stmt->execute();
     
    //     // return values from database
    //     return $stmt;
    // }


// used for paging user
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " where regmooe='Y'";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function otherscount(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " where regmooe='N'";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}


           

}
