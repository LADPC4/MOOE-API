<?php

/**
 * fileuploads.class.php
 * 
 **/
include_once '../objects/baseclass.php';
class schacctejs extends baseclass {

	//Create Connection property
	protected $conn;
	//declare table name
    protected $table_name = "schacctejs";
	//auto generated ejsguid, , , , , , , , ,
    public $lasterror=null;
    private $rpquery="";
	protected  $PRIMARY_KEY = array('ejsguid'=>'ejsguid');
	protected $FIELD_NAME = array('ejsguid'=>'ejsguid','schdivguid'=>'schdivguid','schaccount'=>'schaccount',
                                  'schbank'=>'schbank','maintbal'=>'maintbal',
                                  'guserguid'=>'guserguid','es'=>'es','jhs'=>'jhs','shs'=>'shs','gtimestamp'=>'gtimestamp');

    
    


	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        
    }

	public function checkoverlap(){

        $tblprfx="a" ; 
        $whereclause="";
        
        if ($this->get_property('es')=='Y') {
            $whereclause=" es = :es";
            $es="Y";
        }
        if ($this->get_property('jhs')=='Y') {
            if ($whereclause !="") { $whereclause=$whereclause." or " ;}
            $whereclause=$whereclause." jhs = :jhs";
            $jhs="Y";
        
        }
        if ($this->get_property('shs')=='Y') {
            if ($whereclause !="") { $whereclause=$whereclause." or " ;}
            $whereclause=$whereclause." shs = :shs";
            $shs="Y";
        }
        if ($this->get_property('ejsguid')=='%%') {
            $ejsguidclause=" ejsguid  like :ejsguid "; 
        } else {
            $ejsguidclause=" ejsguid  <> :ejsguid "; 
        }
        if ($whereclause=="") return false; 
       
        $query = "SELECT ejsguid
            FROM
                "  .$this->table_name . " " . $tblprfx ."
                
            where ".$ejsguidclause."  and schdivguid = :schdivguid and (".$whereclause.")";
        // echo $query;
        // prepare query statement
        // return ;
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        $ejsguid=$this->get_property('ejsguid');
        $schdivguid=$this->get_property('schdivguid');
        $stmt->bindParam(":ejsguid", $ejsguid); 
        $stmt->bindParam(":schdivguid", $schdivguid); 
        if ($this->get_property('es')=='Y') {
            $stmt->bindParam(":es", $es); 
        }
        if ($this->get_property('jhs')=='Y') {
            $stmt->bindParam(":jhs", $jhs); 
        }
        if ($this->get_property('shs')=='Y') {
            $stmt->bindParam(":shs", $shs); 
        }
        
        // $this->bind($stmt);
        // bind variable values
        // $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
        // $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num>0){ 
            return true;
        }
        // return values from database
        return false;
    }
    public function readPaging($orgtable,$orgidfld){
 
        // select query
        
        
        $tblprfx="a" ; 
        $whereparams=$this->createWhereQry();
        $whereclause="";
        if ($orgtable=="schools") {
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
        }
        
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . " 
            FROM
                "  .$this->table_name . " " . $tblprfx ." inner join 
                ".$orgtable." b on a.schdivguid=b.".$orgidfld."
                
            where (a.schdivguid=:schdivguid)
                  
           
        " ;
        if ($whereclause!="") {
            $query=$query." and (".$whereclause.")";

        }
        //  echo $query;
        // prepare query statement
        // return ;
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        // $this->bind($stmt);
        $schdivguid=$this->get_property("schdivguid");
        $stmt->bindParam(":schdivguid", $schdivguid);
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
        // bind variable values
        // $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
        // $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }
	
    public function count(){
        $whereparams=$this->createWhereQry();
            $whereclause="";
            if ($whereparams!=""){
                $whereclause="WHERE ".$whereparams;
            } 
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " ".$whereclause;
     
        $stmt = $this->conn->prepare( $query );
        $this->bind($stmt);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $row['total_rows'];
    }



           

}
