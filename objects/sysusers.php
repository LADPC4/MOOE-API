<?php

/**
 * sysusers.class.php
 * 
 **/
class sysusers {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "sysusers";
	//auto generated

	//public static $DATABASE_NAME = 'goodbet';
	//public static $TABLE_NAME = 'sysusers';

    public $lasterror="";
    public $trtype="";
	public static $PRIMARY_KEY = array('guserid'=>'guserid');
	private $FIELD_NAME=array('guserid'=>'guserid','gusername'=>'gusername','gpassword'=>'gpassword','glastname'=>'glastname','gfirstname'=>'gfirstname','gmiddlename'=>'gmiddlename','gemail'=>'gemail','gmobile'=>'gmobile','gfbid'=>'gfbid','ggoogleid'=>'ggoogleid','gaddress1'=>'gaddress1','gaddress2'=>'gaddress2','gcountry'=>'gcountry','gtimestamp'=>'gtimestamp','credits'=>'credits');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();


	protected $guserid = null;
	protected $gusername = null;
	protected $gpassword = null;
	protected $glastname = null;
	protected $gfirstname = null;
	protected $gmiddlename = null;
	protected $gemail = null;
	protected $gmobile = null;
    protected $gfbid = null;
    protected $ggoogleid = null;
    
	protected $gaddress1 = null;
	protected $gaddress2 = null;
	protected $gcountry = null;
	protected $gtimestamp = null;
	protected $credits = null;
    protected $gaudituserid = null;
    protected $schguid = null;
    
	protected $divcode = null;
    protected $schdivid = null;
    protected $roletype = null;
    protected $rolegroup = null;
    protected $roleguid = null;
    protected $gstatus = null;
    protected $schtype = null;
    protected $roledescription = null;
   
    


	// constructor with $db as database connection
    	public function __construct($db){
        	$this->conn = $db;
         
    	}


	//Setters

	public function set_guserid($pArg='0') {
		IF ( $this->guserid !== $pArg){
			$this->guserid=$pArg; $this->FIELD_MODIFIED['guserid']=1;
		}
	}
	public function set_gusername($pArg='0') {
		IF ( $this->gusername !== $pArg){
			$this->gusername=$pArg; $this->FIELD_MODIFIED['gusername']=1;
		}
	}
	public function set_gpassword($pArg='0') {
		IF ( $this->gpassword !== $pArg){
			$this->gpassword=$pArg; $this->FIELD_MODIFIED['gpassword']=1;
		}
	}
	public function set_glastname($pArg='0') {
		IF ( $this->glastname !== $pArg){
			$this->glastname=$pArg; $this->FIELD_MODIFIED['glastname']=1;
		}
	}
	public function set_gfirstname($pArg='0') {
		IF ( $this->gfirstname !== $pArg){
			$this->gfirstname=$pArg; $this->FIELD_MODIFIED['gfirstname']=1;
		}
	}
	public function set_gmiddlename($pArg='0') {
		IF ( $this->gmiddlename !== $pArg){
			$this->gmiddlename=$pArg; $this->FIELD_MODIFIED['gmiddlename']=1;
		}
	}
	public function set_gemail($pArg='0') {
		IF ( $this->gemail !== $pArg){
			$this->gemail=$pArg; $this->FIELD_MODIFIED['gemail']=1;
		}
	}
	public function set_gmobile($pArg='0') {
		IF ( $this->gmobile !== $pArg){
			$this->gmobile=$pArg; $this->FIELD_MODIFIED['gmobile']=1;
		}
	}
	public function set_gfbid($pArg='0') {
		IF ( $this->gfbid !== $pArg){
			$this->gfbid=$pArg; $this->FIELD_MODIFIED['gfbid']=1;
		}
    }
    public function set_ggoogleid($pArg='0') {
		IF ( $this->ggoogleid !== $pArg){
			$this->ggoogleid=$pArg; $this->FIELD_MODIFIED['ggoogleid']=1;
		}
	}
	public function set_gaddress1($pArg='0') {
		IF ( $this->gaddress1 !== $pArg){
			$this->gaddress1=$pArg; $this->FIELD_MODIFIED['gaddress1']=1;
		}
	}
	public function set_gaddress2($pArg='0') {
		IF ( $this->gaddress2 !== $pArg){
			$this->gaddress2=$pArg; $this->FIELD_MODIFIED['gaddress2']=1;
		}
	}
	public function set_gcountry($pArg='0') {
		IF ( $this->gcountry !== $pArg){
			$this->gcountry=$pArg; $this->FIELD_MODIFIED['gcountry']=1;
		}
	}
	public function set_gtimestamp($pArg='0') {
		IF ( $this->gtimestamp !== $pArg){
			$this->gtimestamp=$pArg; $this->FIELD_MODIFIED['gtimestamp']=1;
		}
    }
	public function set_divcode($pArg='0') {
		IF ( $this->divcode !== $pArg){
			$this->divcode=$pArg; $this->FIELD_MODIFIED['divcode']=1;
		}
	}
	public function set_schdivid($pArg='0') {
		IF ( $this->schdivid !== $pArg){
			$this->schdivid=$pArg; $this->FIELD_MODIFIED['schdivid']=1;
		}
    }
    public function set_divdescription($pArg='0') {
		IF ( $this->divdescription !== $pArg){
			$this->divdescription=$pArg; $this->FIELD_MODIFIED['divdescription']=1;
		}
    }

   
    public function set_roletype($pArg='0') {
		IF ( $this->roletype !== $pArg){
			$this->roletype=$pArg; $this->FIELD_MODIFIED['roletype']=1;
		}
    }
    public function set_rolegroup($pArg='0') {
		IF ( $this->rolegroup !== $pArg){
			$this->rolegroup=$pArg; $this->FIELD_MODIFIED['rolegroup']=1;
		}
    }
    public function set_roleguid($pArg='0') {
		IF ( $this->roleguid !== $pArg){
			$this->roleguid=$pArg; $this->FIELD_MODIFIED['roleguid']=1;
		}
    }
    
    public function set_gstatus($pArg='0') {
		IF ( $this->gstatus !== $pArg){
			$this->gstatus=$pArg; $this->FIELD_MODIFIED['gstatus']=1;
		}
    }
    public function set_roledescription($pArg='0') {
		IF ( $this->roledescription !== $pArg){
			$this->roledescription=$pArg; $this->FIELD_MODIFIED['roledescription']=1;
		}
    }
    
    public function set_schdescription($pArg='0') {
        IF ( $this->schdescription !== $pArg){
            $this->schdescription=$pArg; $this->FIELD_MODIFIED['schdescription']=1;
        }
    }
    public function set_schoolid($pArg='0') {
        IF ( $this->schoolid !== $pArg){
            $this->schoolid=$pArg; $this->FIELD_MODIFIED['schoolid']=1;
        }
    }
    public function set_schguid($pArg='0') {
        IF ( $this->schguid !== $pArg){
            $this->schguid=$pArg; $this->FIELD_MODIFIED['schguid']=1;
        }
    }
    
    public function set_schaddress($pArg='0') {
        IF ( $this->schaddress !== $pArg){
            $this->schaddress=$pArg; $this->FIELD_MODIFIED['schaddress']=1;
        }
    }
    public function set_schtype($pArg='0') {
        IF ( $this->schtype !== $pArg){
            $this->schtype=$pArg; $this->FIELD_MODIFIED['schtype']=1;
        }
    }
    
    public function set_schpayee($pArg='0') {
        IF ( $this->schpayee !== $pArg){
            $this->schpayee=$pArg; $this->FIELD_MODIFIED['schpayee']=1;
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
    public function set_schregid($pArg='0') {
        IF ( $this->schregid !== $pArg){
            $this->schregid=$pArg; $this->FIELD_MODIFIED['schregid']=1;
        }
    }
    public function set_schregdescription($pArg='0') {
        IF ( $this->schregdescription !== $pArg){
            $this->schregdescription=$pArg; $this->FIELD_MODIFIED['schregdescription']=1;
        }
    }

	//Getters
	public function get_guserid() { return (string) $this->guserid; }
	public function get_gusername() { return (string) $this->gusername; }
	public function get_gpassword() { return (string) $this->gpassword; }
	public function get_glastname() { return (string) $this->glastname; }
	public function get_gfirstname() { return (string) $this->gfirstname; }
	public function get_gmiddlename() { return (string) $this->gmiddlename; }
	public function get_gemail() { return (string) $this->gemail; }
	public function get_gmobile() { return (string) $this->gmobile; }
    public function get_gfbid() { return (string) $this->gfbid; }
    public function get_ggoogleid() { return (string) $this->ggoogleid; }
	public function get_gaddress1() { return (string) $this->gaddress1; }
	public function get_gaddress2() { return (string) $this->gaddress2; }
	public function get_gcountry() { return (string) $this->gcountry; }
	public function get_gtimestamp() { return (string) $this->gtimestamp; }
	public function get_credits() { return (string) $this->credits; }
    public function get_gaudituserid() { return (string) $this->gaudituserid; }
    public function get_divcode() { return (string) $this->divcode; }
    public function get_schdivid() { return (string) $this->schdivid; }
    public function get_divdescription() { return (string) $this->divdescription; } 
    public function get_ghouseplayer() { return (string) $this->ghouseplayer; }
    public function get_roletype() { return (string) $this->roletype; }
    public function get_rolegroup() { return (string) $this->rolegroup; }
    public function get_roleguid() { return (string) $this->roleguid; }
    public function get_gstatus() { return (string) $this->gstatus; }
    public function get_roledescription() { return (string) $this->roledescription; }

    public function get_schdescription() { return (string) $this->schdescription; } 
    public function get_schoolid() { return (string) $this->schoolid; }
    public function get_schguid() { return (string) $this->schguid; }
    public function get_schaddress() { return (string) $this->schaddress; }
    public function get_schpayee() { return (string) $this->schpayee; } 
    public function get_schaccount() { return (string) $this->schaccount; } 
    public function get_schtype() { return (string) $this->schtype; }  
    public function get_schbank() { return (string) $this->schbank; } 

    public function get_schregid() { return (string) $this->schregid; } 
    public function get_schregdescription() { return (string) $this->schregdescription; } 

    public function get_ES() { return (string) $this->ES; }
    public function get_JHS() { return (string) $this->JHS; }
    public function get_SHS() { return (string) $this->SHS; }
    

    // public function get_genablehousebet() { return (string) $this->genablehousebet; }
    // public function get_genableparlay() { return (string) $this->genableparlay ; }
    // public function get_gparlayminbet() { return (string) $this->gparlayminbet ; }
    // public function get_gparlaymaxbet() { return (string) $this->gparlaymaxbet ; }
    // public function get_gparlayminwager() { return (string) $this->gparlayminwager ; }
    // public function get_gparlaymaxwager() { return (string) $this->gparlaymaxwager ; }
    // public function get_gparlaypushmuliplier () { return (string) $this->gparlaypushmuliplier ; }
    

//Sanitize 
function sanitize(){
     $this->gusername=htmlspecialchars(strip_tags($this->gusername));
	$this->gpassword=htmlspecialchars(strip_tags($this->gpassword));
	$this->glastname=htmlspecialchars(strip_tags($this->glastname));
	$this->gfirstname=htmlspecialchars(strip_tags($this->gfirstname));
	$this->gmiddlename=htmlspecialchars(strip_tags($this->gmiddlename));
	$this->gemail=htmlspecialchars(strip_tags($this->gemail));
	$this->gmobile=htmlspecialchars(strip_tags($this->gmobile));
    $this->gfbid=htmlspecialchars(strip_tags($this->gfbid));
    $this->ggoogleid=htmlspecialchars(strip_tags($this->ggoogleid));
    
	$this->gaddress1=htmlspecialchars(strip_tags($this->gaddress1));
	$this->gaddress2=htmlspecialchars(strip_tags($this->gaddress2));
	$this->gcountry=htmlspecialchars(strip_tags($this->gcountry));
}
//Bind
function bind(&$stmt){
   if ($this->guserid!=""){
   	$stmt->bindParam(":guserid", $this->guserid); 
   }
   if ($this->gusername!=""){
   	$stmt->bindParam(":gusername", $this->gusername);
   }
    
$stmt->bindParam(":gpassword", $this->gpassword); 
$stmt->bindParam(":glastname", $this->glastname); 
$stmt->bindParam(":gfirstname", $this->gfirstname); 
$stmt->bindParam(":gmiddlename", $this->gmiddlename); 
$stmt->bindParam(":gemail", $this->gemail); 
$stmt->bindParam(":gmobile", $this->gmobile); 
$stmt->bindParam(":gfbid", $this->gfbid); 
$stmt->bindParam(":ggoogleid", $this->ggoogleid); 

$stmt->bindParam(":gaddress1", $this->gaddress1);
$stmt->bindParam(":gaddress2", $this->gaddress2); 
$stmt->bindParam(":gcountry", $this->gcountry); 


}
//BindID
function bindID(&$stmt){
   $stmt->bindParam(":guserid", $this->guserid);
}
     //sign in 
function signin(){
 // query to check if account exists
    $query = "SELECT  COUNT(*) as total_rows 
    
    FROM
    " . $this->table_name . " 
    
    WHERE
    ggoogleid = :ggoogleid
    LIMIT
    0,1";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(":ggoogleid", $this->ggoogleid);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['total_rows']==0) {

            $this->create();
            //get guserid and fetch data
            return $this->GetUserData();
        } else {
            return $this->GetUserData();
        }
}

	//create user
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                gusername=:gusername,gpassword=:gpassword,glastname=:glastname,gfirstname=:gfirstname,
                gmiddlename=:gmiddlename,gemail=:gemail,gmobile=:gmobile,gfbid=:gfbid,ggoogleid=:ggoogleid,
		gaddress1=:gaddress1,gaddress2=:gaddress2,gcountry=:gcountry";
 
    // prepare query
    $stmt = $this->conn->prepare($query);

 //echo json_encode($stmt);
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

//update 
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                gpassword=:gpassword,glastname=:glastname,gfirstname=:gfirstname,
                gmiddlename=:gmiddlename,gemail=:gemail,gmobile=:gmobile,gfbid=:gfbid,
		gaddress1=:gaddress1,gaddress2=:gaddress2,gcountry=:gcountry
            WHERE
                guserid = :guserid";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->sanitize();
    try {
        // bind values
        $this->bind($stmt);
        
    
        // execute query
        if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
            return true;
        }
        //print_r($stmt->errorInfo());
        $this->lasterror=implode(" ",$stmt->errorInfo());
        return false;
    }  catch(PDOException $e)     {
         // roll back the transaction if something failed
        // print_r( $e);
        
         $this->lasterror=$e->getMessage();
         return false;  
         
    }
    
     
   }

//delete 
function delete(){
 
    // update query
    $query = "delete from 
                " . $this->table_name . "
           
            WHERE
                guserid = :guserid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
   $this->bindID($stmt);


 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }

   //Read One 
function GetUserData(){
 
    // query to read single record
    $query = "select guserid, gusername, gpassword, glastname, gfirstname, gmiddlename, 
                gemail, gmobile, gfbid,ggoogleid, gaddress1, gaddress2, gcountry, 
                a.gtimestamp, 
                c.divcode,c.schdivid, c.divdescription , 
                d.roletype, b.gstatus ,
                d.roledescription, 
                e.schdescription, e.schoolid, e.schguid, e.schaddress,
                e.schpayee, e.schaccount, e.schbank, 
                f.schregid,f.schregdescription,
                d.roleguid, d.rolegroup, e.schtype, 
                b.ES,b.JHS,b.SHS

            from sysusers a 
            left join sysdivusers b on a.guserid=b.gsysuserid 
            left join schooldivisions c on b.gdivision = c.schdivid 
            left join sysroles d on b.gsysrole = d.roleguid
            left join schools e on b.gschool = e.schguid
            left join schoolregions f on (c.schregid = f.schregid or b.schregid = f.schregid  )
                    
            WHERE
                ggoogleid = :ggoogleid
            LIMIT
                0,1";
   
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(":ggoogleid", $this->ggoogleid);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->guserid= $row['guserid'];
    $this->gusername= $row['gusername'];
    $this->gpassword= $row['gpassword'];
    $this->glastname= $row['glastname'];
    $this->gfirstname= $row['gfirstname'];
    $this->gmiddlename= $row['gmiddlename'];
    $this->gemail= $row['gemail'];
    $this->gmobile= $row['gmobile'];
    $this->gfbid= $row['gfbid'];
    $this->ggoogleid= $row['ggoogleid'];
    $this->gaddress1= $row['gaddress1'];
    $this->gaddress2= $row['gaddress2'];
    $this->gcountry= $row['gcountry'];
    $this->gtimestamp= $row['gtimestamp'];
    
    $this->divcode= $row['divcode'];
    $this->schdivid= $row['schdivid'];
    $this->divdescription= $row['divdescription'];
    
    $this->roletype= $row['roletype'];
    $this->rolegroup= $row['rolegroup'];
    $this->roleguid= $row['roleguid'];
    $this->gstatus= $row['gstatus'];
    $this->roledescription= $row['roledescription'];


    $this->schdescription= $row['schdescription']; 
    $this->schoolid= $row['schoolid'];
    $this->schtype= $row['schtype'];
    $this->schguid= $row['schguid'];
    $this->schaddress= $row['schaddress'];
    $this->schpayee= $row['schpayee']; 
    $this->schaccount= $row['schaccount']; 
    $this->schbank= $row['schbank'];

    $this->schregid= $row['schregid'];
    $this->schregdescription= $row['schregdescription'];

    $this->ES= $row['ES'];
    $this->JHS= $row['JHS'];
    $this->SHS= $row['SHS'];
   
   
    // print_r($this);s
    return true;
   }

   
//Read One 
function readOne(){
 
    // query to read single record
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name . " 
                
            WHERE
                guserid = :guserid or gemail= :gemail
            LIMIT
                0,1";
   
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(":guserid", $this->guserid);
    $stmt->bindParam(":gemail", $this->guserid);
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->guserid= $row['guserid'];
    $this->gusername= $row['gusername'];
    $this->gpassword= $row['gpassword'];
    $this->glastname= $row['glastname'];
    $this->gfirstname= $row['gfirstname'];
    $this->gmiddlename= $row['gmiddlename'];
    $this->gemail= $row['gemail'];
    $this->gmobile= $row['gmobile'];
    $this->gfbid= $row['gfbid'];
    $this->gaddress1= $row['gaddress1'];
    $this->gaddress2= $row['gaddress2'];
    $this->gcountry= $row['gcountry'];
    $this->gtimestamp= $row['gtimestamp'];
    $this->credits= $row['credits'];
   }


// read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
    // select query
   	
    
    
    $query = "SELECT
                " . implode (', ',  $this->FIELD_NAME ) . "
            FROM
                " . $this->table_name .  " 
                
            ORDER BY gusername  DESC
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


// used for paging user
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

//Transactional Methods

function addcredits(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                credits= ifnull(credits, 0) + :credits
            WHERE
                guserid = :guserid";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->sanitize();
    
    // bind values
    $stmt->bindParam(":credits",$this->credits,PDO::PARAM_STR);
    $stmt->bindParam(":guserid",$this->guserid);
    
 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
	//Add to transaction logs
    	$this->addtotranslog();
        return true;
    }
    //print_r($stmt->errorInfo());
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
    
    
 
   }
function deductcredits(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                credits= ifnull(credits, 0) - :credits
            WHERE
                guserid = :guserid";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->sanitize();
    
    // bind values
    $stmt->bindParam(":credits",$this->credits,PDO::PARAM_STR);
    $stmt->bindParam(":guserid",$this->guserid);
    
 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
	//Add to transaction logs
    	$this->addtotranslog();
        return true;
    }
    //print_r($stmt->errorInfo());
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
    
   }

function addtotranslog(){
 
    // query to insert record
    $query = "INSERT INTO
                gamecredittransactions
            SET
		
                credituser=:guserid,
                gaudituser=:gaudituserid,
                creditamount=:credits,
                gtype=:gtype";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
   
 //echo json_encode($stmt);
    // sanitize
   $this->sanitize();
//    echo "credits: ".$this->trtype;
   $tmpcreds=$this->credits;
   switch ($this->trtype) {
    case "B":
        $tmpcreds=$tmpcreds*-1;
        break;
    case "D":
        $tmpcreds=$tmpcreds*-1;
        break;
    case "R":
        $tmpcreds=$tmpcreds*-1;
        break;
    }
//    if (strpos("BDR",$this->trtype)>=0) {
//     $tmpcreds=$tmpcreds*-1;
//     // $stmt->bindParam(":credits",($this->credits*-1),PDO::PARAM_STR);
//    } else {
//     $tmpcreds=$tmpcreds;
//    }
    // bind values
   
    $stmt->bindParam(":credits",$tmpcreds,PDO::PARAM_STR);
    $stmt->bindParam(":guserid",$this->guserid);
    $stmt->bindParam(":gaudituserid",$this->gaudituserid);
    $stmt->bindParam(":gtype",$this->trtype);



    // execute query
    if($stmt->execute()){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }

}
