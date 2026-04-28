<?php

/**
 * fileuploads.class.php
 * 
 **/
class baseclass {

	//Create Connection property
	protected $conn;
	//declare table name
   	protected $table_name = "";
	//auto generated
    public $lasterror=null;
	protected $PRIMARY_KEY = array();
    protected $FIELD_SPEC = array();
	protected $FIELD_NAME = array();
	protected $FIELD_MODIFIED = array();
	protected $RESULT = array();
	protected static $FOREIGN_KEYS = array();
    protected $properties =array();
    protected $DATE_FLD = array();

    
    


	// constructor with $db as database connection
    public function __construct($db){
        // $this->conn = $db;
        
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
    // echo $fld_list;
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
    // echo $fld_list;
    return $fld_list;
    
}
function createMaxDate($tblprfx=""){
    $arr=$this->DATE_FLD;
    $fld_list="";
    $fistitem=1;
    if ($tblprfx!="") $tblprfx=$tblprfx.".";
    // print_r($arr);
    foreach ($arr as $key => $value) {
        if ($fistitem>1){
            $fld_list=$fld_list.",";
        }
        $fld_list=$fld_list."MAX(".$tblprfx.$key.") MAXDATE";
        $fistitem=$fistitem+1;
    }
    // echo $fld_list;
    return $fld_list;
    
}

function createIDQry(){
    $arr=$this->PRIMARY_KEY;
    $fld_list="";
    $fistitem=1;
    // print_r($arr);
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        //  echo "{$key} => {$value} ";
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
function IdDefined(){
    $arr=$this->PRIMARY_KEY;
    $fld_list="";
    $fistitem=1;
    // print_r($arr);
    $found=false;
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        //  echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            $found=true;
        }
        

    }
    return $found;
} 

function createWhereQry(){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        //  echo "{$key} => {$value} ";
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

function createWhereDateBetweenQry(){
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        //   echo "{$key} => {$value} ";
        if (isset($this->properties[$key])){
            // echo "{$key} => {$value} ";
            if ($fistitem>1){
                $fld_list=$fld_list." and ";
            }
            $fld_list=$fld_list.$key." between :cutoffstart and :cutoffend";
            $fistitem=$fistitem+1;
        }
        

    }
    // echo $fld_list;
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
                //  echo $key.","; //. $this->properties[$key].",";
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
                
                $this->properties[$key]=htmlspecialchars(strip_tags(preg_replace("/[\x{4e00}-\x{9fa5}]+/u", '', $this->properties[$key]))); 
            }
            
        }
        
    }

}
    

//create
function create(){
 
    // query to insert record

    $query = "INSERT INTO " . $this->table_name . " SET ".$this->createUpdFlds();
 
    // prepare query
//    echo $query;
    $stmt = $this->conn->prepare($query);
    // sanitize
    $this->sanitize();
    // bind values
    $this->bind($stmt);
    
    // $this->divguid=htmlspecialchars(strip_tags($this->divguid));
	// $this->ghouserules=htmlspecialchars(strip_tags($this->ghouserules));

    // execute query
    //  echo $query;
    // print_r($this->properties);
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
 
    // use primary key if defined 
    if ($this->IdDefined()==true){
        $where=$this->createIDQry();
    } else {
        $where=$this->createWhereQry();
    }
    $query = "delete from 
                " . $this->table_name . "
           
                WHERE ".$where;
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
    if ($this->IdDefined()==true){
        $this->bindID($stmt);
    } else {
        $this->bind($stmt);
    }
    

 
    // execute query
    if(($stmt->execute()) && ($stmt->errorCode()=="00000")){
        return true;
    }
    $this->lasterror=implode(" ",$stmt->errorInfo());
    return false;
     
   }
   function deletefiles(){
 
    // use primary key if defined 
    
    $filename=$this->get_property("FileName");
    
    $query = "delete from 
                " . $this->table_name . "
           
                WHERE Filename=?";
    // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
        //$this->guserid=htmlspecialchars(strip_tags($this->guserid));
	
    // bind values
    
    $stmt->bindParam(1, $filename);
    

 
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
    
    $query = "SELECT
                " . $this->createSelFlds() . "
            FROM
                " . $this->table_name . " 
                
            WHERE ".$this->createIDQry();
 
    // prepare query statement
    //  echo  $this->table_name;
    //  echo $this->createIDQry();
    // print_r($this->properties);
    $stmt = $this->conn->prepare( $query );
 
    
    // bind id of product to be updated
   
    $this->bindID($stmt);
    // execute query
    
    if ($this->createIDQry()!==""){
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $item_arr=$row;
        
    // print_r($row);
    } else {
        $item_arr=null;
    }
    
    // get retrieved row
    return $item_arr ;
    

   }

   function readOneUnique(){
 
    // query to read single record
    
    $query = "SELECT
                " . $this->createSelFlds() . "
            FROM
                " . $this->table_name . " 
                
            WHERE ".$this->createWhereQry();
 
    // prepare query statement
    //  echo  $this->table_name;
    //  echo $this->createIDQry();
    // print_r($this->properties);
    $stmt = $this->conn->prepare( $query );
 
    
    // bind id of product to be updated
   
    $this->bind($stmt);
    // execute query
    
    if ($this->createWhereQry()!==""){
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $item_arr=$row;
        
    // print_r($row);
    } else {
        $item_arr=null;
    }
    
    // get retrieved row
    return $item_arr ;
    

   }
   //get latest date value 
   

   function readMaxDate(){
 
    // query to read single record
    
    $query = "SELECT
                " . $this->createMaxDate() . "
            FROM
                " . $this->table_name ;
 
    // prepare query statement
    // echo $query;
    $stmt = $this->conn->prepare( $query );
 
    //  echo  $this->table_name;
    // bind id of product to be updated
   
    // $this->bindID($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    $item_arr=$row;
    // get retrieved row
    return $item_arr ;
    

   }
   //read record count
   function readRowCount(){
 
    // query to read single record
    
    $query = "SELECT
                count(*) RowCount
            FROM
                " . $this->table_name ;
 
    // prepare query statement
    // echo $query;
    $stmt = $this->conn->prepare( $query );
 
    //  echo  $this->table_name;
    // bind id of product to be updated
   
    // $this->bindID($stmt);
    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($row);
    $item_arr=$row;
    // get retrieved row
    return $item_arr ;
    

   }

   function filterColumn($col){
        $col=str_replace(" ","_",$col);
        $col=str_replace("'","",$col);
        $col=str_replace(".","",$col);
        $col=str_replace("%","_Percent",$col);
        $col=str_replace("__","_",$col);
        // if ($col=="No") $col="LineNo";
        // echo $col;s
        return $col;
   }
  function validate($collist="",$rowstr=""){
    $arr=$this->FIELD_NAME;
    $arrcols=explode("|",$collist);
    $datacols=explode("|",$rowstr);
    $colok=true;
    // print_r($arrcols);
    $this->lasterror="";
    foreach ($arrcols as $key=>$col) {
        // echo $col;
       $col=$this->filterColumn($col); 
        if (array_key_exists($col, $arr)==false) {
            // $colok=false;
            $this->lasterror=$this->lasterror."<br/> Invalid column: ".$col;
        }
      
    }
    if (count($arrcols)<count($arr)){
        $colok=false;
        $this->lasterror=$this->lasterror."<br/> Column count [".count($arrcols)."] does not match database [".count($arr)."]";
    }
    if (count($datacols)<count($arr)){
        $colok=false;
        $this->lasterror=$this->lasterror."<br/> Data row count [".count($datacols)."] does not match database [".count($arr)."] ";
    }
    return $colok;
  }
  function set_properties($collist="",$rowstr=""){
    $arr=$this->FIELD_NAME;
    $arrcols=explode("|",$collist);
    $datacols=explode("|",$rowstr);
    $colok=true;
    // print_r($arrcols);

    //replace blank with null values 

    foreach($datacols as $dkey=>$dcol){

        if ($dcol=='') {
            $datacols[$dkey]=null;
        }

    }
    $this->lasterror="";
    foreach ($arrcols as $key=>$col) {
        // echo $col;
        $col=$this->filterColumn($col); 
        // echo $col.":".$datacols[$key].":(".(strrpos(strtoupper($col),"DATE")).")</br> "; 
        $converted=false;
        //Excel Date Values
        if (( (strrpos(strtoupper($col),"DATE")!=false) && ($datacols[$key]!="")) ){
            $datacols[$key]=ExcelToPHPObject($datacols[$key]);
            $converted=true;
        }
        if ((strrpos(strtoupper($col),"DATE")>-1) && ($datacols[$key]!="") && ($converted==false))  {
            $datacols[$key]=ExcelToPHPObject($datacols[$key]);
        }
        if (( (strrpos(strtoupper($col),"TIME")!=false) && ($datacols[$key]!="")) ){
            $datacols[$key]=ExcelToPHPObject($datacols[$key]);
            $converted=true;
        }
        if ((strrpos(strtoupper($col),"TIME")>-1) && ($datacols[$key]!="") && ($converted==false))  {
            $datacols[$key]=ExcelToPHPObject($datacols[$key]);
        }

        //  echo $col.":".$datacols[$key].":".$key.",";
        if (isset($datacols[$key])){
            $this->set_property($col,$datacols[$key]);
        }
        

    }
    //  print_r($this->properties);
  }
    // read users with pagination
    public function readPaging($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        $whereparams=$this->createWhereQry();
        $whereclause="";
        if ($whereparams!=""){
            $whereclause="WHERE ".$whereparams;
        } 
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . "
            FROM
                "  .$this->table_name . " " . $tblprfx ."
                
            ".$whereclause."
            LIMIT :L1,:L2 
        ";
        // echo $query;
        // prepare query statement
        // return ;
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
    public function readCTPaging($db, $from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        
        $query = "SELECT TABLE_NAME ctable, 
                    TABLE_NAME ctabledesc
                        FROM information_schema.TABLES
                WHERE TABLE_SCHEMA = SCHEMA() /* = 'test'*/ 
                    and TABLE_NAME   LIKE 'ct_%' 
            LIMIT :L1,:L2 
        ";
        // print_r($this->conn);
        // prepare query statement
        // return ;
        $stmt = $db->prepare( $query );
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
    public function readCTDataPaging($db, $from_record_num, $records_per_page){
        $this->table_name=$this->get_property("ctable");
        $this->readCTColumns($db, $from_record_num, $records_per_page);
        $this->conn=$db;
        // print_r($this->FIELD_NAME);
        return $this->readPaging($from_record_num, $records_per_page);
    }

    public function readCTColumns($db, $from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        
        $query = "SELECT *
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = SCHEMA() AND TABLE_NAME = :ctable
           
        ";
        // print_r($this->conn);
        // prepare query statement
        // return ;
        $stmt = $db->prepare( $query );
        // bind query parameters
        $this->bind($stmt);
        // bind variable values
        $ctable=$this->get_property("ctable");
        $stmt->bindParam(":ctable", $ctable);
        // $stmt->bindParam(":L1", $from_record_num, PDO::PARAM_INT);
        // $stmt->bindParam(":L2", $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();

        $num = $stmt->rowCount();
 
        // check if more than 0 record found
        if($num>0){
        
            $fldname=null;
            $fldtype=null;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
             
                extract($row);
                $gsysmenuid_item=$row;
                $fldname=$row["COLUMN_NAME"];
                if ($row["DATA_TYPE"]=="enum"){
                    $fldtype=$row["COLUMN_TYPE"];
                } else {
                    $fldtype=$row["COLUMN_NAME"];
                }
                $fld=array($fldname=>$fldtype);
                array_push($this->FIELD_SPEC, $row);
                
                
                if (count($this->FIELD_NAME)==0) {
                    $this->FIELD_NAME=$fld;
                } else {
                    $this->FIELD_NAME=array_merge($this->FIELD_NAME, $fld);
                    // echo "test ";
                }
                
            }
            
            return $this->readColNames();
        }

        // print_r($this->FIELD_NAME);

    
        // return values from database
        return ;
    }
    public function readCTColumnsSpec(){
        return $this->FIELD_SPEC;
    }

    public function readDateRange($from_record_num, $records_per_page){
 
        // select query
        
        
        $tblprfx="a" ; 
        $whereparams=$this->createWhereDateBetweenQry();
        $whereclause="";
        if ($whereparams!=""){
            $whereclause="WHERE ".$whereparams;
        } 
        $query = "SELECT " 
                   .$this->createSelFlds($tblprfx) . "
            FROM
                "  .$this->table_name . " " . $tblprfx ."
                
            ".$whereclause."
            LIMIT :L1,:L2 
        ";
        // echo $query;
        // prepare query statement
        // return ;
        $stmt = $this->conn->prepare( $query );
        // bind query parameters
        $cutoffstart=$this->get_property("cutoffstart");
        $cutoffend=$this->get_property("cutoffend");
        $stmt->bindParam(":cutoffstart", $cutoffstart);
        $stmt->bindParam(":cutoffend", $cutoffend);
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
// used for paging user
public function DateRangecount(){
    $whereparams=$this->createWhereDateBetweenQry();
        $whereclause="";
        if ($whereparams!=""){
            $whereclause="WHERE ".$whereparams;
        } 
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " ".$whereclause;
 
    $stmt = $this->conn->prepare( $query );
    // bind query parameters
    $cutoffstart=$this->get_property("cutoffstart");
    $cutoffend=$this->get_property("cutoffend");
    $stmt->bindParam(":cutoffstart", $cutoffstart);
    $stmt->bindParam(":cutoffend", $cutoffend);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

//get Field names 
function readColNames(){
    
    $arr=$this->FIELD_NAME;
    $fld_list="";
    $fistitem=1;
    $fld_arr=array();
    $fld_arr["records"]=array();
    foreach ($arr as $key => $value) {
        $fld=array("colname"=>$key,"colvalue"=>$value);
        array_push($fld_arr["records"], $fld);

    }
    
    return $fld_arr ;
}

public function readFilenames(){
   
    $tblprfx="a" ; 


    $query =" select distinct(filename) from "  .$this->table_name . "
              where  filename like ?
              order by filename
";


    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    $filename='%'.$this->get_property("FileName").'%';
    $stmt->bindParam(1, $filename);
    
    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}               

}
