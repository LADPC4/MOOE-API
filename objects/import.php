<?php

/**
 * fileuploads.class.php
 * 
 **/
include_once '../objects/baseclass.php';
class import extends baseclass {

	//Create Connection property
	protected $conn;
	// protected $tblname;
	//declare table name
    // protected $table_name = "ct_atc";
	//auto generated atc, , , , , , , , ,
    public $lasterror=null;
    private $rpquery="";
	protected  $PRIMARY_KEY = array();
	//REGION, DIVISIONCODE, DIVISION, DIVISIONBEIS, OUCODE, SCHOOLID, OPERATINGUNIT, TAG, REMARKS, ES, HS, SHS, TOTAL
	protected $FIELD_NAME = array('REGION'=>'REGION','DIVISIONCODE'=>'DIVISIONCODE','DIVISION'=>'DIVISION',
								  'DIVISIONBEIS'=>'DIVISIONBEIS','OUCODE'=>'OUCODE','SCHOOLID'=>'SCHOOLID',
								  'OPERATINGUNIT'=>'OPERATINGUNIT','TAG'=>'TAG','REMARKS'=>'REMARKS',
								  'ES'=>'ES','HS'=>'HS','SHS'=>'SHS','TOTAL'=>'TOTAL'
									);

    
    


	// constructor with $db as database connection
    public function __construct($db,$tblname){
        $this->conn = $db;
		$this->table_name = "import".$tblname;
        
    }

	function deletefiles(){
 
		// use primary key if defined 
		
		$filename=$this->get_property("FileName");
		
		$query = "DROP TABLE IF EXISTS  
					" . $this->table_name . "
			   
					;
					CREATE TABLE " . $this->table_name . " AS SELECT * FROM importtmpl;
";
		// echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
			//$this->guserid=htmlspecialchars(strip_tags($this->guserid));
		
		// bind values
		
		$stmt->bindParam(1, $filename);
		
	
	 
		// execute query
		if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
			return true;
		}
		$this->lasterror=implode(" ",$stmt->errorInfo());
		return false;
		 
	   }

           

}
