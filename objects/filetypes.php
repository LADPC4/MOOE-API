<?php

/**
 * fileuploads.class.php
 * 
 **/
include_once '../objects/baseclass.php';
class filetypes extends baseclass {

	//Create Connection property
	protected $conn;
	//declare table name
    protected $table_name = "filetypes";
	//auto generated , , 
    public $lasterror=null;
	protected  $PRIMARY_KEY = array('filetypeguid'=>'filetypeguid');
	protected $FIELD_NAME = array('filetypeguid'=>'filetypeguid','filetypedesc'=>'filetypedesc','classname'=>'classname','idcols'=>'idcols','rectimestamp'=>'rectimestamp','deleterecords'=>'deleterecords');

    
    


	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        
    }

   
	public function readPaging($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        $whereparams=$this->createWhereQry();
        $whereclause="";
        if ($whereparams!=""){
            $whereclause="WHERE ".$whereparams;
        } 
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . "
            FROM
                "  .$this->table_name . " " . $tblprfx ."
                
            ".$whereclause."
            order by filetypedesc asc LIMIT :L1,:L2 
        ";
        //echo $query;
        // prepare query statement
        // return ;
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        $this->bind($stmt);
        // bind variable values
        $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }

   



           

}
