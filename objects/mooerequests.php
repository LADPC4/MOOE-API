<?php

/**
 * mooerequests.class.php
 * 
 **/
class mooerequests {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "mooerequests";
	//auto generated
    public $lasterror=null;
	public $PRIMARY_KEY = array('requestid'=>'requestid');
	private $FIELD_NAME = array('requestid'=>'requestid','schguid'=>'schguid','periodcovered'=>'periodcovered','totalamount'=>'totalamount',
                                'transferred'=>'transferred','paps'=>'paps','rectimestamp'=>'rectimestamp','userguid'=>'userguid',
                                'reqstatus'=>'reqstatus','schacctguid'=>'schacctguid');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //requestid, requestid, divguid, schoolguid, paps, totalamount, transferdate, fundyear, mooerequest, rectimestamp

	// protected $requestid = null;
	// protected $schdivid = null;
	// protected $divguid = null;
    // protected $schoolguid = null;
    // protected $paps = null;
	// protected $totalamount = null;
	// protected $transferdate = null;
    // protected $fundyear = null;
    // protected $mooerequest = null;
    // protected $userguid = null;
    // protected $rectimestamp = null;

    protected $properties =array();

    
    


	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        
    }

    //set property 

    public function set_property($pName, $pArg='0') {
        //chek if array exists 
        if (isset($this->properties[$pName])) {
            $this->properties[$pName]=$pArg;
        } else {
            $newprop=array($pName=>$pArg);
            $this->properties=array_merge($this->properties,$newprop);
        }	
	}
    public function get_property($pName) { return (string) $this->properties[$pName]; }


	// public function set_requestid($pArg='0') {
	// 	IF ( $this->requestid !== $pArg){
	// 		$this->requestid=$pArg; $this->FIELD_MODIFIED['requestid']=1;
	// 	}
	// }
	// public function set_schdivid($pArg='0') {
	// 	IF ( $this->schdivid !== $pArg){
	// 		$this->schdivid=$pArg; $this->FIELD_MODIFIED['schdivid']=1;
	// 	}
	// }
	// public function set_divguid($pArg='0') {
	// 	IF ( $this->divguid !== $pArg){
	// 		$this->divguid=$pArg; $this->FIELD_MODIFIED['divguid']=1;
	// 	}
	// }
    // public function set_schoolguid($pArg='0') {
	// 	IF ( $this->schoolguid !== $pArg){
	// 		$this->schoolguid=$pArg; $this->FIELD_MODIFIED['schoolguid']=1;
	// 	}
    // }
    // public function set_paps($pArg='0') {
	// 	IF ( $this->paps !== $pArg){
	// 		$this->paps=$pArg; $this->FIELD_MODIFIED['paps']=1;
	// 	}
	// }
	// public function set_totalamount($pArg='0') {
	// 	IF ( $this->totalamount !== $pArg){
	// 		$this->totalamount=$pArg; $this->FIELD_MODIFIED['totalamount']=1;
	// 	}
	// }
	// public function set_transferdate($pArg='0') {
	// 	IF ( $this->transferdate !== $pArg){
	// 		$this->transferdate=$pArg; $this->FIELD_MODIFIED['transferdate']=1;
	// 	}
	// }
    // public function set_fundyear($pArg='0') {
	// 	IF ( $this->fundyear !== $pArg){
	// 		$this->fundyear=$pArg; $this->FIELD_MODIFIED['fundyear']=1;
	// 	}
    // }
    // public function set_mooerequest($pArg='0') {
	// 	IF ( $this->mooerequest !== $pArg){
	// 		$this->mooerequest=$pArg; $this->FIELD_MODIFIED['mooerequest']=1;
	// 	}
    // }
    // public function set_userguid($pArg='0') {
	// 	IF ( $this->userguid !== $pArg){
	// 		$this->userguid=$pArg; $this->FIELD_MODIFIED['userguid']=1;
	// 	}
    // }
    
	// public function get_requestid() { return (string) $this->requestid; }
	// public function get_schdivid() { return (string) $this->schdivid; }
	// public function get_divguid() { return (string) $this->divguid; }
    // public function get_schoolguid() { return (string) $this->schoolguid; }
    // public function get_paps() { return (string) $this->paps; }
	// public function get_totalamount() { return (string) $this->totalamount; }
	// public function get_transferdate() { return (string) $this->divguid; }
	// public function get_fundyear() { return (string) $this->fundyear; }
    // public function get_mooerequest() { return (string) $this->mooerequest; }
    // public function get_userguid() { return (string) $this->userguid; }
    // public function get_rectimestamp() { return (string) $this->rectimestamp; }
    

//create insert/update field and bindings
function createUpdFlds(){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            if ($fistitem>1){
                $fld_list=$fld_list.",";
            }
            $fld_list=$fld_list.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    return $fld_list;
}
function createSelFlds($tblprfx=""){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    if ($tblprfx!="") $tblprfx=$tblprfx.".";
    // print_r($arr);
    foreach ($arr as $key => $value) {
        if ($fistitem>1){
            $fld_list=$fld_list.",";
        }
        $fld_list=$fld_list.$tblprfx.$key;
        $fistitem=$fistitem+1;
    }
    return $fld_list;
}

function createIDQry($tblprfx=""){
    $arr=$this->PRIMARY_KEY;
    $fld_list="";
    $fistitem=1;
    if ($tblprfx!="") $tblprfx=$tblprfx.".";
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            if ($fistitem>1){
                $fld_list=$fld_list." and ";
            }
            $fld_list=$fld_list.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    return $fld_list;
}
function createWhereQry($tblprfx=""){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    if ($tblprfx!="") $tblprfx=$tblprfx.".";
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            if ($fistitem>1){
                $fld_list=$fld_list." and ";
            }
            $fld_list=$tblprfx.$fld_list.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    return $fld_list;
}


//Bind
function bind(&$stmt){
 
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        
        // $fld_list=$fld_list.$key."=:".$value;
        if (isset($PRIMARY_KEY[$key])) {
            //do nothing 
        } else {
            
            if (isset( $this->properties[$key])) {
                $stmt->bindParam(":".$key, $this->properties[$key]); 
            }
        }
        
    }
    

}
function bindID(&$stmt){
    $arr=$this->PRIMARY_KEY;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        // echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            $stmt->bindParam(":".$key, $this->properties[$key]); 
        }
        

    }
    

}
  
function sanitize(){

    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        
        // $fld_list=$fld_list.$key."=:".$value;
        if (isset($PRIMARY_KEY[$key])) {
            //do nothing 
        } else {
            if (isset( $this->properties[$key])) {
                $this->properties[$key]=htmlspecialchars(strip_tags($this->properties[$key])); 
            }
            
        }
        
    }

}
    

//create
function create(){
 
    // query to insert record

    $query = "INSERT INTO " . $this->table_name . " SET ".$this->createUpdFlds();
 
    // prepare query
   //echo $query;
    $stmt = $this->conn->prepare($query);
    // sanitize
    $this->sanitize();
    // bind values
    $this->bind($stmt);
    
    // $this->divguid=htmlspecialchars(strip_tags($this->divguid));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));
 
   
   
  


    // execute query
    if($stmt->execute()){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
}

//update 
function update(){
 
   // query to insert record

   $query = "Update " . $this->table_name . " SET ".$this->createUpdFlds()."  where ".$this->createIDQry();
 
   // prepare query
  //echo $query;
   $stmt = $this->conn->prepare($query);
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

//delete 
function delete(){
 
    // update query
    $query = "delete from 
                " . $this->table_name . "
           
            WHERE
               ".$this->createIDQry();
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $this->bind($stmt);
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    // $stmt->bindParam(":requestid", $this->requestid);

 
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
    $tblprfx="a";
    $query = "SELECT " . $this->createSelFlds($tblprfx) . "
                , papsdescription papsdesc, 
                c.wfedit, c.completed , CONCAT(d.schbank, ':', d.schaccount)  acctdesc
                
            FROM
                " . $this->table_name . " " .$tblprfx. "
                inner join 
                papcodes b on a.paps=b.papguid inner join
                ct_workflow c on a.reqstatus=c.status inner 
                join schacctejs d on a.schacctguid=d.ejsguid

                
                
            WHERE ".$this->createIDQry($tblprfx);
 
    // prepare query statement
    // echo $query;
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $this->bindID($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
    // if (!$row) return false;
    // print_r($row);
    if ($row["wfedit"]=="Y") {
        $row["wfedit"]="true";
    } else {
        $row["wfedit"]="";
    }
    if ($row["completed"]=="Y") {
        $row["completed"]="";
    } else {
        $row["completed"]="true";
    }
    // print_r($row);
    $item_arr=$row;
    // get retrieved row
    return $item_arr ;
    

   }
   function readPendOne(){
 
    // query to read single record
    $tblprfx="c";
    $query = "SELECT "
    .$this->createSelFlds($tblprfx) . "
                , d.schdescription, f.papsdescription papsdesc,  b.description wfstatusdesc , d.schdescription
                , a.wfguid,  CONCAT(g.schbank, ':', g.schaccount)  acctdesc
            FROM sysrolewf a inner join 
                ct_workflow b on a.wfguid = b.wfguid inner join 
                mooerequests ".$tblprfx." on b.`status`= c.reqstatus  and b.completed='N' inner join 
                schools d on c.schguid = d.schguid inner join 
                schooldivisions e on d.schdivid=e.schdivid  inner join
                papcodes f on c.paps = f.papguid left join 
                schacctejs g on c.schacctguid=g.ejsguid
                
                
                
            WHERE ".$this->createIDQry($tblprfx);
 
    // prepare query statement
    // echo $query;
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $this->bindID($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    $item_arr=$row;
    // get retrieved row
    return $item_arr ;
    

   }

    // read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
            // select query
            $whereclause="";
            $es="";
            $jhs="";
            $shs="";
            $tblprfx="a" ; 
    
            // print_r($this);
            if ($this->get_property("es")=='Y') {
                $whereclause=" c.es = :es";
                $es="Y";
            }
            if ($this->get_property('jhs')=='Y') {
                if ($whereclause !="") { $whereclause=$whereclause." or " ;}
                $whereclause=$whereclause." c.jhs = :jhs";
                $jhs="Y";
            
            }
            if ($this->get_property('shs')=='Y') {
                if ($whereclause !="") { $whereclause=$whereclause." or " ;}
                $whereclause=$whereclause." c.shs = :shs";
                $shs="Y";
            }
    
            if ($whereclause!="") {
                $whereclause=$this->createWhereQry($tblprfx)." and (".$whereclause.")";
    
            } else {
                $whereclause=$this->createWhereQry($tblprfx);
            }
    
            
          
            $query = "SELECT " 
                       .$this->createSelFlds($tblprfx) . "
                       , b.schdescription, c.papsdescription papsdesc
                FROM
                    "  .$this->table_name . " " . $tblprfx ." inner join 
                    schools b on a.schguid = b.schguid inner join 
                    papcodes c on a.paps = c.papguid
                    
                WHERE ".$whereclause."
                order by a.rectimestamp desc
                LIMIT :L1, :L2";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
            // bind query parameters
            $this->bind($stmt);
            // bind variable values
            $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
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
        
            // return values from database
            return $stmt;
    }
    public function readApproved($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . "
                   , b.schdescription, c.papsdescription papsdesc
                   , CONCAT(DATE(a.rectimestamp),' | ',c.papsdescription ) reqdesc,
                   c.gaafield, CONCAT(e.schbank, ':', e.schaccount)  acctdesc,
                   b.ES, b.JHS, b.SHS
            FROM
                "  .$this->table_name . " " . $tblprfx ." inner join 
                schools b on a.schguid = b.schguid inner join   
                papcodes c on a.paps = c.papguid inner join 
                ct_workflow d on a.reqstatus = d.`status` and d.completed='Y' and a.transferred='N' inner join 
                schacctejs e on a.schacctguid=e.ejsguid
                
            WHERE ".$this->createWhereQry($tblprfx)."
            order by a.rectimestamp desc
            LIMIT :L1, :L2";
    
        // prepare query statement
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
    // read users with pagination
   public function readPending($from_record_num, $records_per_page){
 
    // select query
    
    
    $tblprfx="c" ; 
    $where = $this->createWhereQry($tblprfx);
    if ($where!="") {
        $where=$where." and " ;
    }
    $query = "SELECT " 
               .$this->createSelFlds($tblprfx) . "
               , d.schdescription, f.papsdescription papsdesc,  b.description wfstatusdesc, d.schoolid
        FROM sysrolewf a inner join 
                ct_workflow b on a.wfguid = b.wfguid inner join 
                mooerequests ".$tblprfx." on b.`status`= c.reqstatus  and b.completed='N' inner join 
                schools d on c.schguid = d.schguid inner join 
                schooldivisions e on d.schdivid=e.schdivid  inner join
                papcodes f on c.paps = f.papguid
               

        WHERE ".$where." e.schdivid=:schdivid and a.roleguid=:roleguid 
        order by c.rectimestamp desc
        LIMIT :L1, :L2";
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    $this->bind($stmt);
    $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    $stmt->bindParam(":roleguid", $this->properties["roleguid"]); 
    // bind variable values
    $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}
    
    public function readUnConfirmdPaging($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . " , b.papsdescription, 
                   concat(  a.transferdate , ' | ', b.papsdescription ) datedesc

            FROM
                "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.paps=b.papguid 
                
            WHERE ".$this->createWhereQry()."

            LIMIT :L1, :L2";
    
        // prepare query statement
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


// used for paging user
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function Pendingcount(){
    $query = "SELECT COUNT(*) as total_rows 
    FROM  sysrolewf a inner join 
    ct_workflow b on a.wfguid = b.wfguid inner join 
    mooerequests c on b.`status`= c.reqstatus  and b.completed='N' inner join 
    schools d on c.schguid = d.schguid inner join 
    schooldivisions e on d.schdivid=e.schdivid  inner join
    papcodes f on c.paps = f.papguid
   

WHERE e.schdivid=:schdivid and a.roleguid=:roleguid";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    $stmt->bindParam(":roleguid", $this->properties["roleguid"]); 
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function UnConfirmdcount(){
    $tblprfx = "a";
    $query = "SELECT COUNT(*) as total_rows FROM
        "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.paps=b.papguid 
    
        WHERE ".$this->createWhereQry();
 
    $stmt = $this->conn->prepare( $query );
    $this->bind($stmt);
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
                schoolguid= :schoolguid
            LIMIT
                0,1";
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":schoolguid", $this->schoolguid);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->requestid= $row['requestid'];
    $this->schoolguid= $row['schoolguid'];
    $this->schdivid= $row['schdivid'];
    $this->divguid= $row['divguid'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
