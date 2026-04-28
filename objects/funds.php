<?php

/**
 * funds.class.php
 * 
 * 
 **/
class funds {

	//Create Connection property
	private $conn;
	//declare table name
   	private $table_name = "funds";
	//auto generated
    public $lasterror=null;
	public  $PRIMARY_KEY = array('fundguid'=>'fundguid');
	private $FIELD_NAME = array('fundguid'=>'fundguid',  'schdivid'=>'schdivid', 'schguid'=>'schguid', 'paps'=>'paps', 'totalamount'=>'totalamount', 
                                'transferdate'=>'transferdate', 'fundyear'=>'fundyear', 'mooerequest'=>'mooerequest', 'userguid'=>'userguid', 
                                'confirmed'=>'confirmed',  'schregid'=>'schregid', 'cofund'=>'cofund', 'parentfund'=>'parentfund',
                                'parentorg'=>'parentorg',   'rectimestamp'=>'rectimestamp' ,'schacctguid'=>'schacctguid',
                                'ncainfo'=>'ncainfo','ncadate'=>'ncadate');
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();

    //fundguid, fundguid, divguid, schoolguid, paps, totalamount, transferdate, fundyear, mooerequest, rectimestamp

	// protected $fundguid = null;
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


	// public function set_fundguid($pArg='0') {
	// 	IF ( $this->fundguid !== $pArg){
	// 		$this->fundguid=$pArg; $this->FIELD_MODIFIED['fundguid']=1;
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
    
	// public function get_fundguid() { return (string) $this->fundguid; }
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
                ,b.schdescription,c.papsdescription papsdesc, d.fundackid
                ,e.requestid ,  CONCAT(DATE(e.rectimestamp),' | ',c.papsdescription ) reqdesc 
                ,CONCAT(DATE(pf.rectimestamp),' | ',c.papsdescription ) funddesc ,
                CONCAT(ag.schbank, ':', ag.schaccount)  acctdesc
            FROM
                " . $this->table_name . " " . $tblprfx ." inner join 
                schools b on a.schguid=b.schguid inner join 
                papcodes c on a.paps=c.papguid left join 
                fundconfirm d on a.fundguid=d.fundguid left  join
                mooerequests e on a.mooerequest=e.requestid  left join 
                funds pf on a.parentfund=pf.fundguid left join 
                schacctejs ag on a.schacctguid=ag.ejsguid
                
            WHERE ".$this->createIDQry($tblprfx);
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
    // echo $query; 
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
   function readOneDiv(){
 
    // query to read single record
    $tblprfx="a" ; 
    $query = "SELECT
                " . $this->createSelFlds($tblprfx) . "
                ,c.papsdescription papsdesc, d.fundackid
                ,e.requestid ,  CONCAT(DATE(e.rectimestamp),' | ',c.papsdescription ) reqdesc 
                ,CONCAT(DATE(pf.rectimestamp),' | ',c.papsdescription ) funddesc ,
                CONCAT(ag.schbank, ':', ag.schaccount)  acctdesc
            FROM
                " . $this->table_name . " " . $tblprfx ." inner join 
                papcodes c on a.paps=c.papguid left join 
                fundconfirm d on a.fundguid=d.fundguid left  join
                mooerequests e on a.mooerequest=e.requestid  left join 
                funds pf on a.parentfund=pf.fundguid inner join 
                schacctejs ag on a.schacctguid=ag.ejsguid
                
            WHERE ".$this->createIDQry($tblprfx);
 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
    // echo $query; 
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
   //Read Division Dash board 
    function readAllocatedTransferred(){

        // query to read single record
        //  ifnull(ROUND(sum(gaatotal)/1000000,2),0) 
        $tblprfx="a" ; 
        // $query = "select gaayear,c.schdivid,
                        
                       
        //                 (select ifnull(ROUND(sum(gaatotal)/1000000,2),0) 
        //                     from gaallocation a inner join 
        //                         schools b on a.schguid=b.schguid 
        //                     where b.schdivid=:schdivid and  gaayear=:gaayear)
                        
        //                 Allocated, 
        //                 ifnull(ROUND(sum(d.totalamount)/1000000,2),0) Transferred, 
        //                 ifnull(ROUND(((sum(d.totalamount)/sum(gaatotal)) ),2),0) TransferStatus,
        //                 ifnull(ROUND(sum(e.grossamount)/1000000,2),0) Utilized,
        //                 ifnull(ROUND(((sum(e.grossamount)/sum(d.totalamount)) ),2),0) UtilizationStatus,
        //                 ifnull(ROUND(
        //                 sum(case 
        //                           when e.liquidated='y' 
        //                            then e.grossamount 
        //                            else 0 
        //                        end ) /1000000
        //                 ,2),0) Liquidated,
        //                  ifnull(ROUND(
        //                  sum(case 
        //                           when e.liquidated='y' 
        //                            then e.grossamount 
        //                            else 0 
        //                        end ) /1000000
        //                 ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus
                            
        //             from gaallocation a inner join 
        //                 schools b on a.schguid = b.schguid inner join 
        //                 schooldivisions c on b.schdivid = c.schdivid left join 
        //                 funds d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
        //                 mooedisbursements e on d.fundguid = e.fundguid
        //                                 where c.schdivid=:schdivid and gaayear=:gaayear
        //             group by gaayear,c.schdivid";
        $query="select  b.schdivid ,

        round((select sum(gaatotal) 
        from gaallocation ga inner join 
             schools sc on ga.schguid=sc.schguid inner join 
             schooldivisions sd on sc.schdivid=sd.schdivid
         where  gaayear=:gaayear and b.schdivid=sc.schdivid
         )/1000000,2)

       Allocated,
       
       round(( select 
     ifnull(sum(d.totalamount)/1000000,0) 
     from funds d inner join 
          papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
     where d.schdivid=b.schdivid and d.fundyear=:gaayear
	  ),2) 
	  
	  Transferred ,
	  
	  round((select 
     ifnull(sum(e.grossamount),0)/1000000 
     from  mooedisbursements e inner join 
	  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
	  where d.schdivid=b.schdivid
	  ),2)
	  
	  Utilized,
	  
	  round((select 
     ifnull(sum(e.grossamount),0)/1000000 
     from  mooedisbursements e inner join 
	  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y' inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
	  where d.schdivid=b.schdivid
	  ),2)
	  Liquidated 
	  
	  
                  from  schooldivisions b   
							  
                 where b.schdivid=:schdivid
                 
                  limit 0,10";

    
        // prepare query statement
        
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
    
        $gaayear=$this->get_property("gaayear");
        $stmt->bindParam(":gaayear", $gaayear); 
        $this->bind($stmt);
        // execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;
    

   }
   function readRegAllocatedTransferred(){

    // query to read single record
    //ifnull(ROUND(sum(gaatotal)/1000000,2),0) 
    $tblprfx="a" ; 
    // $query = "select gaayear,f.schregid,


                    
    //                 (select ifnull(ROUND(sum(gaatotal)/1000000,2),0) 
    //                 from gaallocation a inner join 
    //                      schools b on a.schguid=b.schguid inner join 
    //                      schooldivisions c on b.schdivid = c.schdivid 
    //                    where c.schregid=:schregid and a.gaayear=:gaayear)
                    
    //                 Allocated, 
    //                 ifnull(ROUND(sum(d.totalamount)/1000000,2),0) Transferred, 
    //                 ifnull(ROUND(((sum(d.totalamount)/sum(gaatotal)) ),2),0) TransferStatus,
    //                 ifnull(ROUND(sum(e.grossamount)/1000000,2),0) Utilized,
    //                 ifnull(ROUND(((sum(e.grossamount)/sum(d.totalamount)) ),2),0) UtilizationStatus,
    //                 ifnull(ROUND(
    //                 sum(case 
    //                           when e.liquidated='y' 
    //                            then e.grossamount 
    //                            else 0 
    //                        end ) /1000000
    //                 ,2),0) Liquidated,
    //                  ifnull(ROUND(
    //                  sum(case 
    //                           when e.liquidated='y' 
    //                            then e.grossamount 
    //                            else 0 
    //                        end ) /1000000
    //                 ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus
                        
    //             from gaallocation a inner join 
    //                 schools b on a.schguid = b.schguid inner join 
    //                 schooldivisions c on b.schdivid = c.schdivid left join 
    //                 funds d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
    //                 mooedisbursements e on d.fundguid = e.fundguid inner join 
    //                 schoolregions f on c.schregid = f.schregid
                    
    //                                 where f.schregid=:schregid and gaayear=:gaayear
    //             group by gaayear,f.schregid";
    $query="select  b.schregid ,

    round((select sum(gaatotal) 
    from gaallocation ga inner join 
         schools sc on ga.schguid=sc.schguid inner join 
         schooldivisions sd on sc.schdivid=sd.schdivid inner join 
         schoolregions sr on sd.schregid=sr.schregid
     where  gaayear=:gaayear and b.schregid=sr.schregid
     )/1000000,2)

   Allocated,
   
   
    round(( select 
 ifnull(sum(d.totalamount)/1000000,0) 
 from funds d inner join 
      schooldivisions sd on d.schdivid=sd.schdivid inner join
      schoolregions sr on sd.schregid=sr.schregid inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
 where sr.schregid=b.schregid and d.fundyear=:gaayear  
 
  ),2) 
  
  Transferred ,
  
   round((select 
 ifnull(sum(e.grossamount),0)/1000000 
 from  mooedisbursements e inner join 
  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear inner join 
      schooldivisions sd on d.schdivid=sd.schdivid inner join
      schoolregions sr on sd.schregid=sr.schregid  inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
  where sr.schregid=b.schregid
  ),2)
  
  Utilized,
  
    round((select 
 ifnull(sum(e.grossamount),0)/1000000 
 from  mooedisbursements e inner join 
  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear inner join 
      schooldivisions sd on d.schdivid=sd.schdivid inner join
      schoolregions sr on sd.schregid=sr.schregid  inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
  where sr.schregid=b.schregid and e.liquidated='Y'
  ),2)
  
  Liquidated 
  
  
              from  schoolregions b   
                          
             where b.schregid=:schregid ";

    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated

    $gaayear=$this->get_property("gaayear");
    $schregid=$this->get_property("schregid");
    $stmt->bindParam(":gaayear", $gaayear); 
    $stmt->bindParam(":schregid", $schregid); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    $item_arr=$row;
    // get retrieved row
    return $item_arr ;


}
// function readTopHighUtils(){

//     // query to read single record

//     // ROUND(sum(ifnull(gaatotal,0))/1000000,2)
   
//     $tblprfx="a" ; 
//     // $query = "select  gaayear,c.schdivid,b.schdescription,

//     //             (select ifnull(ROUND(sum(gaatotal)/1000000,2),0) 
//     //             from gaallocation aa inner join 
//     //                 schools b on aa.schguid=b.schguid inner join 
//     //                 schooldivisions c on b.schdivid = c.schdivid 
//     //             where aa.schguid=a.schguid and a.gaayear=:gaayear)
                
//     //             Allocated, 


//     //             ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
//     //             ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
//     //             ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
//     //             ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
//     //             ,b.schguid,
//     //             ROUND(((sum(ifnull(gaatotal,0)) - sum(ifnull(d.totalamount,0)) ) / sum(ifnull(gaatotal,0))),2) GAABalance,
//     //             ifnull(ROUND((sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)))/sum(ifnull(d.totalamount,0)) ,2),0) FundBalance,
//     //             ifnull(ROUND(
//     //             sum(case 
//     //                       when e.liquidated='y' 
//     //                        then e.grossamount 
//     //                        else 0 
//     //                    end ) /1000000
//     //             ,2),0) Liquidated,
//     //              ifnull(ROUND(
//     //              sum(case 
//     //                       when e.liquidated='y' 
//     //                        then e.grossamount 
//     //                        else 0 
//     //                    end ) /1000000
//     //             ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus

//     //             from gaallocation a inner join 
//     //                 schools b on a.schguid = b.schguid inner join 
//     //                 schooldivisions c on b.schdivid = c.schdivid left join 
//     //                 funds d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
//     //                 mooedisbursements e on d.fundguid = e.fundguid
//     //             where c.schdivid=:schdivid and gaayear=:gaayear
//     //             group by gaayear,c.schdivid,b.schguid
//     //             order by 7 desc  ,schdescription asc 
//     //             limit 0,10";
    
//     $query="select  b.schdivid,b.schdescription,

//     round((select gaatotal 
//     from gaallocation ga 
//      where ga.schguid=b.schguid and gaayear=:gaayear
//      limit 1)/1000000,2)

//    Allocated,
   
//    round(( select 
//  ifnull(sum(d.totalamount)/1000000,0) 
//  from funds d   inner join 
//  papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
//  where d.schguid=b.schguid and d.fundyear=:gaayear
//   ),2) Transferred ,
//    round((select 
//  ifnull(sum(e.grossamount),0)/1000000 
//  from  mooedisbursements e inner join 
//   funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
//   papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
//   where e.schguid=b.schguid
//   ),2)
  
//   Utilized,
//  round((select 
//  ifnull(sum(e.grossamount),0)/1000000 
//  from  mooedisbursements e inner join 
//   funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y'   inner join 
//   papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
//   where e.schguid=b.schguid
//   ),2)
//   Liquidated 
//   ,
  
//   ( ( round((select 
//   ifnull(sum(e.grossamount),0)/1000000 
//   from  mooedisbursements e inner join 
//    funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
//    papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
//    where e.schguid=b.schguid
//    ),2)) / 
   
//    (  round(( select 
//   ifnull(sum(d.totalamount)/1000000,0) 
//   from funds d   inner join 
//   papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
//   where d.schguid=b.schguid and d.fundyear=:gaayear
//    ),2) ) ) Util_Rate
  
  
//               from  schools b   
                          
//              where b.schdivid=:schdivid
//               order by 7 desc 
//               limit 0,10";

//     // prepare query statement
    
//     $stmt = $this->conn->prepare( $query );

//     // bind id of product to be updated

//     $gaayear=$this->get_property("gaayear");
//     $stmt->bindParam(":gaayear", $gaayear); 
//     $this->bind($stmt);
//     // execute query
//     $stmt->execute();
//     return $stmt;


// }



//Read Top 10 Divisions Utilization
function readROTop10Utils($order){
    $prepquery=" SET SESSION sql_mode = '';";
    $stmt = $this->conn->prepare( $prepquery );
    $stmt->execute();
    // query to read single record
    $tblprfx="a" ; 
   
    $query="select dv.divdescription schdescription, 
            
            round(sum(g.gaatotal)/1000000,2) Allocated,
        
            
            -- Total Transferred
            round((select ifnull(sum(f.totalamount),0)
            from funds f inner join 
                    schools s on f.schguid=s.schguid and s.schtype='NON-IU' inner join
                    papcodes p on f.paps=p.papguid inner join 
                    schooldivisions d on s.schdivid=d.schdivid 
            where f.fundyear=:fundyear and f.schdivid=dv.schdivid 
            )/1000000,2) Transferred ,
                    
            round(( select ifnull(sum(m.grossamount),0)
         from mooedisbursements m inner join
         funds f on m.fundguid=f.fundguid inner join
         schools s on f.schguid=s.schguid and s.schtype='NON-IU' inner join
         papcodes p on f.paps=p.papguid inner join
         schooldivisions d on f.schdivid=d.schdivid
         where f.fundyear=:fundyear and f.schdivid=dv.schdivid 
         )/1000000,2) Utilized ,
         
         round(( select ifnull(sum(m.grossamount),0)
         from mooedisbursements m inner join
         funds f on m.fundguid=f.fundguid inner join
         schools s on f.schguid=s.schguid and s.schtype='NON-IU' inner join
         papcodes p on f.paps=p.papguid inner join
         schooldivisions d on f.schdivid=d.schdivid
         where f.fundyear=:fundyear and f.schdivid=dv.schdivid and m.liquidated='Y'
         )/1000000,2) Liquidated
               
        from gaallocation g inner join 
        schools s on g.schguid=s.schguid and s.schtype='NON-IU' inner join 
        schooldivisions dv on s.schdivid=dv.schdivid 
        where gaayear=:fundyear and dv.schregid=:schregid
        group by dv.divdescription
        order by 4 ".$order." 
        Limit 1, 10";

    // prepare query statement
  
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated

    $fundyear=$this->get_property("fundyear");
    $schregid=$this->get_property("schregid");
    $stmt->bindParam(":fundyear", $fundyear); 
    $stmt->bindParam(":schregid", $schregid); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
    return $stmt;


}
function readCOTop10Utils($order){
    $prepquery=" SET SESSION sql_mode = '';";
    $stmt = $this->conn->prepare( $prepquery );
    $stmt->execute();
    // query to read single record
    $tblprfx="a" ; 
   
    $query=" select r.schregdescription schdescription, 
                
                round(sum(g.gaatotal)/1000000,2) Allocated,
            
                
                -- Total Transferred
                round((select ifnull(sum(f.totalamount),0)
                from funds f inner join 
                        schools s on f.schguid=s.schguid and s.schtype='NON-IU' inner join
                        papcodes p on f.paps=p.papguid inner join 
                        schooldivisions d on s.schdivid=d.schdivid inner join 
                        schoolregions sr on d.schregid=sr.schregid
                where f.fundyear=:fundyear and sr.schregid=r.schregid 
    )/1000000,2) Transferred ,
            
    round(( select ifnull(sum(m.grossamount),0)
             from mooedisbursements m inner join
             funds f on m.fundguid=f.fundguid inner join
             schools s on f.schguid=s.schguid and s.schtype='NON-IU' inner join
             papcodes p on f.paps=p.papguid inner join
             schooldivisions d on f.schdivid=d.schdivid inner join 
                        schoolregions sr on d.schregid=sr.schregid
                where f.fundyear=:fundyear and sr.schregid=r.schregid 
             )/1000000,2) Utilized ,
             
             round(( select ifnull(sum(m.grossamount),0)
             from mooedisbursements m inner join
             funds f on m.fundguid=f.fundguid inner join
             schools s on f.schguid=s.schguid and s.schtype='NON-IU' inner join
             papcodes p on f.paps=p.papguid inner join
             schooldivisions d on f.schdivid=d.schdivid inner join 
                        schoolregions sr on d.schregid=sr.schregid
                where f.fundyear=:fundyear and sr.schregid=r.schregid 
             )/1000000,2) Liquidated
                   
            from gaallocation g inner join 
            schools s on g.schguid=s.schguid and s.schtype='NON-IU' inner join 
            schooldivisions dv on s.schdivid=dv.schdivid inner join 
            schoolregions r on dv.schregid=r.schregid
            where gaayear=:fundyear 
            group by r.schregdescription
            order by 4 ".$order;

    // prepare query statement
  
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated

    $fundyear=$this->get_property("fundyear");
    // $schregid=$this->get_property("schregid");
    $stmt->bindParam(":fundyear", $fundyear); 
    // $stmt->bindParam(":schregid", $schregid); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
    return $stmt;


}

   //Read Top 10 Schools High Utilization
   function readTopHighUtils(){

        // query to read single record

        // ROUND(sum(ifnull(gaatotal,0))/1000000,2)
       
        $tblprfx="a" ; 
        // $query = "select  gaayear,c.schdivid,b.schdescription,

        //             (select ifnull(ROUND(sum(gaatotal)/1000000,2),0) 
        //             from gaallocation aa inner join 
        //                 schools b on aa.schguid=b.schguid inner join 
        //                 schooldivisions c on b.schdivid = c.schdivid 
        //             where aa.schguid=a.schguid and a.gaayear=:gaayear)
                    
        //             Allocated, 


        //             ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
        //             ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
        //             ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
        //             ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
        //             ,b.schguid,
        //             ROUND(((sum(ifnull(gaatotal,0)) - sum(ifnull(d.totalamount,0)) ) / sum(ifnull(gaatotal,0))),2) GAABalance,
        //             ifnull(ROUND((sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)))/sum(ifnull(d.totalamount,0)) ,2),0) FundBalance,
        //             ifnull(ROUND(
        //             sum(case 
        //                       when e.liquidated='y' 
        //                        then e.grossamount 
        //                        else 0 
        //                    end ) /1000000
        //             ,2),0) Liquidated,
        //              ifnull(ROUND(
        //              sum(case 
        //                       when e.liquidated='y' 
        //                        then e.grossamount 
        //                        else 0 
        //                    end ) /1000000
        //             ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus

        //             from gaallocation a inner join 
        //                 schools b on a.schguid = b.schguid inner join 
        //                 schooldivisions c on b.schdivid = c.schdivid left join 
        //                 funds d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
        //                 mooedisbursements e on d.fundguid = e.fundguid
        //             where c.schdivid=:schdivid and gaayear=:gaayear
        //             group by gaayear,c.schdivid,b.schguid
        //             order by 7 desc  ,schdescription asc 
        //             limit 0,10";
        
        $query="select  b.schdivid,b.schdescription,

        round((select gaatotal 
        from gaallocation ga 
         where ga.schguid=b.schguid and gaayear=:gaayear
         limit 1)/1000000,2)

       Allocated,
       
       round(( select 
     ifnull(sum(d.totalamount)/1000000,0) 
     from funds d   inner join 
     papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
     where d.schguid=b.schguid and d.fundyear=:gaayear
	  ),2) Transferred ,
	   round((select 
     ifnull(sum(e.grossamount),0)/1000000 
     from  mooedisbursements e inner join 
	  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
	  where e.schguid=b.schguid
	  ),2)
	  
	  Utilized,
	 round((select 
     ifnull(sum(e.grossamount),0)/1000000 
     from  mooedisbursements e inner join 
	  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y'   inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
	  where e.schguid=b.schguid
	  ),2)
	  Liquidated 
      ,
	  
      ( ( round((select 
      ifnull(sum(e.grossamount),0)/1000000 
      from  mooedisbursements e inner join 
       funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
       papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
       where e.schguid=b.schguid
       ),2)) / 
       
       (  round(( select 
      ifnull(sum(d.totalamount)/1000000,0) 
      from funds d   inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
      where d.schguid=b.schguid and d.fundyear=:gaayear
       ),2) ) ) Util_Rate
	  
	  
                  from  schools b   
							  
                 where b.schdivid=:schdivid
                  order by 7 desc 
                  limit 0,10";

        // prepare query statement
        
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated

        $gaayear=$this->get_property("gaayear");
        $stmt->bindParam(":gaayear", $gaayear); 
        $this->bind($stmt);
        // execute query
        $stmt->execute();
        return $stmt;


    }

    //Read Top 10 Schools Low Utilization
    function readTopLowUtils(){

        // query to read single record
        $tblprfx="a" ; 
        // $query = "select  gaayear,c.schdivid,b.schdescription,

        //             (select ifnull(ROUND(sum(gaatotal)/1000000,2),0) 
        //             from gaallocation aa inner join 
        //                 schools b on aa.schguid=b.schguid inner join 
        //                 schooldivisions c on b.schdivid = c.schdivid 
        //             where aa.schguid=a.schguid and a.gaayear=:gaayear)
                    
        //             Allocated, 
        //             ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
        //             ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
        //             ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
        //             ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
        //             ,b.schguid,
        //             ROUND(((sum(ifnull(gaatotal,0)) - sum(ifnull(d.totalamount,0)) ) / sum(ifnull(gaatotal,0))),2) GAABalance,
        //             ifnull(ROUND((sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)))/sum(ifnull(d.totalamount,0)) ,2),0) FundBalance,
        //             ifnull(ROUND(
        //             sum(case 
        //                       when e.liquidated='y' 
        //                        then e.grossamount 
        //                        else 0 
        //                    end ) /1000000
        //             ,2),0) Liquidated,
        //              ifnull(ROUND(
        //              sum(case 
        //                       when e.liquidated='y' 
        //                        then e.grossamount 
        //                        else 0 
        //                    end ) /1000000
        //             ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus

        //             from gaallocation a inner join 
        //                 schools b on a.schguid = b.schguid inner join 
        //                 schooldivisions c on b.schdivid = c.schdivid left join 
        //                 funds d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
        //                 mooedisbursements e on d.fundguid = e.fundguid
        //                                 where c.schdivid=:schdivid and gaayear=:gaayear
        //             group by gaayear,c.schdivid,b.schguid
        //             order by 7 asc  ,schdescription asc 
        //             limit 0,10";
        $query="select  b.schdivid,b.schdescription,

        round((select gaatotal 
        from gaallocation ga 
         where ga.schguid=b.schguid and gaayear=:gaayear
         limit 1)/1000000,2)

       Allocated,
       
       round(( select 
     ifnull(sum(d.totalamount)/1000000,0) 
     from funds d   inner join 
     papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
     where d.schguid=b.schguid and d.fundyear=:gaayear
	  ),2) Transferred ,
	   round((select 
     ifnull(sum(e.grossamount),0)/1000000 
     from  mooedisbursements e inner join 
	  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
	  where e.schguid=b.schguid
	  ),2)
	  
	  Utilized,
	 round((select 
     ifnull(sum(e.grossamount),0)/1000000 
     from  mooedisbursements e inner join 
	  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y'   inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
	  where e.schguid=b.schguid
	  ),2)
	  Liquidated 
      ,
	  
      ( ( round((select 
      ifnull(sum(e.grossamount),0)/1000000 
      from  mooedisbursements e inner join 
       funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
       papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
       where e.schguid=b.schguid
       ),2)) / 
       
       (  round(( select 
      ifnull(sum(d.totalamount)/1000000,0) 
      from funds d   inner join 
      papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'
      where d.schguid=b.schguid and d.fundyear=:gaayear
       ),2) ) ) Util_Rate
	  
	  
                  from  schools b   
							  
                 where b.schdivid=:schdivid
                  order by 7 asc 
                  limit 0,10";

        // prepare query statement
        
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated

        $gaayear=$this->get_property("gaayear");
        $stmt->bindParam(":gaayear", $gaayear); 
        $this->bind($stmt);
        // execute query
        $stmt->execute();
        return $stmt;


    }
    //Read Top 10 Schools High Utilization
   function readSchoolUtils(){

    // query to read single record
    //  ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
    $tblprfx="a" ; 
    // $query = "select  gaayear,c.schdivid,
    
    //                 (select ifnull(ROUND(sum(gaatotal)/1000000,2),0) 
    //                 from gaallocation 
    //                 where schguid=:schguid and gaayear=:gaayear)
                    
    //                 Allocated, 
    //                 ifnull(ROUND(sum(d.totalamount)/1000000,2),0) Transferred, 
    //                 ifnull(ROUND(((sum(d.totalamount)/sum(gaatotal)) ),2),0) TransferStatus,
    //                 ifnull(ROUND(sum(e.grossamount)/1000000,2),0) Utilized,
    //                 ifnull(ROUND(((sum(e.grossamount)/sum(d.totalamount)) ),2),0) UtilizationStatus ,
    //                 ifnull(ROUND(
    //                 sum(case 
    //                           when e.liquidated='y' 
    //                            then e.grossamount 
    //                            else 0 
    //                        end ) /1000000
    //                 ,2),0) Liquidated,
    //                  ifnull(ROUND(
    //                  sum(case 
    //                           when e.liquidated='y' 
    //                            then e.grossamount 
    //                            else 0 
    //                        end ) /1000000
    //                 ,2),0) / (ifnull(ROUND(sum(d.totalamount)/1000000,2),0)) LiquidatedStatus
                        
    //             from gaallocation a inner join 
    //                 schools b on a.schguid = b.schguid inner join 
    //                 schooldivisions c on b.schdivid = c.schdivid left join 
    //                 funds d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
    //                 mooedisbursements e on d.fundguid = e.fundguid
    //             where b.schguid=:schguid and gaayear=:gaayear
    //             group by gaayear,c.schdivid,b.schguid
    //             order by 7 desc  ,schdescription asc 
    //             limit 0,10";

    $es=$this->get_property("es");
    $jhs=$this->get_property("jhs");
    $shs=$this->get_property("shs");

    $allocflds=""; 
    $papejs="";

    if ($es="Y"){
        $allocflds=$allocflds." gaaes ";
        $papejs=" pc.es='Y' ";
    } 
    if ($jhs="Y"){
        if ( $allocflds!="") {
            $allocflds=$allocflds." + gaajhs";
        } else {
            $allocflds=$allocflds." gaajhs ";
        }
        if ( $papejs!="") {
            $papejs=$papejs." or pc.jhs='Y' ";
        } else {
            $papejs=$papejs." pc.jhs='Y' ";
        }
        
    } 
    if ($shs="Y"){
        if ( $allocflds!="") {
            $allocflds=$allocflds." + gaashs";
        } else {
            $allocflds=$allocflds." gaashs ";
        }
        if ( $papejs!="") {
            $papejs=$papejs." or pc.shs='Y' ";
        } else {
            $papejs=$papejs." pc.shs='Y' ";
        }
        
    } 
    if ($papejs!=""){
        $papejs = " and (".$papejs.")";
    }
    
    $query="select  b.schdivid,b.schdescription,

    round((select (".$allocflds.") gaatotal
    from gaallocation ga 
     where ga.schguid=b.schguid and gaayear=:gaayear
     limit 1)/1000000,2)

   Allocated,
   (select (".$allocflds.") gaatotal
   from gaallocation ga 
    where ga.schguid=b.schguid and gaayear=:gaayear
    limit 1)

  AllocatedAmt,
   
   round(( select 
 ifnull(sum(d.totalamount)/1000000,0) 
 from funds d inner join 
 papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' ".$papejs." 
 where d.schguid=b.schguid and d.fundyear=:gaayear
  ),2) Transferred ,

  round(( select 
  ifnull(sum(d.totalamount),0) 
  from funds d   inner join 
  papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' ".$papejs." 
  where d.schguid=b.schguid and d.fundyear=:gaayear
   ),2) TransferredAmt ,
 


   round((select 
 ifnull(sum(e.grossamount),0)/1000000 
 from  mooedisbursements e inner join 
  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
  papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' ".$papejs." 
  where e.schguid=b.schguid
  ),2)
  
  Utilized,
 
  (select 
  ifnull(sum(e.grossamount),0)
  from  mooedisbursements e inner join 
   funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
   papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' ".$papejs." 
   where e.schguid=b.schguid
   )
   
   UtilizedAmt,

 round((select 
 ifnull(sum(e.grossamount),0)/1000000 
 from  mooedisbursements e inner join 
  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y'   inner join 
  papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' ".$papejs." 
  where e.schguid=b.schguid
  ),2)
  Liquidated ,

  (select 
 ifnull(sum(e.grossamount),0) 
 from  mooedisbursements e inner join 
  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y'   inner join 
  papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' ".$papejs." 
  where e.schguid=b.schguid
  )
  LiquidatedAmt
 
  
  
              from  schools b   
                          
             where b.schguid=:schguid
              order by 5 desc 
              limit 0,10";

    // prepare query statement
    // echo $query;
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated

    $gaayear=$this->get_property("gaayear");
    $stmt->bindParam(":gaayear", $gaayear); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;


}
function readDivSchoolESUtils(){

    // query to read single record
    //  ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
    
    
    $queryES="select  b.schoolid ,b.schdescription,

                round((select gaaes 
                from gaallocation ga 
                where ga.schguid=b.schguid and gaayear=:gaayear
                limit 1),2)

            ES_Allocated,
            
            round(( select 
            ifnull(sum(d.totalamount),0) 
            from funds d   inner join 
            papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' and pc.papscode='310400100002000'
            where d.schguid=b.schguid and d.fundyear=:gaayear 
            ),2) Transferred ,
            round((select 
            ifnull(sum(e.grossamount),0) 
            from  mooedisbursements e inner join 
            funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
            papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'  and pc.papscode='310400100002000'
            where e.schguid=b.schguid
            ),2)
            
            Utilized,
            round((select 
            ifnull(sum(e.grossamount),0) 
            from  mooedisbursements e inner join 
            funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y'   inner join 
            papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'  and pc.papscode='310400100002000'
            where e.schguid=b.schguid
            ),2)
            Liquidated 
            
            
            
            from  schools b   
                        
            where b.schdivid=:schdivid 
            order by 2 asc 
                        



            ";

    // prepare query statement
    
    $es_stmt = $this->conn->prepare( $queryES );
    
    // bind id of product to be updated

    $gaayear=$this->get_property("gaayear");
    $es_stmt->bindParam(":gaayear", $gaayear); 
    $this->bind($es_stmt);
    // execute query
    $es_stmt->execute();




    return $es_stmt ;


}
function readDivSchoolJHSUtils(){

    // query to read single record
    //  ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
    
    
    $queryJHS="select  b.schoolid ,b.schdescription,

                round((select gaajhs 
                from gaallocation ga 
                where ga.schguid=b.schguid and gaayear=:gaayear
                limit 1),2)

            JHS_Allocated,
            
            round(( select 
            ifnull(sum(d.totalamount),0) 
            from funds d   inner join 
            papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' and pc.papscode='310400100003000'
            where d.schguid=b.schguid and d.fundyear=:gaayear 
            ),2) Transferred ,
            round((select 
            ifnull(sum(e.grossamount),0) 
            from  mooedisbursements e inner join 
            funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
            papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'  and pc.papscode='310400100003000'
            where e.schguid=b.schguid
            ),2)
            
            Utilized,
            round((select 
            ifnull(sum(e.grossamount),0) 
            from  mooedisbursements e inner join 
            funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y'   inner join 
            papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'  and pc.papscode='310400100003000'
            where e.schguid=b.schguid
            ),2)
            Liquidated 
            
            
            
                        from  schools b   
                                    
                        where b.schdivid=:schdivid 
                        order by 2 asc 
                        
                        ";

    // prepare query statement
    
    $jhs_stmt = $this->conn->prepare( $queryJHS );
    
    // bind id of product to be updated

    $gaayear=$this->get_property("gaayear");
    $jhs_stmt->bindParam(":gaayear", $gaayear); 
    $this->bind($jhs_stmt);
    // execute query
    $jhs_stmt->execute();




    return $jhs_stmt ;


}
function readDivSchoolSHSUtils(){

    // query to read single record
    //  ifnull(ROUND(sum(gaatotal)/1000000,2),0) Allocated, 
    
    
    $querySHS="select  b.schoolid ,b.schdescription,

    round((select  gaashs
    from gaallocation ga 
     where ga.schguid=b.schguid and gaayear=:gaayear
     limit 1),2)

   SHS_Allocated,
   
   round(( select 
 ifnull(sum(d.totalamount),0) 
 from funds d   inner join 
 papcodes pc on d.paps = pc.papguid and pc.regmooe='Y' and pc.papscode='310400100004000'
 where d.schguid=b.schguid and d.fundyear=:gaayear 
  ),2) Transferred ,
   round((select 
 ifnull(sum(e.grossamount),0) 
 from  mooedisbursements e inner join 
  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear   inner join 
  papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'  and pc.papscode='310400100004000'
  where e.schguid=b.schguid
  ),2)
  
  Utilized,
 round((select 
 ifnull(sum(e.grossamount),0) 
 from  mooedisbursements e inner join 
  funds d on d.fundguid = e.fundguid and d.fundyear=:gaayear and e.liquidated='Y'   inner join 
  papcodes pc on d.paps = pc.papguid and pc.regmooe='Y'  and pc.papscode='310400100004000'
  where e.schguid=b.schguid
  ),2)
  Liquidated 
 
  
  
              from  schools b   
                          
             where b.schdivid=:schdivid
              order by 3 desc 
             
";

    // prepare query statement
    
    $shs_stmt = $this->conn->prepare( $querySHS );
    
    // bind id of product to be updated

    $gaayear=$this->get_property("gaayear");
    $shs_stmt->bindParam(":gaayear", $gaayear); 
    $this->bind($shs_stmt);
    // execute query
    $shs_stmt->execute();




    return $shs_stmt ;


}
function readSchoolBalance($gaafield='gaatotal'){

    // query to read single record
    $tblprfx="a" ; 
    if ($gaafield==''){

        $gaafield='gaatotal';
    }
    // $query = "select gaayear,c.schdivid,b.schdescription,

    //             ROUND(sum(ifnull(gaatotal,0))/1000000,2) Allocated, 
    //             ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
    //             ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(gaatotal,0))) ),2) TransferStatus,
    //             ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
    //             ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
    //             ,b.schguid,
    //             (sum(ifnull(gaatotal,0)) - sum(ifnull(d.totalamount,0)) )  GAABalance,
    //             sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)) FundBalance
    //         from gaallocation a inner join 
    //         schools b on a.schguid = b.schguid inner join 
    //         schooldivisions c on b.schdivid = c.schdivid left join 
    //         funds d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
    //         mooedisbursements e on d.fundguid = e.fundguid

    //             where b.schguid=:schguid and gaayear=:gaayear
    //             group by gaayear,c.schdivid,b.schguid
    //             order by 7 desc  ,schdescription asc 
    //             limit 0,10";
    // $query = "select gaayear,c.schdivid,b.schdescription,

    //                 ROUND(sum(ifnull(".$gaafield.",0))/1000000,2) Allocated, 
    //                 ROUND(sum(ifnull(d.totalamount,0))/1000000,2) Transferred, 
    //                 ROUND(((sum(ifnull(d.totalamount,0))/sum(ifnull(".$gaafield.",0))) ),2) TransferStatus,
    //                 ROUND(sum(ifnull(e.grossamount,0))/1000000,2) Utilized,
    //                 ifnull(ROUND(((sum(ifnull(e.grossamount,0))/sum(ifnull(d.totalamount,0))) ),2),0) UtilizationStatus
    //                 ,b.schguid,
    //                 (sum(ifnull(".$gaafield.",0)) - sum(ifnull(d.totalamount,0)) )  GAABalance,
    //                 sum(ifnull(d.totalamount,0))-sum(ifnull(e.grossamount,0)) FundBalance
    //             from gaallocation a inner join 
    //             schools b on a.schguid = b.schguid inner join 
    //             schooldivisions c on b.schdivid = c.schdivid left join 
    //             funds d on b.schguid = d.schguid and d.fundyear = a.gaayear left join 
    //             mooedisbursements e on d.fundguid = e.fundguid left join 
    //             papcodes f on d.paps=f.papguid


    //                 where b.schguid=:schguid and gaayear=:gaayear and d.paps=:paps
    //                 group by gaayear,c.schdivid,b.schguid
    //                 order by 7 desc  ,schdescription asc 
    //                 limit 0,10";

    $query="select ".$gaafield." -
                (select ifnull(sum(ifnull(a.totalamount,0)),0)
                from funds a inner join 
                    papcodes b on a.paps=b.papguid
                where   a.paps=:paps and 
                        a.schguid = :schguid and 
                        a.fundyear=:gaayear
                
                ) GAABalance,
                (select ifnull(sum(ifnull(grossamount-netamount,0)),0)
                from funds a inner join 
                    papcodes b on a.paps=b.papguid inner join 
                    mooedisbursements c on a.fundguid=c.fundguid
                    where   a.paps=:paps and 
                    a.schguid = :schguid and 
                    a.fundyear=:gaayear
                
                ) Taxes
                                
            from gaallocation a
            
            where a.schguid=:schguid and gaayear=:gaayear 
            
                            ";
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query );
    // echo $query; 
    // bind id of product to be updated

    $gaayear=$this->get_property("gaayear");
    $paps=$this->get_property("paps");
    $stmt->bindParam(":gaayear", $gaayear); 
    $stmt->bindParam(":paps", $paps); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;


}

function readFundBalance(){

    // query to read single record
    $tblprfx="a" ; 
    $query = "select a.totalamount , 
                    ifnull(sum(b.grossamount),0) Utilized, 
                    ifnull(a.totalamount - ifnull(sum(b.grossamount),0),0) Balance, 
                    ifnull(a.totalamount - ifnull(sum(b.netamount),0),0) NetBalance
                from funds a inner join 
                    mooedisbursements b on a.fundguid = b.fundguid
                where ".$this->createWhereQry($tblprfx)."
                

            ";

    // prepare query statement b.schguid = :schguid and a.fundguid= fundguid
    
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated

    // $gaayear=$this->get_property("gaayear");
    // $stmt->bindParam(":gaayear", $gaayear); 
    $this->bind($stmt);
    // execute query
    $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $item_arr=$row;
        // get retrieved row
        return $item_arr ;


}
function readOtherFundBalance($parentfund,$rolegroup){

    // query to read single record
    $tblprfx="a" ; 
    if ($rolegroup=='H'){
        $query = "select a.totalamount FundBalance
        from funds ".$tblprfx." 
        where  a.fundguid=:parentorg            
    
                ";
    } else {
        $query = "select a.totalamount - ifnull(sum(b.totalamount),0) FundBalance
        from funds ".$tblprfx." inner join 
             funds b on a.fundguid=b.parentfund 
        where  a.fundguid=:parentorg            
    
                ";
        if ($rolegroup=='D'){
            $querydisb="select sum(grossamount) Total_Disb 
                from mooedisbursements 
                where fundguid = :parentorg";
        }
        
    }
   
    //  echo $query;
    // return 0;

    // prepare query statement b.schguid = :schguid and a.fundguid= fundguid
    
    $stmt = $this->conn->prepare( $query );
    // bind id of product to be updated
    // $gaayear=$this->get_property("gaayear");
    $stmt->bindParam(":parentorg", $parentfund); 
    // $this->bind($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    $item_arr=$row;
    // get retrieved row
    if ($rolegroup=='D'){
        $dstmt = $this->conn->prepare( $querydisb );
        // bind id of product to be updated
        // $gaayear=$this->get_property("gaayear");
        // $parentfund = $this->get_property("parentfund");
        $dstmt->bindParam(":parentorg", $parentfund); 
        // $this->bind($stmt);
        // execute query
        $dstmt->execute();
        $drow = $dstmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        $ditem_arr=$drow;

        $item_arr["FundBalance"]=$item_arr["FundBalance"] - $ditem_arr["Total_Disb"];
    }
    




    return $item_arr ;


}



    // read users with pagination
   public function readPaging($from_record_num, $records_per_page){
 
            // select query
            
            
            $tblprfx="a" ; 
            $query = "SELECT " 
                       .$this->createSelFlds($tblprfx) . "
                       ,b.schdescription,c.papsdescription papsdesc,
                       .b.schoolid 
                FROM
                    "  .$this->table_name . " " . $tblprfx ." inner join 
                    schools b on a.schguid=b.schguid inner join 
                    papcodes c on a.paps=c.papguid and c.regmooe='Y'
                    
                WHERE ".$this->createWhereQry( $tblprfx)."
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
    public function readCibrFunds(){
 
        // select query
        
        
        $tblprfx="a" ; 
        $query = "select 
                    *
                from 
                funds a inner join 
                                schools b on a.schguid=b.schguid inner join 
                                papcodes c on a.paps=c.papguid 
                where ".$this->createWhereQry( $tblprfx)." and month(transferdate)=:fundmonth and (year(transferdate)=:trfryear or fundyear=:trfryear)
            ";
    
        // prepare query statement
        // echo $query;
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        $fundmonth= $this->get_property("fundmonth");
        $this->bind($stmt);
        $stmt->bindParam(":fundmonth",$fundmonth); 
        $trfryear= $this->get_property("trfryear");
        $stmt->bindParam(":trfryear",$trfryear); 
        
        // bind variable values
        // $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
        // $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
        
        return $stmt ;
        // return values from database
        
}
    public function readOthersPaging($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . "
                   ,b.schdescription,c.papsdescription papsdesc,b.schoolid,
                   schregdescription,
                   divdescription,
                   c.ES,c.JHS,c.SHS
            FROM
                "  .$this->table_name . " " . $tblprfx ." left join 
                schools b on a.schguid=b.schguid left join 
                schooldivisions sd on a.schdivid=sd.schdivid left join
                schoolregions sr on a.schregid=sr.schregid inner join
                papcodes c on a.paps=c.papguid and c.regmooe='N'
                
            WHERE ".$this->createWhereQry( $tblprfx)."
            order by a.rectimestamp desc
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
    public function readUnConfirmdPaging($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 

        $whereclause="";
        $es="";
        $jhs="";
        $shs="";


        if ($this->get_property('es')=='Y') {
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
            $whereclause=$this->createWhereQry()." and (".$whereclause.")";

        } else {
            $whereclause=$this->createWhereQry();
        }

        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . " , b.papsdescription, 
                   concat(  a.transferdate , ' | ', b.papsdescription, ' | ', c.schbank, ':', c.schaccount ) datedesc,
                   CONCAT(c.schbank, ':', c.schaccount)  acctdesc, c.es , c.jhs , c.shs 

            FROM
                "  .$this->table_name . " " . $tblprfx ." inner join  
                papcodes b on a.paps=b.papguid inner join 
                schacctejs c on a.schacctguid=c.ejsguid
                
            WHERE ".$whereclause."

            LIMIT :L1, :L2";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        $this->bind($stmt);
        // bind variable values
        $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);

        if (($es!="") || ($jhs!="") || ($shs!="")) {
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
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
}

public function readOtherFunds($from_record_num, $records_per_page){
 
    // select query
    
    
    $tblprfx="a" ; 
    $query = "SELECT " 
               .$this->createSelFlds($tblprfx) . " ,  b.papsdescription, 
               concat( a.fundyear, ' | ' , a.transferdate , ' | ', b.papsdescription ) funddesc, 
               b.ES,b.JHS,b.SHS

        FROM
            "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.paps=b.papguid and b.regmooe='N'
            
        WHERE ".$this->createWhereQry()."

        LIMIT :L1, :L2";
        // echo $query;

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // echo $query;
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
//DLI Report
public function readDLIReport(){
 
    // select query
    
    
    $tblprfx="a" ; 
    $query = "select  schregdescription , sum( fd.totalamount) TransferredFunds, 
                avg(datediff(fc.ackdate,fd.transferdate)) AveTransConfDays,
                count(fd.fundguid) SchoolswithFunds, 
                count(sc.schguid) TotalSchools,
                (count(fd.fundguid)/ count(sc.schguid))*100 TransferStatus
            from schools sc inner join 
            schooldivisions sd on sc.schdivid = sd.schdivid inner join 
            schoolregions sr on sd.schregid=sr.schregid left join 
            funds fd on sc.schguid = fd.schguid and fd.fundyear=:fundyear and month(fd.transferdate)=:fundmonth  left join 
            fundconfirm fc on fd.fundguid=fc.fundguid

            group by schregdescription";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // echo $query;
    // bind query parameters
    $this->bind($stmt);
    // bind variable values
    $fundyear=$this->get_property("fundyear");
    $fundmonth=$this->get_property("fundmonth");
    $stmt->bindParam(":fundyear", $fundyear, PDO::PARAM_INT);
    $stmt->bindParam(":fundmonth",$fundmonth, PDO::PARAM_INT);

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}
// used for paging user
public function count(){
    $tblprfx="a" ; 
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " " . $tblprfx ." inner join 
    schools b on a.schguid=b.schguid inner join 
    papcodes c on a.paps=c.papguid and c.regmooe='Y'
    WHERE ".$this->createWhereQry( $tblprfx)."
    ";
   
    $stmt = $this->conn->prepare( $query );
    // echo $query;
    $this->bind($stmt);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function otherscount(){
    $tblprfx="a" ; 
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " " . $tblprfx ." inner join 
    schools b on a.schguid=b.schguid inner join 
    papcodes c on a.paps=c.papguid and c.regmooe='N'
    WHERE ".$this->createWhereQry( $tblprfx)."
    ";
 
    $stmt = $this->conn->prepare( $query );
    $this->bind($stmt);
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
public function OtherFundscount(){
    $tblprfx = "a";
    $query = "SELECT COUNT(*) as total_rows FROM
        "  .$this->table_name . " " . $tblprfx ." inner join  papcodes b on a.paps=b.papguid and b.regmooe-'N'
    
        WHERE ".$this->createWhereQry();
 
    $stmt = $this->conn->prepare( $query );
    $this->bind($stmt);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}
function COSummary(){
    // //Set SQL mode 
    $prepquery=" SET SESSION sql_mode = '';";
    $stmt = $this->conn->prepare( $prepquery );
    $stmt->execute();

    $query="  select r.schregdescription , 
            -- Total Allocation
            sum(g.gaatotal) TotalAllocation,
            sum(g.gaaes) TotalES,
            sum(g.gaajhs) TotalJHS,
            sum(g.gaashs) TotalSHS,
            -- Total Transferred
            (select ifnull(sum(f.totalamount),0)
                from funds f inner join 
                    schools s on f.schguid=s.schguid and s.schtype= :schtype inner join
                    papcodes p on f.paps=p.papguid inner join 
                    schooldivisions d on f.schdivid=d.schdivid inner join
                        schoolregions g on d.schregid=g.schregid 
                where p.papscode='310400100002000' and f.fundyear=:fundyear and g.schregid=r.schregid
                ) TotalTransferredES,
                (select ifnull(sum(f.totalamount),0)
                from funds f inner join 
                    schools s on f.schguid=s.schguid and s.schtype= :schtype inner join
                    papcodes p on f.paps=p.papguid inner join 
                    schooldivisions d on f.schdivid=d.schdivid inner join
                        schoolregions g on d.schregid=g.schregid 
                where p.papscode='310400100003000' and f.fundyear=:fundyear and g.schregid=r.schregid
                ) TotalTransferredJHS,
                (select ifnull(sum(f.totalamount),0)
                from funds f inner join 
                    schools s on f.schguid=s.schguid and s.schtype= :schtype inner join
                    papcodes p on f.paps=p.papguid inner join 
                    schooldivisions d on f.schdivid=d.schdivid inner join
                        schoolregions g on d.schregid=g.schregid 
                where p.papscode='310400100004000' and f.fundyear=:fundyear and g.schregid=r.schregid
                ) TotalTransferredSHS,
                
                -- Total Liquidated 
                
                ( select ifnull(sum(m.grossamount),0) 
                    from mooedisbursements m inner join 
                        funds f on m.fundguid=f.fundguid inner join 
                        schools s on f.schguid=s.schguid and s.schtype= :schtype inner join
                        papcodes p on f.paps=p.papguid inner join 
                        schooldivisions d on f.schdivid=d.schdivid inner join
                            schoolregions g on d.schregid=g.schregid 
                    where p.papscode='310400100002000' and f.fundyear=:fundyear and g.schregid=r.schregid and m.liquidated='Y'
                ) TotalLiquidES ,

                ( select ifnull(sum(m.grossamount),0) 
                    from mooedisbursements m inner join 
                        funds f on m.fundguid=f.fundguid inner join 
                    schools s on f.schguid=s.schguid and s.schtype= :schtype inner join
                        papcodes p on f.paps=p.papguid inner join 
                        schooldivisions d on f.schdivid=d.schdivid inner join
                            schoolregions g on d.schregid=g.schregid 
                    where p.papscode='310400100003000' and f.fundyear=:fundyear and g.schregid=r.schregid and m.liquidated='Y'
                ) TotalLiquidJHS ,
                ( select ifnull(sum(m.grossamount),0) 
                    from mooedisbursements m inner join 
                        funds f on m.fundguid=f.fundguid inner join 
                    schools s on f.schguid=s.schguid and s.schtype= :schtype inner join
                        papcodes p on f.paps=p.papguid inner join 
                        schooldivisions d on f.schdivid=d.schdivid inner join
                            schoolregions g on d.schregid=g.schregid 
                    where p.papscode='310400100004000' and f.fundyear=:fundyear and g.schregid=r.schregid and m.liquidated='Y'
                ) TotalLiquidSHS 		  
            from gaallocation g inner join 
            schools s on g.schguid=s.schguid and s.schtype= :schtype inner join 
            schooldivisions d on s.schdivid=d.schdivid inner join
            schoolregions r on d.schregid=r.schregid
            where gaayear=:fundyear
            group by r.schregdescription
            order by r.schregdescription";
    $stmt = $this->conn->prepare( $query );
    // echo $query;
    // bind id of product to be updated
    // $this->bind($stmt);
    $fundyear= $this->get_property("fundyear");
    $schtype= $this->get_property("schtype");
    $stmt->bindParam(":fundyear", $fundyear);
    $stmt->bindParam(":schtype", $schtype);
    // execute query
    $stmt->execute();
    // print_r( $this);
    return $stmt;
   
  
}
function ROSummary(){
    // //Set SQL mode 
    $prepquery=" SET SESSION sql_mode = '';";
    $stmt = $this->conn->prepare( $prepquery );
    $stmt->execute();

    $query="select dv.divdescription , 
            -- Total Allocation
            sum(g.gaatotal) TotalAllocation,
            sum(g.gaaes) TotalES,
            sum(g.gaajhs) TotalJHS,
            sum(g.gaashs) TotalSHS
            ,
            -- Total Transferred
            (select ifnull(sum(f.totalamount),0)
            from funds f inner join 
                    schools s on f.schguid=s.schguid and s.schtype=:schtype inner join
                    papcodes p on f.paps=p.papguid inner join 
                    schooldivisions d on s.schdivid=d.schdivid 
            where p.papscode='310400100002000' and f.fundyear=:fundyear and f.schdivid=dv.schdivid 
            ) TotalTransferredES ,
            (select ifnull(sum(f.totalamount),0)
                from funds f inner join
                schools s on f.schguid=s.schguid and s.schtype=:schtype inner join
                papcodes p on f.paps=p.papguid inner join
                schooldivisions d on f.schdivid=d.schdivid
                where p.papscode='310400100003000' and f.fundyear=:fundyear and f.schdivid=dv.schdivid
                ) TotalTransferredJHS,
                (select ifnull(sum(f.totalamount),0)
                from funds f inner join
                schools s on f.schguid=s.schguid and s.schtype=:schtype inner join
                papcodes p on f.paps=p.papguid inner join
                schooldivisions d on f.schdivid=d.schdivid
                where p.papscode='310400100004000' and f.fundyear=:fundyear and f.schdivid=dv.schdivid
                ) TotalTransferredSHS,
                --
                -- Total Liquidated
                --
                ( select ifnull(sum(m.grossamount),0)
                from mooedisbursements m inner join
                funds f on m.fundguid=f.fundguid inner join
                schools s on f.schguid=s.schguid and s.schtype=:schtype inner join
                papcodes p on f.paps=p.papguid inner join
                schooldivisions d on f.schdivid=d.schdivid
                where p.papscode='310400100002000' and f.fundyear=:fundyear and f.schdivid=dv.schdivid and m.liquidated='Y'
                ) TotalLiquidES ,
                --
                ( select ifnull(sum(m.grossamount),0)
                from mooedisbursements m inner join
                funds f on m.fundguid=f.fundguid inner join
                schools s on f.schguid=s.schguid and s.schtype=:schtype inner join
                papcodes p on f.paps=p.papguid inner join
                schooldivisions d on f.schdivid=d.schdivid
                where p.papscode='310400100003000' and f.fundyear=:fundyear and d.schdivid=dv.schdivid and m.liquidated='Y'
                ) TotalLiquidJHS ,
                ( select ifnull(sum(m.grossamount),0)
                from mooedisbursements m inner join
                funds f on m.fundguid=f.fundguid inner join
                schools s on f.schguid=s.schguid and s.schtype=:schtype inner join
                papcodes p on f.paps=p.papguid inner join
                schooldivisions d on f.schdivid=d.schdivid
                where p.papscode='310400100004000' and f.fundyear=:fundyear and d.schdivid=dv.schdivid and m.liquidated='Y'
                        ) TotalLiquidSHS 		  
        from gaallocation g inner join 
        schools s on g.schguid=s.schguid and s.schtype=:schtype inner join 
        schooldivisions dv on s.schdivid=dv.schdivid -- inner join
        -- schoolregions r on dv.schregid=r.schregid
        where gaayear=:fundyear and dv.schregid=:schregid
        group by dv.divdescription
        order by dv.divdescription";
    $stmt = $this->conn->prepare( $query );
    // echo $query;
    // bind id of product to be updated
    // $this->bind($stmt);
    $fundyear= $this->get_property("fundyear");
    $schtype= $this->get_property("schtype");
    $schregid= $this->get_property("schregid");
    $stmt->bindParam(":fundyear", $fundyear);
    $stmt->bindParam(":schtype", $schtype);
    $stmt->bindParam(":schregid", $schregid);
    // execute query
    $stmt->execute();
    // print_r( $this);
    return $stmt;
   
  
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
    try
    {    
        if($stmt->execute()){
            return true;
        }
        $this->lasterror=implode(" ",$stmt->errorInfo);    
    }
    catch (PDOException $e)
    {
        //   print_r($e);
        $this->lasterror="Failed to add record";  
        return false; 
    }


    // $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->fundguid= $row['fundguid'];
    $this->schoolguid= $row['schoolguid'];
    $this->schdivid= $row['schdivid'];
    $this->divguid= $row['divguid'];
    $this->rectimestamp= $row['rectimestamp'];
   }
   

           

}
