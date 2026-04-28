<?php

/**
 * schools.class.php
 * 
 **/
class schools {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "schools";
	//auto generated
    public $lasterror=null;
	public static $PRIMARY_KEY = array();
	private $FIELD_NAME = array('schguid'=>'schguid', 'schguid'=>'schguid', 'schdivbeis'=>'schdivbeis', 'schoucode'=>'schoucode', 'schoolid'=>'schoolid', 'schdescription'=>'schdescription', 'schtype'=>'schtype', 'schremarks'=>'schremarks', 'lastmile'=>'lastmile','schaddress'=>'schaddress', 'schpayee'=>'schpayee', 'schaccount'=>'schaccount', 'schbank'=>'schbank','signatory1'=>'signatory1','signatory2'=>'signatory2' ,'maintbal'=>'maintbal' ,'signatory3'=>'signatory3','acctofficer'=>'acctofficer', 'rectimestamp'=>'rectimestamp','ES'=>'ES','JHS'=>'JHS','SHS'=>'SHS');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //schguid, schdivid, schdivbeis, schoucode, schoolid, schdescription, schtype, schremarks, lastmile, schaddress, schpayee, schaccount, schbank, rectimestamp

	protected $schguid = null;
	protected $schdivid = null;
	protected $schdivbeis = null;
    protected $schoucode = null;
    protected $schoolid = null;
	protected $schdescription = null;
	protected $schtype = null;
    protected $schremarks = null;
    protected $lastmile = null;
    protected $rectimestamp = null;
    protected $ES = null;
    protected $JHS = null;
    protected $SHS = null;

    protected $schaddress = null;
	protected $schaccount = null;
	protected $schbank = null;
    protected $schpayee = null;

    protected $schregid = null;

    protected $signatory1=null;
    protected $signatory2=null;

    protected $signatory3=null;
    protected $maintbal=null;
    protected $acctofficer=null;
    

    


	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}

	public function set_schguid($pArg='0') {
		IF ( $this->schguid !== $pArg){
			$this->schguid=$pArg; $this->FIELD_MODIFIED['schguid']=1;
		}
	}
	public function set_schdivid($pArg='0') {
		IF ( $this->schdivid !== $pArg){
			$this->schdivid=$pArg; $this->FIELD_MODIFIED['schdivid']=1;
		}
	}
	public function set_schdivbeis($pArg='0') {
		IF ( $this->schdivbeis !== $pArg){
			$this->schdivbeis=$pArg; $this->FIELD_MODIFIED['schdivbeis']=1;
		}
	}
    public function set_schoucode($pArg='0') {
		IF ( $this->schoucode !== $pArg){
			$this->schoucode=$pArg; $this->FIELD_MODIFIED['schoucode']=1;
		}
    }
    public function set_schoolid($pArg='0') {
		IF ( $this->schoolid !== $pArg){
			$this->schoolid=$pArg; $this->FIELD_MODIFIED['schoolid']=1;
		}
	}
	public function set_schdescription($pArg='0') {
		IF ( $this->schdescription !== $pArg){
			$this->schdescription=$pArg; $this->FIELD_MODIFIED['schdescription']=1;
		}
	}
	public function set_schtype($pArg='0') {
		IF ( $this->schtype !== $pArg){
			$this->schtype=$pArg; $this->FIELD_MODIFIED['schtype']=1;
		}
	}
    public function set_schremarks($pArg='0') {
		IF ( $this->schremarks !== $pArg){
			$this->schremarks=$pArg; $this->FIELD_MODIFIED['schremarks']=1;
		}
    }
    public function set_lastmile($pArg='0') {
		IF ( $this->lastmile !== $pArg){
			$this->lastmile=$pArg; $this->FIELD_MODIFIED['lastmile']=1;
		}
    }
    
    public function set_schaddress($pArg='0') {
		IF ( $this->schaddress !== $pArg){
			$this->schaddress=$pArg; $this->FIELD_MODIFIED['schaddress']=1;
		}
    }
    public function set_schaccount($pArg='0') {
		IF ( $this->schaccount !== $pArg){
			$this->schaccount=$pArg; $this->FIELD_MODIFIED['schaccount']=1;
		}
    }
    public function set_schbank($pArg='0') {
		IF ( $this->schbank !== $pArg){
			$this->schbank=$pArg; $this->FIELD_MODIFIED['schbank']=1;
		}
    }
    public function set_schpayee($pArg='0') {
		IF ( $this->schpayee !== $pArg){
			$this->schpayee=$pArg; $this->FIELD_MODIFIED['schpayee']=1;
		}
    }
    public function set_signatory1($pArg='0') {
		IF ( $this->signatory1 !== $pArg){
			$this->signatory1=$pArg; $this->FIELD_MODIFIED['signatory1']=1;
		}
    } 
    public function set_signatory2($pArg='0') {
		IF ( $this->signatory2 !== $pArg){
			$this->signatory2=$pArg; $this->FIELD_MODIFIED['signatory2']=1;
		}
    } 

    public function set_signatory3($pArg='0') {
		IF ( $this->signatory3 !== $pArg){
			$this->signatory3=$pArg; $this->FIELD_MODIFIED['signatory3']=1;
		}
    } 
    public function set_maintbal($pArg='0') {
		IF ( $this->maintbal !== $pArg){
			$this->maintbal=$pArg; $this->FIELD_MODIFIED['maintbal']=1;
		}
    } 
    public function set_acctofficer($pArg='0') {
		IF ( $this->acctofficer !== $pArg){
			$this->acctofficer=$pArg; $this->FIELD_MODIFIED['acctofficer']=1;
		}
    } 
    
    public function set_schregid($pArg='0') {
		IF ( $this->schregid !== $pArg){
			$this->schregid=$pArg; $this->FIELD_MODIFIED['schregid']=1;
		}
    }
    public function set_ES($pArg='0') {
		IF ( $this->ES !== $pArg){
			$this->ES=$pArg; $this->FIELD_MODIFIED['ES']=1;
		}
    }
    public function set_JHS($pArg='0') {
		IF ( $this->JHS !== $pArg){
			$this->JHS=$pArg; $this->FIELD_MODIFIED['JHS']=1;
		}
    }
    public function set_SHS($pArg='0') {
		IF ( $this->SHS !== $pArg){
			$this->SHS=$pArg; $this->FIELD_MODIFIED['SHS']=1;
		}
    }

    

	public function get_schguid() { return (string) $this->schguid; }
	public function get_schdivid() { return (string) $this->schdivid; }
	public function get_schdivbeis() { return (string) $this->schdivbeis; }
    public function get_schoucode() { return (string) $this->schoucode; }
    public function get_schoolid() { return (string) $this->schoolid; }
	public function get_schdescription() { return (string) $this->schdescription; }
	public function get_schtype() { return (string) $this->schdivbeis; }
	public function get_schremarks() { return (string) $this->schremarks; }
    public function get_lastmile() { return (string) $this->lastmile; }
    public function get_rectimestamp() { return (string) $this->rectimestamp; }
 

    public function get_schaddress() { return (string) $this->schaddress; }
	public function get_schaccount() { return (string) $this->schaccount; }
	public function get_schbank() { return (string) $this->schbank; }
    public function get_schpayee() { return (string) $this->schpayee; }
    public function get_signatory1() { return (string) $this->signatory1; }
    public function get_signatory2() { return (string) $this->signatory2; }

    public function get_signatory3() { return (string) $this->signatory3; }
    public function get_acctofficer() { return (string) $this->acctofficer; }
    public function get_maintbal() { return (string) $this->maintbal; }
    public function get_ES() { return (string) $this->ES; }
    public function get_JHS() { return (string) $this->JHS; }
    public function get_SHS() { return (string) $this->SHS; }
    

    
    

//create
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                schdivid=:schdivid,
                schdivbeis=:schdivbeis,  
                schoucode=:schoucode
               ";
 
    // prepare query
   //echo $query;
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->schdivid=htmlspecialchars(strip_tags($this->schdivid));
    $this->schdivbeis=htmlspecialchars(strip_tags($this->schdivbeis));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
 
    // bind values
   
    $stmt->bindParam(":schdivid", $this->schdivid); 
    $stmt->bindParam(":schdivbeis", $this->schdivbeis); 
    $stmt->bindParam(":schoucode", $this->schoucode);
    

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
                schdivid=:schdivid,
                schdivbeis=:schdivbeis,  
                schoucode=:schoucode
            WHERE
                schguid = :schguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // echo $this->ghouserules;
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	$this->schdivid=htmlspecialchars(strip_tags($this->schdivid));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
	
 
    // bind values
   
    $stmt->bindParam(":schdivid", $this->schdivid); 
    $stmt->bindParam(":schdivbeis", $this->schdivbeis); 
    $stmt->bindParam(":schoucode", $this->schoucode);
    
 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
        return true;
    }
    //print_r($stmt->errorInfo());
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }

//delete
function updateprofile(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                schaddress=:schaddress,
              --  schaccount=:schaccount, 
              --  schbank=:schbank,
                schpayee=:schpayee,
                signatory1=:signatory1,
               -- signatory2=:signatory2,
                signatory3=:signatory3,
               -- maintbal=:maintbal,
                acctofficer=:acctofficer

            WHERE
                schguid = :schguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // echo $this->ghouserules;
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
    $this->schaddress=htmlspecialchars(strip_tags($this->schaddress));
    // $this->schaccount=htmlspecialchars(strip_tags($this->schaccount));
    // $this->schbank=htmlspecialchars(strip_tags($this->schbank));
    $this->schpayee=htmlspecialchars(strip_tags($this->schpayee));
    $this->signatory1=htmlspecialchars(strip_tags($this->signatory1));
    // $this->signatory2=htmlspecialchars(strip_tags($this->signatory2));
    $this->signatory3=htmlspecialchars(strip_tags($this->signatory3));
    // $this->maintbal=htmlspecialchars(strip_tags($this->maintbal));
    $this->acctofficer=htmlspecialchars(strip_tags($this->acctofficer));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
	
 
    // bind values

//     $schools->set_schguid($data->schguid);
// $schools->set_schaddress($data->schaddress);
// $schools->set_schaccount($data->schaccount);
// $schools->set_schbank($data->schbank);
// $schools->set_schpayee($data->schpayee);

   
    $stmt->bindParam(":schguid", $this->schguid); 
    $stmt->bindParam(":schaddress", $this->schaddress); 
    // $stmt->bindParam(":schaccount", $this->schaccount);
    // $stmt->bindParam(":schbank", $this->schbank); 
    $stmt->bindParam(":schpayee", $this->schpayee);
    $stmt->bindParam(":signatory1", $this->signatory1);
    // $stmt->bindParam(":signatory2", $this->signatory2);
    $stmt->bindParam(":signatory3", $this->signatory3);
    // $stmt->bindParam(":maintbal", $this->maintbal);
    $stmt->bindParam(":acctofficer", $this->acctofficer);
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
        return true;
    }
    //print_r($stmt->errorInfo());
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }

   function updateschool(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                schtype=:schtype,
                lastmile=:lastmile,
                ES=:ES,
                JHS=:JHS,
                SHS=:SHS
            WHERE
                schguid = :schguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // echo $this->ghouserules;
 
    // sanitize
    //     //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
    // $this->schaddress=htmlspecialchars(strip_tags($this->schaddress));
    // $this->schaccount=htmlspecialchars(strip_tags($this->schaccount));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
	
 
    // bind values

//     $schools->set_schguid($data->schguid);
// $schools->set_schaddress($data->schaddress);
// $schools->set_schaccount($data->schaccount);
// $schools->set_schbank($data->schbank);
// $schools->set_schpayee($data->schpayee);

   
    $stmt->bindParam(":schguid", $this->schguid); 
    $stmt->bindParam(":schtype", $this->schtype); 
    $stmt->bindParam(":lastmile", $this->lastmile);
    $stmt->bindParam(":ES", $this->ES);
    $stmt->bindParam(":JHS", $this->JHS);
    $stmt->bindParam(":SHS", $this->SHS);

    // $stmt->bindParam(":schbank", $this->schbank); 
    // $stmt->bindParam(":schpayee", $this->schpayee);
 
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
                schguid = :schguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":schguid", $this->schguid);

 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }
//Read One 
function readOne(){
    error_reporting(E_ERROR | E_PARSE);

    // query to read single record
    $query = "SELECT
                a." . implode (', a.',  $this->FIELD_NAME ) . "
                ,b.divdescription
            FROM
                " . $this->table_name . " a inner join 
                schooldivisions b on a.schdivid=b.schdivid
                
            WHERE
                a.schguid = :schguid
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":schguid", $this->schguid);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    if ($row["ES"]=="Y") {
        $row["ES"]=array("on");
    }
    if ($row["JHS"]=="Y") {
        $row["JHS"]=array("on");
    } 
    if ($row["SHS"]=="Y") {
        $row["SHS"]=array("on");
    }
    //
    
    $item_arr=$row;
    // get retrieved row
    return $item_arr ;

    // set values to object properties
    // $this->schguid= $row['schguid'];
    // $this->schdivid= $row['schdivid'];
    
    // $this->schdivbeis= $row['schdivbeis'];
    // $this->schoucode= $row['schoucode'];
    // $this->rectimestamp= $row['rectimestamp'];
    

   }

    // read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
            // select query
            
            
            
            $query = "SELECT
                        " . implode (', ',  $this->FIELD_NAME ) . "
                    FROM
                        " . $this->table_name .  " 
                        
                    ORDER BY schdivid  DESC
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
    //read by division
    public function readSchoolsByDiv(){
 
        // select query
        $search="";
        if ($this->schdescription!="") {

            $search=" and schdescription like :schdescription "; 
        }
        
        
        $query = "SELECT
                    " . implode (', ',  $this->FIELD_NAME ) . "
                FROM
                    " . $this->table_name .  " 
                where schdivid=:schdivid ".$search."
                ORDER BY schdescription  asc
                ";
    
        // prepare query statement
        //  echo $query;
        $stmt = $this->conn->prepare( $query );
       
        // bind variable values
        $stmt->bindParam(":schdivid", $this->schdivid);

        if ($search!="") {
            $searchname=$this->schdescription;
            $searchname="%".$searchname."%";
            $stmt->bindParam(":schdescription",$searchname);
        }
        // echo $this->schdivid.":".$searchname;
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }
    public function readSchoolsByReg(){
 
        // select query
        $search="";
        if ($this->schdescription!="") {

            $search=" and schdescription like :schdescription "; 
        }
        
        
        $query = "SELECT
                    a." . implode (', a.',  $this->FIELD_NAME ) . " 
                FROM
                    " . $this->table_name .  "  a inner join 
                    schooldivisions b on a.schdivid=b.schdivid
                where a.schdivid=:schdivid and  schregid=:schregid ".$search."
                ORDER BY schdescription  asc
                ";
    
        // prepare query statement
        // echo $query;
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(":schdivid", $this->schdivid);
        $stmt->bindParam(":schregid", $this->schregid);
        

        if ($search!="") {
            $searchname=$this->schdescription;
            $searchname="%".$searchname."%";
            $stmt->bindParam(":schdescription",$searchname);
        }
        
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }
    //read all 
    public function readAll(){
 
        // select query
           
        
        
        $query = "SELECT
                    " . implode (', ',  $this->FIELD_NAME ) . "
                FROM
                    " . $this->table_name .  " 
                    
                ORDER BY schdivid  DESC
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
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}
//Get School Head Signatory 
function getschheadsign($es,$jhs,$shs){

    $whereclause="";
    if ($es=='Y') {
        $whereclause=" a.es = :es";
        $es="Y";
    }
    if ($jhs=='Y') {
        if ($whereclause !="") { $whereclause=$whereclause." or " ;}
        $whereclause=$whereclause." a.jhs = :jhs";
        $jhs="Y";
    
    }
    if ($shs=='Y') {
        if ($whereclause !="") { $whereclause=$whereclause." or " ;}
        $whereclause=$whereclause." a.shs = :shs";
        $shs="Y";
    }

    
    
    
 
    // query to read single record
    $query = "select concat(c.gfirstname ,' ', c.gmiddlename,' ',  c.glastname) signatory

    from sysdivusers a inner join 
         sysroles b on a.gsysrole=b.roleguid inner join
         sysusers c on a.gsysuserid=c.guserid 
         
         
    where b.roletype='S' 
            and  a.gschool=:schguid    ";
    if ($whereclause!="") {
        $query=$query." and (".$whereclause.")";

    }
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":schguid", $this->schguid);
    if ($es=='Y') {
        $stmt->bindParam(":es", $es);
    
    }
    if ($jhs=='Y') {
        $stmt->bindParam(":jhs", $jhs);
    
    
    }
    if ($shs=='Y') {
        $stmt->bindParam(":shs", $shs);
    }
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $schsignatory="";
    $num = $stmt->rowCount();
    if ($num>0){
        $schsignatory=$row["signatory"];
    }
    return $schsignatory;
   }

//get by group code 
function getbycode(){
 
    // query to read single record
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name . " 
                
            WHERE
                schoucode= :schoucode
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":schoucode", $this->schoucode);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->schguid= $row['schguid'];
    $this->schoucode= $row['schoucode'];
    $this->schdivid= $row['schdivid'];
    $this->schdivbeis= $row['schdivbeis'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
