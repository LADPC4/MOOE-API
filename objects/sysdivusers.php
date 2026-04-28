<?php

/**
 * sysdivusers.class.php
 * 
 **/
class sysdivusers {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "sysdivusers";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('ggmid'=>'ggmid');
	private $FIELD_NAME = array('ggmid'=>'ggmid',  'gdivision'=>'gdivision', 'gsysuserid'=>'gsysuserid', 'gsysrole'=>'gsysrole', 'gstatus'=>'gstatus', 'gschool'=>'gschool', 'cluster'=>'cluster','schregid'=>'schregid',  'gtimestamp'=>'gtimestamp','ES'=>'ES','JHS'=>'JHS','SHS'=>'SHS');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //ggmid, gdivision, gsysuserid, gsysrole, gtimestamp, gstatus, gschool

	// protected $fundguid = null;
	// protected $gdivision = null;
	// protected $divguid = null;
    // protected $schoolguid = null;
    // protected $gsysrole = null;
	// protected $gstatus = null;
	// protected $gschool = null;
    // protected $fundyear = null;
    // protected $mooerequest = null;
    // protected $userguid = null;
    // protected $gtimestamp = null;

    protected $properties =array();

    
    


	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        
    }

    //set property 

    public function set_property($pName, $pArg='0') {
        //chek if array exists 

        if (is_array($pArg)){
			$this->properties[$pName]="Y"; $this->FIELD_MODIFIED[$pName]=1;
		}


        if (isset($this->properties[$pName])) {
            $this->properties[$pName]=$pArg;
        } else {
            $newprop=array($pName=>$pArg);
            $this->properties=array_merge($this->properties,$newprop);
        }	
	}
    public function get_property($pName) { 
        if ($pName=="gstatus") {
            $value=array("on"); 
            return (array) $value; 
        } else {
            return (string) $this->properties[$pName]; 
        }
        
        
    }


	// public function set_fundguid($pArg='0') {
	// 	IF ( $this->fundguid !== $pArg){
	// 		$this->fundguid=$pArg; $this->FIELD_MODIFIED['fundguid']=1;
	// 	}
	// }
	// public function set_gdivision($pArg='0') {
	// 	IF ( $this->gdivision !== $pArg){
	// 		$this->gdivision=$pArg; $this->FIELD_MODIFIED['gdivision']=1;
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
    // public function set_gsysrole($pArg='0') {
	// 	IF ( $this->gsysrole !== $pArg){
	// 		$this->gsysrole=$pArg; $this->FIELD_MODIFIED['gsysrole']=1;
	// 	}
	// }
	// public function set_gstatus($pArg='0') {
	// 	IF ( $this->gstatus !== $pArg){
	// 		$this->gstatus=$pArg; $this->FIELD_MODIFIED['gstatus']=1;
	// 	}
	// }
	// public function set_gschool($pArg='0') {
	// 	IF ( $this->gschool !== $pArg){
	// 		$this->gschool=$pArg; $this->FIELD_MODIFIED['gschool']=1;
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
    
	// public function get_fundguid() { return (string) $this->fundguid; }
	// public function get_gdivision() { return (string) $this->gdivision; }
	// public function get_divguid() { return (string) $this->divguid; }
    // public function get_schoolguid() { return (string) $this->schoolguid; }
    // public function get_gsysrole() { return (string) $this->gsysrole; }
	// public function get_gstatus() { return (string) $this->gstatus; }
	// public function get_gschool() { return (string) $this->divguid; }
	// public function get_fundyear() { return (string) $this->fundyear; }
    // public function get_mooerequest() { return (string) $this->mooerequest; }
    // public function get_userguid() { return (string) $this->userguid; }
    // public function get_gtimestamp() { return (string) $this->gtimestamp; }
    

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

function createIDQry(){
    $arr=$this->PRIMARY_KEY;
    $fld_list="";
    $fistitem=1;
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
        // echo $key ;
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
    $query = "delete from 
                " . $this->table_name . "
           
            WHERE
                fundguid = :fundguid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   
    $stmt->bindParam(":fundguid", $this->fundguid);

 
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
                    ,c.roledescription, ifnull(schdescription,'') schdescription
                    ,f.divdescription, g.schregdescription
                    , CONCAT( e.glastname, ', ' , e.gfirstname) fullname
                    ,d.schguid, a.ES,a.JHS,a.SHS , f.schdivid, e.gemail
            
                    
                FROM
                    " . $this->table_name . " " . $tblprfx ." inner join 
                    sysrolehierarchy b on a.gsysrole = b.childroleguid  inner join 
                    sysroles c on a.gsysrole = c.roleguid left join 
                    schools d on a.gschool=d.schguid inner join 
                    sysusers e on a.gsysuserid=e.guserid left join 
                    schooldivisions f on a.gdivision = f.schdivid left join 
                    schoolregions g on a.schregid=g.schregid
                    
                WHERE ".$this->createIDQry($tblprfx);
    
        // prepare query statement
        
        $stmt = $this->conn->prepare( $query );
        // echo $query;
        // bind id of product to be updated
    
        $this->bindID($stmt);
        // execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //  print_r($row);
        if ($row["gstatus"]=="Y") {
            $row["gstatus"]=array("on");
        } 
        if ($row["cluster"]=="Y") {
            $row["cluster"]=array("on");
        } 
        if ($row["ES"]=="Y") {
            $row["ES"]=array("on");
        }
        if ($row["JHS"]=="Y") {
            $row["JHS"]=array("on");
        } 
        if ($row["SHS"]=="Y") {
            $row["SHS"]=array("on");
        }
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;
        

   }
   

    // read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
            // select query
            
            
            $tblprfx="a" ; 

            $where=$this->createWhereQry( $tblprfx);

            if ($where!="") $where=$where." and ";
            $searchname="";
            if ($this->get_property("searchname")!="") {
                $searchname=" and (e.glastname like :searchname or  e.gfirstname like :searchname) ";
            }

            $query = "select a.ggmid, a.gsysuserid, a.gsysrole, CONCAT( e.glastname, ', ' , e.gfirstname) fullname, 
                        a.gtimestamp, a.gstatus, a.gschool,
                        c.roledescription, 
                        -- ifnull(schdescription,'') schdescription,
                        f.divdescription
                from  sysdivusers a inner join 
                    sysrolehierarchy b on a.gsysrole = b.childroleguid  inner join 
                    sysroles c on a.gsysrole = c.roleguid 
                    -- left join 
                    -- schools d on a.gschool=d.schguid 
                    inner join 
                    sysusers e on a.gsysuserid=e.guserid left join 
                    schooldivisions f on a.gdivision = f.schdivid
                where  ".$where."  b.roleguid = :roleguid ".$searchname."
                order by a.gtimestamp desc, a.gstatus asc
                LIMIT :L1, :L2 ";
            // echo $query;
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
            // bind query parameters

            $this->bind($stmt);
            $role=$this->get_property("roleguid");
            $stmt->bindParam(":roleguid", $role , PDO::PARAM_STR);
            if ($this->get_property("searchname")!="") {
                $searchval="%".$this->get_property("searchname")."%";
                $stmt->bindParam(":searchname", $searchval , PDO::PARAM_STR);
            }
            // bind variable values
            $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
        
            // execute query
            $stmt->execute();
            // echo "test";
            // exit;
            // return values from database
            return $stmt;
    }
    
    public function readRecords($from_record_num, $records_per_page){
 
        // select query
        
        $searchname="";
        if ($this->get_property("searchname")!="") {
            $searchname=" and (d.glastname like :searchname or  d.gfirstname like :searchname) ";
        }
        
        $tblprfx="a" ; 
        $query = "SELECT  "  
                   .$this->createSelFlds($tblprfx) . "
                   ,d.glastname, d.gfirstname
            FROM
                "  .$this->table_name . " " . $tblprfx ." inner join 
                sysusers d on a.gsysuserid=d.guserid 
                
                
            WHERE ".$this->createWhereQry( $tblprfx)." and a.cluster='Y' ".$searchname."
            order by a.gtimestamp desc
            LIMIT :L1, :L2";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        $this->bind($stmt);
        // bind variable values
        if ($this->get_property("searchname")!="") {
            $searchval="%".$this->get_property("searchname")."%";
            $stmt->bindParam(":searchname", $searchval , PDO::PARAM_STR);
        }
        $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
}
// used for paging user
public function count(){
    $searchname="";
    if ($this->get_property("searchname")!="") {
        $searchname=" and  (e.glastname like :searchname or  e.gfirstname like :searchname) ";
    }

    $query = "SELECT COUNT(*) as total_rows 
              
              from  sysdivusers a inner join 
              sysrolehierarchy b on a.gsysrole = b.childroleguid  inner join 
              sysroles c on a.gsysrole = c.roleguid 
              -- left join 
              -- schools d on a.gschool=d.schguid 
              inner join 
              sysusers e on a.gsysuserid=e.guserid inner join 
              schooldivisions f on a.gdivision = f.schdivid 
              where  b.roleguid = :roleguid  ".$searchname;

    $stmt = $this->conn->prepare( $query );
    // echo $query;
    $role=$this->get_property("roleguid");
    $stmt->bindParam(":roleguid", $role , PDO::PARAM_STR);
    if ($this->get_property("searchname")!="") {
        $searchval="%".$this->get_property("searchname")."%";
        $stmt->bindParam(":searchname", $searchval , PDO::PARAM_STR);
    }

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function Recordscount(){
    
    $tblprfx="a";
    $query = "SELECT COUNT(*) as total_rows 
              
              FROM
                "  .$this->table_name . " " . $tblprfx ." inner join 
                sysusers d on a.gsysuserid=d.guserid 
                
                
            WHERE a.cluster='Y'
           
           ";

    $stmt = $this->conn->prepare( $query );
    // echo $query;  
    // $role=$this->get_property("roleguid");
    // $stmt->bindParam(":roleguid", $role , PDO::PARAM_STR);
    // if ($this->get_property("searchname")!="") {
    //     $searchval="%".$this->get_property("searchname")."%";
    //     $stmt->bindParam(":searchname", $searchval , PDO::PARAM_STR);
    // }

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
    $this->fundguid= $row['fundguid'];
    $this->schoolguid= $row['schoolguid'];
    $this->gdivision= $row['gdivision'];
    $this->divguid= $row['divguid'];
    $this->gtimestamp= $row['gtimestamp'];
   }
   
   function getapprovers($roletype,$rolegroup){


    // print_r($this);
    $guser=$this->get_property("gsysuserid");
    $filter="";
    switch ($rolegroup) {
        case "R":
            if (($roletype=="R") || ($roletype=="O")){
                $filter="";
            } else {
                $filter=" and sd.schregid=sd2.schregid";
            }
            break;
        case "D":
            if ($roletype=="D") {
                $filter=" and sd.schregid=sd2.schregid";
            } else {
                $filter=" and sd.gdivision=sd2.gdivision ";
            }
            break;
        case "S":
            if ($roletype=="S") {
                $filter=" and sd.gdivision=sd2.gdivision";
            } else {
                $filter=" and sd.gschool=sd2.gschool ";
            }
            break;
    }
    $query="
        select 
        su2.gemail, concat(su2.gfirstname, ' ' , su2.gmiddlename, ' ' ,su2.glastname) Contact_Name
        from sysusers su inner join 
        sysdivusers sd on su.guserid=sd.gsysuserid  inner join 
        sysroles sr on sd.gsysrole=sr.roleguid inner join 
        sysrolehierarchy sh on sr.roleguid=sh.childroleguid inner join 
        sysdivusers sd2 on sh.roleguid=sd2.gsysrole  join  
        sysusers su2 on sd2.gsysuserid=su2.guserid and su.guserid<>su2.guserid
        
        where su.guserid = :guserid ".$filter;
    // echo $query;
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
   
    $stmt->bindParam(":guserid", $guser);
    // execute query
    $stmt->execute();
    return $stmt;

   }
           

}
