<?php

/**
 * fileuploads.class.php
 * 
 **/
include_once '../objects/baseclass.php';
class atc extends baseclass {

	//Create Connection property
	protected $conn;
	//declare table name
    protected $table_name = "ct_atc";
	//auto generated atc, , , , , , , , ,
    public $lasterror=null;
    private $rpquery="";
	protected  $PRIMARY_KEY = array('atc'=>'atc');
	protected $FIELD_NAME = array('atc'=>'atc','description'=>'description','rectimestamp'=>'rectimestamp');

    
    


	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        
    }


           

}
