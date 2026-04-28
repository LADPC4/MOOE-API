<?php

/**
 * mooedisbursements.class.php
 * 
 **/
include_once 'schools.php';
class mooedisbursements {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "mooedisbursements";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('mooedisid'=>'mooedisid');
    private $FIELD_NAME = array('mooedisid'=>'mooedisid',  'fundguid'=>'fundguid', 'schguid'=>'schguid', 'fundcluster'=>'fundcluster', 
                                'disreferenceno'=>'disreferenceno', 'disrefdate'=>'disrefdate', 'dismonth'=>'dismonth', 
                                'disstatus'=>'disstatus', 'payee'=>'payee', 'payeetin'=>'payeetin',  

                                'orbursno'=>'orbursno', 'coaguid'=>'coaguid', 'trantype'=>'trantype', 
                                'vattype'=>'vattype', 'particulars'=>'particulars', 'grossamount'=>'grossamount',  

                                'netvat'=>'netvat', 'bir2306'=>'bir2306', 'bir2307'=>'bir2307', 
                                'netamount'=>'netamount',  
                                'liquidated'=>'liquidated', 
                                'printed'=>'printed', 
                                'cibr'=>'cibr', 
                                'userguid'=>'userguid',  
                                'rectimestamp'=>'rectimestamp');
                                
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //mooedisid, fundguid, schguid, fundcluster, disreferenceno, 
    // disrefdate, dismonth, disstatus, payee, payeetin, orbursno, category, 
    // trantype, vattype, particulars, grossamount, netvat, bir2306, bir2307, netamount, rectimestamp

	// protected $mooedisid = null;
	// protected $schdivid = null;
	// protected $divguid = null;
    // protected $schoolguid = null;
    // protected $fundcluster = null;
	// protected $disreferenceno = null;
	// protected $disrefdate = null;
    // protected $dismonth = null;
    // protected $disstatus = null;
    // protected $payee = null;
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
// function createSelFlds($tblprfx=""){
//     $arr=$this->FIELD_NAME;
//     $fld_list="";
//     $fistitem=1;
//     $tblprfx=$tblprfx.".";
//     // print_r($arr);
//     foreach ($arr as $key => $value) {
//         if ($fistitem>1){
//             $fld_list=$fld_list.",";
//         }
//         $fld_list=$fld_list.$tblprfx.$key;
//         $fistitem=$fistitem+1;
//     }
//     return $fld_list;
// }
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
    // echo $fld_list;
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
            $fld_list=$tblprfx.$fld_list.$key."=:".$value;
            $fistitem=$fistitem+1;
        }
        

    }
    return $fld_list;
}
function createWhereQry($tblprfx=""){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    $tblprfx=$tblprfx.".";
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
           
            WHERE ".$this->createIDQry();
 
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
    $tblprfx="a";
    $query = "SELECT
                " . $this->createSelFlds($tblprfx) . "
                 , a.trantype trandesc, a.vattype vatdesc
                 , d.papsdescription, c.coadesc ,c.coacode, e.wfprint,e.wfedit ,
                 e.wfguid, 
                 signatory1 ADAS,
                 signatory2 SchoolHead,
                 g.schbank,
                 g.schaccount ,
                 d.es,
                 d.jhs,
                 d.shs
            FROM
                " . $this->table_name . " " . $tblprfx ." inner join 
                funds b on a.fundguid = b.fundguid inner join 
                ct_chartofacc c on a.coaguid = c.coaguid inner join 
                papcodes d on b.paps=d.papguid inner join 
                ct_workflow e on a.disstatus=e.status inner join 
                schools f on a.schguid=f.schguid  inner join 
                schacctejs g on b.schacctguid =g.ejsguid

                
                
            WHERE ".$this->createIDQry($tblprfx);
 
    // prepare query statement
    // echo $query ;
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $this->bindID($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //  echo $query ;
    // print_r($row);

    if ($row["liquidated"]=="Y") {
        $row["liquidated"]=array("on");
    } 
    if ($row["wfprint"]=="Y") {
        $row["wfprint"]="true";
    } else {
        $row["wfprint"]="";
    }
    if ($row["wfedit"]=="Y") {
        $row["wfedit"]="true";
    } else {
        $row["wfedit"]="";
    }


    //get sch head signatory
    $schools = new schools($this->conn);
    $schools->set_schguid($row["schguid"]);

    $SchoolHead= $schools->getschheadsign($row["es"],$row["jhs"],$row["shs"]);
    $row["SchoolHead"]=$SchoolHead;

    $item_arr=$row;
    // get retrieved row
    return $item_arr ;
    

   }
   function readOneDivDis(){
 
    // query to read single record
    $tblprfx="a";
    $query = "SELECT
                " . $this->createSelFlds($tblprfx) . "
                 , a.trantype trandesc, a.vattype vatdesc
                 , d.papsdescription, c.coadesc ,c.coacode, e.wfprint,e.wfedit ,
                 e.wfguid, 
                 '' ADAS,
                 '' SchoolHead,
                 g.schbank,
                 g.schaccount ,
                 d.es,
                 d.jhs,
                 d.shs
            FROM
                " . $this->table_name . " " . $tblprfx ." inner join 
                funds b on a.fundguid = b.fundguid inner join 
                ct_chartofacc c on a.coaguid = c.coaguid inner join 
                papcodes d on b.paps=d.papguid inner join 
                ct_workflow e on a.disstatus=e.status inner join 
                schooldivisions f on a.schguid=f.schdivid  inner join 
                schacctejs g on b.schacctguid =g.ejsguid

                
                
            WHERE ".$this->createIDQry($tblprfx);
 
    // prepare query statement
    // echo $query ;
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $this->bindID($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //  echo $query ;
    // print_r($row);

    if ($row["liquidated"]=="Y") {
        $row["liquidated"]=array("on");
    } 
    if ($row["wfprint"]=="Y") {
        $row["wfprint"]="true";
    } else {
        $row["wfprint"]="";
    }
    if ($row["wfedit"]=="Y") {
        $row["wfedit"]="true";
    } else {
        $row["wfedit"]="";
    }


    //get sch head signatory
    $schools = new schools($this->conn);
    $schools->set_schguid($row["schguid"]);

    $SchoolHead= $schools->getschheadsign($row["es"],$row["jhs"],$row["shs"]);
    $row["SchoolHead"]=$SchoolHead;

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
            $whereclause=" d.es = :es";
            $es="Y";
        }
        if ($this->get_property('jhs')=='Y') {
            if ($whereclause !="") { $whereclause=$whereclause." or " ;}
            $whereclause=$whereclause." d.jhs = :jhs";
            $jhs="Y";
        
        }
        if ($this->get_property('shs')=='Y') {
            if ($whereclause !="") { $whereclause=$whereclause." or " ;}
            $whereclause=$whereclause." d.shs = :shs";
            $shs="Y";
        }

        if ($whereclause!="") {
            $whereclause=$this->createWhereQry($tblprfx)." and (".$whereclause.")";

        } else {
            $whereclause=$this->createWhereQry($tblprfx);
        }

        
            
            $query = "SELECT " 
                       .$this->createSelFlds($tblprfx) . "
                       , d.papsdescription, c.coadesc
                FROM
                    "  .$this->table_name . " " . $tblprfx ." inner join 
                    funds b on a.fundguid = b.fundguid inner join 
                    ct_chartofacc c on a.coaguid = c.coaguid inner join 
                    papcodes d on b.paps=d.papguid 


                    
                WHERE ".$whereclause."
                order by ".$tblprfx.".rectimestamp desc
                LIMIT :L1, :L2 
                "
                ; //modify to show only unfinalized months
        
            // prepare query statement
            // echo $query;
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
    public function readPrinted($from_record_num, $records_per_page){
 
        // select query
        
    $whereclause="";
    $es="";
    $jhs="";
    $shs="";
    $tblprfx="a" ; 

    // print_r($this);
    if ($this->get_property("es")=='Y') {
        $whereclause=" d.es = :es";
        $es="Y";
    }
    if ($this->get_property('jhs')=='Y') {
        if ($whereclause !="") { $whereclause=$whereclause." or " ;}
        $whereclause=$whereclause." d.jhs = :jhs";
        $jhs="Y";
    
    }
    if ($this->get_property('shs')=='Y') {
        if ($whereclause !="") { $whereclause=$whereclause." or " ;}
        $whereclause=$whereclause." d.shs = :shs";
        $shs="Y";
    }

    if ($whereclause!="") {
        $whereclause=$this->createWhereQry($tblprfx)." and (".$whereclause.")";

    } else {
        $whereclause=$this->createWhereQry($tblprfx);
    }

    
        
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . "
                   , d.papsdescription, c.coadesc
            FROM
                "  .$this->table_name . " " . $tblprfx ." inner join 
                funds b on a.fundguid = b.fundguid inner join 
                ct_chartofacc c on a.coaguid = c.coaguid inner join 
                papcodes d on b.paps=d.papguid 


                
            WHERE ".$whereclause." and b.fundyear = :fundyear and  ".$tblprfx.".printed='Y'
            order by ".$tblprfx.".rectimestamp desc
            LIMIT :L1, :L2 
            "
            ; //modify to show only unfinalized months
    
        // prepare query statement
        // echo $query;
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        $this->bind($stmt);
        // bind variable values
        $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
        $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
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
        // read users with pagination
   public function readPending($from_record_num, $records_per_page){
 
            // select query
            
        
            $tblprfx="a" ; 
            $query = "SELECT " 
                       .$this->createSelFlds($tblprfx) . "
                       , d.papsdescription, c.coadesc, e.description
                FROM
                    "  .$this->table_name . " " . $tblprfx ." inner join 
                    funds b on a.fundguid = b.fundguid inner join 
                    ct_chartofacc c on a.coaguid = c.coaguid inner join 
                    papcodes d on b.paps=d.papguid inner join
                ct_workflow e   on a.disstatus=e.status  inner join 
                sysrolewf f on e.wfguid = f.wfguid 

                    
                    
                WHERE ".$this->createWhereQry($tblprfx)." 
                     and f.roleguid=:roleguid
                order by ".$tblprfx.".rectimestamp desc
                LIMIT :L1, :L2 
                "
                ; //modify to show only unfinalized months
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
            // bind query parameters
            $this->bind($stmt);
            // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
            $stmt->bindParam(":roleguid", $this->properties["roleguid"]); 
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

// used for paging user
public function Pendingcount(){
    $tblprfx="a" ; 
    $query = "SELECT COUNT(*) as total_rows FROM  "  .$this->table_name . " " . $tblprfx ." inner join 
            funds b on a.fundguid = b.fundguid inner join 
            ct_chartofacc c on a.coaguid = c.coaguid inner join 
            papcodes d on b.paps=d.papguid inner join
        ct_workflow e   on a.disstatus=e.status  inner join 
        sysrolewf f on e.wfguid = f.wfguid 

            
            
        WHERE ".$this->createWhereQry($tblprfx)." 
            and f.roleguid=:roleguid";
 
    $stmt = $this->conn->prepare( $query );
    // echo ( $query);
    $this->bind($stmt);
    $stmt->bindParam(":roleguid", $this->properties["roleguid"]); 
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}


 // read users with pagination
 public function readTransactions(){
 
    // select query
    

    $tblprfx="md" ; 
    $query = "select  ".$this->createSelFlds($tblprfx) ."
                ,ca.coadesc,ca.coacode,ps.regmooe
            from mooedisbursements md inner join 
                    funds fd on md.fundguid=fd.fundguid inner join
                    papcodes ps on fd.paps=ps.papguid inner join 
                    ct_chartofacc ca on md.coaguid=ca.coaguid
            where ".$this->createWhereQry($tblprfx)." and  year(fd.transferdate)=:fundyear and 
                    fd.schacctguid = :schacctguid and
                   length(disreferenceno) >0 and length(disrefdate) > 0
            order by ".$tblprfx.".disrefdate,disreferenceno asc ";
       
        ; //modify to show only unfinalized months

    // prepare query statement
    // echo $query;
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    $this->bind($stmt);
    $stmt->bindParam(":schacctguid", $this->properties["schacctguid"]); 
    $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}

public function readRecap(){
 
    // select query
    

    $tblprfx="md" ; 
    $query = "select pc.papsdescription, ca.coadesc, ca.coacode, sum(md.grossamount ) grossamt
    from mooedisbursements md inner join 
         ct_chartofacc ca on md.coaguid=ca.coaguid inner join 
         funds fd on md.fundguid=fd.fundguid inner join 
         papcodes pc on fd.paps=pc.papguid
    where  ".$this->createWhereQry($tblprfx)." and 
        fd.schacctguid=:schacctguid and
        fd.fundyear=:fundyear and 
        
        ca.coacode not in 
        (
        '2020101000', 							
        '5020101000',
        '5020201000',
        '5020301000',
        '5020399000',
        '5020401000',
        '5020402000',
        '5021203000'
        )
        
    group by pc.papsdescription, ca.coadesc, ca.coacode ";
       
        ; //modify to show only unfinalized months

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    $this->bind($stmt);
    $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    $stmt->bindParam(":schacctguid", $this->properties["schacctguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}

public function genBIR2307(){
 
    // select query
    

    $tblprfx="md" ; 
    $query = "select fd.fundyear, dismonth, disrefdate, payee,payeetin,vattype, trantype, 
            case trantype 
            when 'Goods' then 
                    case vattype
                        when 'VAT' then 
                                bir2306 
                        else 0
                        end      
            else 0 
            end 
            WV010,
            case trantype 
            when 'Services' then 
                    case vattype
                        when 'VAT' then 
                                bir2306 
                        else 0
                        end 
            else 0 
            end 
            WV020,
        case vattype 
            when 'NONVAT' then 
                    case trantype
                        when 'Goods' then 
                                bir2306 
                            when 'Services' then 
                                bir2306 
                        else 0
                        end 
                
            else 0 
            end 
            WB080,	
            case trantype 
            when 'Goods' then 
                    bir2307
            else 0 
            end 
            WC157, 
            case trantype 
            when 'Services' then 
                    bir2307
            else 0 
            end 
            WC640, 
            bir2306+bir2307 totaltax, grossamount
    from mooedisbursements ".$tblprfx." inner join 
         funds fd on md.fundguid=fd.fundguid
    where  ".$this->createWhereQry($tblprfx)." and fd.fundyear=:fundyear
    order by 1,2,3 ";
       
        ; //modify to show only unfinalized months

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    $this->bind($stmt);
    $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}
public function genBIR2307d(){
 
    // select query
    

    $tblprfx="md" ; 
    $query = "select fd.fundyear, 
                    pc.papsdescription ,pc.es,pc.jhs,pc.shs,
                    
                    dismonth,  sc.schdescription, sc.schoolid,
                    sum(
                        case trantype 
                    when 'Goods' then 
                            case vattype
                                when 'VAT' then 
                                        bir2306 
                                else 0
                                end      
                    else 0 
                    end )    WV010,
                    sum(
                        case trantype 
                    when 'Goods' then 
                            case vattype
                                when 'NONVAT' then 
                                        bir2307 
                                else 0
                                end      
                    else 0 
                    end )    WI640,
                    sum(
                        case trantype 
                    when 'Services' then 
                            case vattype
                                when 'NONVAT' then 
                                        bir2307 
                                else 0
                                end   
                    when 'Others' then 
                    case vattype
                        when 'NONVAT' then 
                                bir2307 
                        else 0
                        end      
                    else 0 
                    end )    WI157,
                    sum(
                        case trantype 
                    when 'Services' then 
                            case vattype
                                when 'VAT' then 
                                        bir2306 
                                else 0
                                end 
                    when 'Others' then 
                    case vattype
                        when 'VAT' then 
                                bir2306 
                        else 0
                        end 
                    else 0 
                    end ) WV020,
                    sum(
                        case vattype 
                    when 'NONVAT' then 
                            case trantype
                                when 'Goods' then 
                                        bir2306 
                                    when 'Services' then 
                                        bir2306 
                                else 0
                                end 
                        
                    else 0 
                    end )  WB084,	
                    0 WB080,
                sum(
                    case trantype 
                    when 'Services' then 
                        case vattype 
                        when 'VAT' then 
                            bir2307 
                        else 
                            0
                        end 
                    when 'Others' then 
                    case vattype 
                    when 'VAT' then 
                        bir2307 
                    else 
                        0
                    end 
                    else 0 
                    end )
                    WC157, 
                    sum(
                        case trantype 
                    when 'Goods' then 
                        case vattype 
                        when 'VAT' then 
                            bir2307 
                        else 
                            0
                        end 
                            
                    else 0 
                    end )   WC640, 
                    sum(
                        bir2306+bir2307 )totaltax,
                    sum(grossamount)	 grossamount
                from mooedisbursements md inner join 
                funds fd on md.fundguid=fd.fundguid inner join 
                schools sc on fd.schguid=sc.schguid inner join 
                papcodes pc on fd.paps=pc.papguid
            where  ".$this->createWhereQry($tblprfx)." and 
                   fd.fundyear=:fundyear and pc.regmooe='Y' and 
                   fd.schdivid=:schdivid
            group by fd.fundyear,  pc.papsdescription, pc.es,pc.jhs,pc.shs, dismonth,  sc.schdescription, sc.schoolid
            order by 1,2 ,3,4,5,6,7,8 ";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    $this->bind($stmt);
    $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}
public function genBIR2307f(){
 
    // select query
    // other services = services for ATC

    $tblprfx="md" ; 
    $query = "select mooedisid,disreferenceno,disrefdate,dismonth,
                payee, payeetin, particulars, 
                sc.schdescription, sc.schaddress,
                trantype, vattype,grossamount,
                case trantype 
                when 'Goods' then 
                        case vattype
                        when 'VAT' then 
                                'WV010'
                            when 'NONVAT' then 
                                'WB084'
                        end      
                when 'Services' then 
                    case vattype
                        when 'VAT' then 
                                'WV020' 
                            when 'NONVAT' then 
                                'WB084'
                        end 
                when 'Others' then 
                case vattype
                    when 'VAT' then 
                            'WV020' 
                        when 'NONVAT' then 
                            'WB084'
                    end 
                end      
                ATC , 
                case trantype 
                when 'Goods' then 
                        case vattype
                        when 'VAT' then 
                                'WC640'
                            when 'NONVAT' then 
                                'WI640'
                        end      
                when 'Services' then 
                    case vattype
                        when 'VAT' then 
                                'WC157' 
                            when 'NONVAT' then 
                                'WI157'
                        end 
                when 'Others' then 
                case vattype
                    when 'VAT' then 
                            'WC157' 
                        when 'NONVAT' then 
                            'WI157'
                    end 
            
                end      
                ATC2 , 
            bir2306, bir2307 ,
            case dismonth 
               when '1' then 
                    grossamount
                
               when '4' then 
                    grossamount
                
               when '7' then 
                    grossamount
                
               when '10' then 
                    grossamount
                
               else 
                  ''
            end fqtr,
            case dismonth 
               when '2' then 
                    grossamount
                
               when '5' then 
                    grossamount
                
               when '8' then 
                    grossamount
                
               when '11' then 
                    grossamount
                
               else 
                  ''
            end sqtr,
            case dismonth 
               when '3' then 
                    grossamount
                
               when '6' then 
                    grossamount
                
               when '9' then 
                    grossamount
                
               when '12' then 
                    grossamount
                
               else 
                  ''
            end tqtr
            
            from mooedisbursements md inner join 
            schools sc on md.schguid=sc.schguid and md.printed='Y' 
   
            where  ".$this->createWhereQry($tblprfx)."
            order by 1,2,3 ";
       
        ; //modify to show only unfinalized months

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    $this->bind($stmt);
    // $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}
public function genBIR2307s(){
 
    // select query
    

    $tblprfx="md" ; 
    $query = "select fd.fundyear, 
                    pc.papsdescription ,pc.es,pc.jhs,pc.shs,
                    
                    dismonth,  sc.schdescription, sc.schoolid,
                    (
                        case trantype 
                    when 'Goods' then 
                            case vattype
                                when 'VAT' then 
                                        bir2306 
                                else 0
                                end      
                    else 0 
                    end )    WV010,
                    (
                        case trantype 
                    when 'Goods' then 
                            case vattype
                                when 'NONVAT' then 
                                        bir2307 
                                else 0
                                end      
                    else 0 
                    end )    WI640,
                    (
                        case trantype 
                    when 'Services' then 
                            case vattype
                                when 'NONVAT' then 
                                        bir2307 
                                else 0
                                end   
                    when 'Others' then 
                    case vattype
                        when 'NONVAT' then 
                                bir2307 
                        else 0
                        end      
                    else 0 
                    end )    WI157,
                    (
                        case trantype 
                    when 'Services' then 
                            case vattype
                                when 'VAT' then 
                                        bir2306 
                                else 0
                                end 
                    when 'Others' then 
                    case vattype
                        when 'VAT' then 
                                bir2306 
                        else 0
                        end 
                    else 0 
                    end ) WV020,
                    (
                        case vattype 
                    when 'NONVAT' then 
                            case trantype
                                when 'Goods' then 
                                        bir2306 
                                    when 'Services' then 
                                        bir2306 
                                else 0
                                end 
                        
                    else 0 
                    end )  WB084,	
                    0 WB080,
                    (
                    case trantype 
                    when 'Services' then 
                        case vattype 
                        when 'VAT' then 
                            bir2307 
                        else 
                            0
                        end 
                    when 'Others' then 
                    case vattype 
                    when 'VAT' then 
                        bir2307 
                    else 
                        0
                    end 
                    else 0 
                    end )
                    WC157, 
                    (
                        case trantype 
                    when 'Goods' then 
                        case vattype 
                        when 'VAT' then 
                            bir2307 
                        else 
                            0
                        end 
                            
                    else 0 
                    end )   WC640, 
                    (
                        bir2306+bir2307 )totaltax,
                    (grossamount)	 grossamount
                    ,disreferenceno,disrefdate,
                payee, payeetin, particulars, 
               
                trantype, vattype
                from mooedisbursements md inner join 
                funds fd on md.fundguid=fd.fundguid inner join 
                schools sc on fd.schguid=sc.schguid inner join 
                papcodes pc on fd.paps=pc.papguid 
            where  ".$this->createWhereQry($tblprfx)." and 
                   fd.fundyear=:fundyear and pc.regmooe='Y'  -- and 
                   -- fd.schdivid=:schdivid
            -- group by fd.fundyear,  pc.papsdescription, pc.es,pc.jhs,pc.shs, dismonth,  sc.schdescription, sc.schoolid
            order by 1,2 ,3,4,5,6,7,8 ";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    $this->bind($stmt);
    $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}

public function genDOOEMain(){
 
    // select query
    

    $tblprfx="d" ; 
    $query = "select s.schdescription, s.schoolid, 
                case 
                    when isnull(p.fundassignment) then 'Others'
                    else p.fundassignment
                end slevel ,
                s.schguid, 
                sum(d.grossamount) Total_utils

            from mooedisbursements d inner join 
                funds f on d.fundguid=f.fundguid and f.fundyear=:fundyear inner join 
                papcodes p on f.paps=p.papguid  inner join
                schools s on d.schguid=s.schguid
                
            where s.schdivid=:schdivid
            group by 1,2 ,3 ,4
            order by 3,1 ;  ";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    // $this->bind($stmt);
    $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}

public function genDOOEDetails($schguid,$fundyear,$slevel){
 
    // select query
    

    $tblprfx="d" ; 
    $query = "select s.schguid, 
                    o.coacode, 
                    o.coadesc, 
                    case 
                        when isnull(p.fundassignment) then 'Others'
                        else p.fundassignment
                    end slevel ,
                    
                    sum(d.grossamount) total_utils

                from mooedisbursements d inner join 
                    funds f on d.fundguid=f.fundguid and f.fundyear=:fundyear inner join 
                    papcodes p on f.paps=p.papguid  inner join 
                    ct_chartofacc o on d.coaguid=o.coaguid inner join
                    schools s on d.schguid=s.schguid
                    
                where s.schguid=:schguid and p.fundassignment=:slevel

                group by 1,2 ,3 ,4
                order by 2,1 ";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    // $this->bind($stmt);
    $stmt->bindParam(":fundyear",$fundyear); 
    $stmt->bindParam(":schguid", $schguid); 
    $stmt->bindParam(":slevel", $slevel); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}

public function genROOEMain(){
 
    // select query
    

    $tblprfx="d" ; 
    $query = "select sd.divdescription schdescription, sd.divcode schoolid , 
                    case 
                        when isnull(p.fundassignment) then 'Others'
                        else p.fundassignment
                    end slevel ,
                    sd.schdivid, 
                   0 total_utils

                from mooedisbursements d inner join 
                    funds f on d.fundguid=f.fundguid and f.fundyear=:fundyear inner join 
                    papcodes p on f.paps=p.papguid  inner join
                    schools s on d.schguid=s.schguid inner join
                    schooldivisions sd on s.schdivid = s.schdivid
                
            where  sd.schregid=:schregid
            group by 1,2 ,3 ,4
            order by 3,1 ;  ";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    // $this->bind($stmt);
    $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    $stmt->bindParam(":schregid", $this->properties["schregid"]); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}

public function genROOEDetails($schdivid,$fundyear,$slevel){
 
    // select query
    

    $tblprfx="d" ; 
    $query = "select  s.schdivid, 
                        o.coacode, 
                        o.coadesc, 
                        case 
                            when isnull(p.fundassignment) then 'Others'
                            else p.fundassignment
                        end slevel ,
                        
                        sum(d.grossamount) total_utils

                    from mooedisbursements d inner join 
                        funds f on d.fundguid=f.fundguid and f.fundyear=:fundyear inner join 
                        papcodes p on f.paps=p.papguid  inner join 
                        ct_chartofacc o on d.coaguid=o.coaguid inner join
                        schools s on d.schguid=s.schguid
                    
                where s.schdivid=:schdivid and p.fundassignment=:slevel

                group by 1,2 ,3 ,4
                order by 2,1 ";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    // $this->bind($stmt);
    $stmt->bindParam(":fundyear",$fundyear); 
    $stmt->bindParam(":schdivid", $schdivid); 
    $stmt->bindParam(":slevel", $slevel); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}
public function genROOEDivTotalUtils($schdivid,$fundyear,$slevel){
 
    // select query
    

    $tblprfx="d" ; 
    $query = "select 
    ifnull(sum(a.grossamount),0) total_utils
      from  mooedisbursements a inner join 
     funds b on a.fundguid=b.fundguid and b.fundyear=:fundyear inner join 
     papcodes c on b.paps=c.papguid  inner join
     schools ds  on ds.schguid=a.schguid
     where ds.schdivid=:schdivid and c.fundassignment=:slevel";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    // $this->bind($stmt);
    $stmt->bindParam(":fundyear",$fundyear); 
    $stmt->bindParam(":schdivid", $schdivid); 
    $stmt->bindParam(":slevel", $slevel); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}


public function genCOOEMain(){
 
    // select query
    

    $tblprfx="d" ; 
    $query = "select sr.schregdescription schdescription, '' schoolid , 
                case 
                    when isnull(p.fundassignment) then 'Others'
                    else p.fundassignment
                end slevel ,
                sr.schregid, 
                
                0
                
                total_utils

            from mooedisbursements d inner join 
                funds f on d.fundguid=f.fundguid and f.fundyear=:fundyear inner join 
                papcodes p on f.paps=p.papguid  inner join
                schools s on d.schguid=s.schguid inner join
                schooldivisions sd on s.schdivid = s.schdivid inner join 
                schoolregions sr on sd.schregid = sr.schregid
                

            group by 1,2 ,3 ,4
            order by 3,1 ";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    // $this->bind($stmt);
    $stmt->bindParam(":fundyear", $this->properties["fundyear"]); 
    // $stmt->bindParam(":schregid", $this->properties["schregid"]); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}

public function genCOOEDetails($schregid,$fundyear,$slevel){
 
    // select query
    

    $tblprfx="d" ; 
    $query = "select v.schregid, 
                o.coacode, 
                o.coadesc, 
                case 
                    when isnull(p.fundassignment) then 'Others'
                    else p.fundassignment
                end slevel ,
                
                sum(d.grossamount) total_utils

            from mooedisbursements d inner join 
                funds f on d.fundguid=f.fundguid and f.fundyear=:fundyear inner join 
                papcodes p on f.paps=p.papguid  inner join 
                ct_chartofacc o on d.coaguid=o.coaguid inner join
                schools s on d.schguid=s.schguid inner join 
                schooldivisions v on v.schdivid=s.schdivid
                
            where v.schregid=:schregid and p.fundassignment=:slevel

            group by 1,2 ,3 ,4
            order by 2,1

";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    // $this->bind($stmt);
    $stmt->bindParam(":fundyear",$fundyear); 
    $stmt->bindParam(":schregid", $schregid); 
    $stmt->bindParam(":slevel", $slevel); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}
public function genCOOEDivTotalUtils($schregid,$fundyear,$slevel){
 
    // select query
    

    $tblprfx="d" ; 
    $query = "select 
    ifnull(sum(a.grossamount),0) total_utils
      from  mooedisbursements a inner join 
     funds b on a.fundguid=b.fundguid and b.fundyear=:fundyear inner join 
     papcodes c on b.paps=c.papguid  inner join
     schools ds  on ds.schguid=a.schguid inner join 
     schooldivisions v on v.schdivid=ds.schdivid
     where v.schregid=:schregid and c.fundassignment=:slevel";
       
        ; //modify to show only unfinalized months
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    // $this->bind($stmt);
    $stmt->bindParam(":fundyear",$fundyear); 
    $stmt->bindParam(":schregid", $schregid); 
    $stmt->bindParam(":slevel", $slevel); 
    // $stmt->bindParam(":dismonth", $this->properties["dismonth"]); 
    // $stmt->bindParam(":schdivid", $this->properties["schdivid"]); 
    
    // $stmt->bindParam(":schguid", $this->properties["schguid"]); 
    // bind variable values

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}


}
