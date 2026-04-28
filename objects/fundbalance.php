<?php

/**
 * fundbalance.class.php
 * 
 **/
class fundbalance {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "fundbalance";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('fbguid'=>'fbguid');
	private $FIELD_NAME = array('fbguid'=>'fbguid',  'fundyear'=>'fundyear','schdivid'=>'schdivid', 'schguid'=>'schguid',
                                'fundmonth'=>'fundmonth', 'regmooebegbal'=>'regmooebegbal', 'otherfundbegbal'=>'otherfundbegbal',
                                'esbegbal'=>'esbegbal',  'jhsbegbal'=>'jhsbegbal', 'shsbegbal'=>'shsbegbal','closed'=>'closed',
                                'userguid'=>'userguid',  'rectimestamp'=>'rectimestamp');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //fbguid, schguid, fundyear, fundmonth, regmooebegbal, otherfundbegbal, userguid, rectimestamp

	// protected $fbguid = null;
	// protected $fundyear = null;
	// protected $divguid = null;
    // protected $schoolguid = null;
    // protected $fundmonth = null;
	// protected $regmooebegbal = null;
	// protected $otherfundbegbal = null;
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

function createIDQry($tblprfx){
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
            $fld_list=$fld_list.$tblprfx.$key."=:".$value;
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
            $fld_list=$fld_list.$tblprfx.$key."=:".$value;
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
 
   
   
  
    try {
       // execute query
        if($stmt->execute()){
            return true;
        }
        $this->lasterror=implode(" ",$stmt->errorInfo());
        return false;
    } catch (Exception $e) {
        //echo 'Caught exception: ',  $e->getMessage(), "\n";
        $this->lasterror="Duplicate Record for School. Please check Year and month ";
        return false;
    } 

    
     
}

//update 
function update(){
 
   // query to insert record
   $tblprfx="" ;
   $query = "Update " . $this->table_name . " SET ".$this->createUpdFlds()."  where ".$this->createIDQry($tblprfx);
 
   // prepare query
//   echo $query;
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
    $tblprfx="" ; 
    $query = "delete from 
                " . $this->table_name . "
           
            WHERE ".$this->createIDQry($tblprfx);
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $this->bind($stmt);
 
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
    $tblprfx="a" ; 
    $query = "SELECT
                " . $this->createSelFlds($tblprfx) . "
                ,b.schdescription
            FROM
                " . $this->table_name . " " . $tblprfx ." inner join 
                schools b on a.schguid=b.schguid
            WHERE ".$this->createWhereQry( $tblprfx);
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
    // echo $this->get_property("fundyear"); 
    // bind id of product to be updated
   
    $this->bind($stmt);
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
            
            
            $tblprfx="a" ; 
            $query = "SELECT " 
                       .$this->createSelFlds($tblprfx) . ",
                       b.schdescription
                FROM
                    "  .$this->table_name . " " . $tblprfx ." inner join 
                    schools b on a.schguid=b.schguid
                WHERE ".$this->createWhereQry( $tblprfx)."
                order by " . $tblprfx .".rectimestamp desc
                LIMIT :L1, :L2";
        
            // prepare query statement
            // echo $query;
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
public function monthClosed(){
    $fundmonth=$this->get_property("fundmonth");
    $fundyear=$this->get_property("fundyear");
    $schguid=$this->get_property("schguid");
    $query = "select  closed 
            from fundbalance
        where  fundmonth=:fundmonth and fundyear=:fundyear and schguid=:schguid";
        
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(":fundmonth", $fundmonth);
    $stmt->bindParam(":fundyear", $fundyear);
    $stmt->bindParam(":schguid", $schguid);
    $stmt->execute();
    if ($stmt->rowCount()>0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['closed'];
    } else {
        return 'N';
    }
    
}
public function closingPreview(){

    $preview=array();
    $fundmonth=$this->get_property("fundmonth");
    $fundyear=$this->get_property("fundyear");
    $schguid=$this->get_property("schguid");

    $prevquery="select fbguid, schguid, fundyear, fundmonth, regmooebegbal, otherfundbegbal, userguid, 
                    rectimestamp, schdivid, schacctguid, esbegbal, jhsbegbal, shsbegbal, closed 
                    from fundbalance
                where  fundmonth=:fundmonth and fundyear=:fundyear and schguid=:schguid";
    
    $prev_stmt = $this->conn->prepare( $prevquery );

    // bind query parameters
    $this->bind($prev_stmt);
    // bind variable values
    $prev_stmt->bindParam(":fundmonth", $fundmonth);
    $prev_stmt->bindParam(":fundyear", $fundyear);
    $prev_stmt->bindParam(":schguid", $schguid);
    // execute query
    $prev_stmt->execute();
    $fundsquery="select d.schdescription,  c.papsdescription ,c.regmooe, c.es,c.jhs,c.shs,
                    concat(e.schbank,':',e.schaccount) schbank ,
                    sum(a.totalamount) totalfunds  
                
                from funds a inner join 
                        papcodes c on a.paps= c.papguid inner join 
                        schools d on a.schguid=d.schguid inner join 
                        schacctejs e on a.schacctguid=e.ejsguid
                where month(a.transferdate)=:fundmonth and year(a.transferdate)=:fundyear and a.schguid=:schguid
                group by d.schdescription , c.papsdescription,c.regmooe, c.es,c.jhs,c.shs, concat(e.schbank,':',e.schaccount) 
                order by d.schdescription ";

    
    $fund_stmt = $this->conn->prepare( $fundsquery );
    // bind query parameters
    $this->bind($fund_stmt);
    // bind variable values
    $fund_stmt->bindParam(":fundmonth", $fundmonth);
    $fund_stmt->bindParam(":fundyear", $fundyear);
    $fund_stmt->bindParam(":schguid", $schguid);
    // execute query
    $fund_stmt->execute();
    $disbquery="select d.schdescription,  c.papsdescription ,c.regmooe, c.es,c.jhs,c.shs,
                    concat(e.schbank,':',e.schaccount) schbank ,
                    sum(b.netamount) *-1 totaldisbursments       
                
                from funds a inner join 
                mooedisbursements b on a.fundguid=b.fundguid inner join
                papcodes c on a.paps= c.papguid inner join 
                schools d on a.schguid=d.schguid inner join 
                schacctejs e on a.schacctguid=e.ejsguid
                where b.dismonth=:fundmonth and year(b.disrefdate)=:fundyear  and a.schguid=:schguid
                
                group by d.schdescription , c.papsdescription,c.regmooe, c.es,c.jhs,c.shs, concat(e.schbank,':',e.schaccount) 
                order by d.schdescription; 
                ";
    $disb_stmt = $this->conn->prepare( $disbquery );
    // bind query parameters
    $this->bind($disb_stmt);
    // bind variable values
    $disb_stmt->bindParam(":fundmonth", $fundmonth);
    $disb_stmt->bindParam(":fundyear", $fundyear);
    $disb_stmt->bindParam(":schguid", $schguid);
    // execute query
    $disb_stmt->execute();
    

    // return values from database
   
    $preview["prevbal"]=$prev_stmt;
    $preview["funds"]=$fund_stmt;
    $preview["disbs"]=$disb_stmt;
    
    return $preview;


}
           

}
