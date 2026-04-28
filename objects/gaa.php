<?php

/**
 * fileuploads.class.php
 * 
 **/
include_once '../objects/baseclass.php';
class gaa extends baseclass {

	//Create Connection property
	protected $conn;
	//declare table name
    protected $table_name = "gaallocation";
	//auto generated atc, , , , , , , , ,
    public $lasterror=null;
    private $rpquery="";
	protected  $PRIMARY_KEY = array('gaaid'=>'gaaid');
	protected $FIELD_NAME = array('atc'=>'atc','gaayear'=>'gaayear',
								'schguid'=>'schguid',
								'gaatotal'=>'gaatotal',
								'gaaes'=>'gaaes',
								'gaajhs'=>'gaajhs',
								'gaashs'=>'gaashs',
								'rectimestamp'=>'rectimestamp');

    


	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        
    }
	public function importgaa($fundyear){

		$query="
		delete  from gaallocation 
		where gaayear = ".$fundyear."; 
		
		insert into gaallocation
		(gaayear, schguid, gaatotal, gaaes, gaajhs, gaashs)
		
		select ".$fundyear." ,  schguid, total gaatotal, i.es gaaes, i.hs gaajhs, i.shs gaashs
		from import".$fundyear." i inner join 
			 schools s on i.SCHOOLID = s.schoolid ;

		delete from funds where fundyear= ".$fundyear.";

		-- Transfer  IU
		-- ES	
		insert into funds (schdivid,schguid,paps,totalamount,transferdate,fundyear,schacctguid)

		select b.schdivid, a.schguid,
		(select papguid from papcodes p where p.regmooe='Y' and p.es='Y')
		'paps',
		a.gaaes, current_date, a.gaayear , c.ejsguid schacctguid
		from gaallocation a inner join
		schools b on a.schguid=b.schguid and b.schtype='IU' and a.gaajhs>0 left join 
		-- funds d on b.schguid=d.schguid left join 
		schacctejs c on b.schguid = c.schdivguid and c.es='Y' 

		where a.gaayear=".$fundyear."; 
		-- JHS	
		insert into funds (schdivid,schguid,paps,totalamount,transferdate,fundyear,schacctguid)

		select b.schdivid, a.schguid,
		(select papguid from papcodes p where p.regmooe='Y' and p.jhs='Y')
		'paps',
		a.gaajhs, current_date, a.gaayear , c.ejsguid schacctguid
		from gaallocation a inner join
		schools b on a.schguid=b.schguid and b.schtype='IU' and a.gaajhs>0 left join 
		-- funds d on b.schguid=d.schguid left join 
		schacctejs c on b.schguid = c.schdivguid and c.jhs='Y' 

		where a.gaayear=".$fundyear."; 
		-- SHS	
		insert into funds (schdivid,schguid,paps,totalamount,transferdate,fundyear,schacctguid)

		select b.schdivid, a.schguid,
		(select papguid from papcodes p where p.regmooe='Y' and p.shs='Y')
		'paps',
		a.gaashs, current_date, a.gaayear , c.ejsguid schacctguid
		from gaallocation a inner join
		schools b on a.schguid=b.schguid and b.schtype='IU' and a.gaajhs>0 left join 
		-- funds d on b.schguid=d.schguid left join 
		schacctejs c on b.schguid = c.schdivguid and c.shs='Y' 

		where a.gaayear=".$fundyear."; 

		";

		$stmt = $this->conn->prepare($query);
	 
		// sanitize
			//$this->guserid=htmlspecialchars(strip_tags($this->guserid));
		
		// bind values
		
		//$stmt->bindParam(1, $filename);
		
	
	 
		// execute query
		if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
			return true;
		}
		$this->lasterror=implode(" ",$stmt->errorInfo());
		return false;
	}


           

}
