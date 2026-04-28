<?php
class Employee{
 
    // database connection and table name
    private $conn;
    private $table_name = "employee";
 
    // object properties
    public $employeeid;
    public $firstname;
    public $middlename;
    public $lastname;
    public $maidenname;
    public $suffix;
    public $createddatetime;
    public $createdby;
    //fields from master list
    public $dob;
    public $mobilenumber;
    public $email; 
    public $gsisbpnumber;
    public $sssnumber; 
    public $phicnumber; 
    public $pagibignumber; 
    public $tin; 
    public $bloodtype; 
    public $empposition; 
    public $divoffice;
    public $oldemployeenumber; 
    public $bureauservice; 
    public $workshift; 
    public $employeestatus;
    public $pmkey;





 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
    function read(){
 
    // select all query
    $query = "SELECT
                employee_id, firstname, middlename, lastname, maidenname, suffix, createddatetime, createdby
            FROM
                " . $this->table_name . "
            ORDER BY
                createddatetime DESC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
   }
   // create employee
   function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                employee_id=:employeeid, firstname=:firstname, middlename=:middlename, lastname=:lastname,
                maidenname=:maidenname, suffix=:suffix,  createdby=:createdby,
		dob=:dob, mobilenumber=:mobilenumber, email=:email, gsisbpnumber=:gsisbpnumber,
		sssnumber=:sssnumber, phicnumber=:phicnumber, pagibignumber=:pagibignumber, 
		tin=:tin, bloodtype=:tin, empposition=:empposition, divoffice=:divoffice,
	        oldemployeenumber=:oldemployeenumber, bureauservice=:bureauservice, 
		workshift=:workshift, employeestatus=:employeestatus,pmkey=:pmkey";


   //             name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
    //echo $query;
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    //$this->employeeid=htmlspecialchars(strip_tags($this->employeeid));
    $this->employeeid=$this->CreateEmpIdNumber();
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->middlename=htmlspecialchars(strip_tags($this->middlename));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->maidenname=htmlspecialchars(strip_tags($this->maidenname));
    $this->suffix=htmlspecialchars(strip_tags($this->suffix));
    $this->createdby=htmlspecialchars(strip_tags($this->createdby));
    //masterlist fields
    $this->dob=date('Y-m-d',strtotime(htmlspecialchars(strip_tags($this->dob)))); 
    $this->mobilenumber=htmlspecialchars(strip_tags($this->mobilenumber)); 
    $this->email=htmlspecialchars(strip_tags($this->email)); 
    $this->gsisbpnumber=htmlspecialchars(strip_tags($this->gsisbpnumber));
    $this->sssnumber=htmlspecialchars(strip_tags($this->sssnumber)); 
    $this->phicnumber=htmlspecialchars(strip_tags($this->phicnumber)); 
    $this->pagibignumber=htmlspecialchars(strip_tags($this->pagibignumber)); 
    $this->tin=htmlspecialchars(strip_tags($this->tin)); 
    $this->bloodtype=htmlspecialchars(strip_tags($this->tin)); 
    $this->empposition=htmlspecialchars(strip_tags($this->empposition)); 
    $this->divoffice=htmlspecialchars(strip_tags($this->divoffice));
    $this->oldemployeenumber=htmlspecialchars(strip_tags($this->oldemployeenumber)); 
    $this->bureauservice=htmlspecialchars(strip_tags($this->bureauservice)); 
    $this->workshift=htmlspecialchars(strip_tags($this->workshift)); 
    $this->employeestatus=htmlspecialchars(strip_tags($this->employeestatus));
    $this->pmkey=htmlspecialchars(strip_tags($this->pmkey));
  
    // bind values
 
    $stmt->bindParam(":employeeid", $this->employeeid);
    $stmt->bindParam(":firstname", $this->firstname);
    $stmt->bindParam(":middlename", $this->middlename);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":maidenname", $this->maidenname);
    $stmt->bindParam(":suffix", $this->suffix);
    $stmt->bindParam(":createdby", $this->createdby);
    //from master list 
    $stmt->bindParam(":dob", $this->dob);
    $stmt->bindParam(":mobilenumber", $this->mobilenumber); 
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":gsisbpnumber", $this->gsisbpnumber);
    $stmt->bindParam(":sssnumber", $this->sssnumber);
    $stmt->bindParam(":phicnumber", $this->phicnumber); 
    $stmt->bindParam(":pagibignumber", $this->pagibignumber); 
    $stmt->bindParam(":tin", $this->tin);
    $stmt->bindParam(":bloodtype", $this->tin); 
    $stmt->bindParam(":empposition", $this->empposition); 
    $stmt->bindParam(":divoffice", $this->divoffice);
    $stmt->bindParam(":oldemployeenumber",$this->oldemployeenumber); 
    $stmt->bindParam(":bureauservice", $this->bureauservice);
    $stmt->bindParam(":workshift", $this->workshift);
    $stmt->bindParam(":employeestatus", $this->employeestatus);
    $stmt->bindParam(":pmkey", $this->pmkey);
    // execute query
    if($stmt->execute()){
        return true;
    }
    //echo "\nPDOStatement::errorInfo():\n";
    $arr = $stmt->errorInfo();
    print_r($arr);
    //add logger
    return false;
     
   }
   // used when filling up the update product form
   function readOne(){
 
    // query to read single record
    $query = "SELECT
                employee_id, firstname, middlename, lastname, maidenname, suffix, createddatetime, createdby,
                dob, mobilenumber, email, gsisbpnumber,
		sssnumber, phicnumber, pagibignumber, 
		tin, bloodtype, empposition, divoffice,
	        oldemployeenumber, bureauservice, 
		workshift, employeestatus, pmkey
            FROM
                " . $this->table_name . " 
            WHERE
                employee_id = ?
            LIMIT
                0,1";
    //echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->employeeid);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
 
    // set values to object properties
    // sanitize
    $this->employeeid=htmlspecialchars(strip_tags( $row['employee_id']));
    $this->firstname=htmlspecialchars(strip_tags( $row['firstname']));
    $this->middlename=htmlspecialchars(strip_tags( $row['middlename']));
    $this->lastname=htmlspecialchars(strip_tags( $row['lastname']));
    $this->maidenname=htmlspecialchars(strip_tags( $row['maidenname']));
    $this->suffix=htmlspecialchars(strip_tags( $row['suffix']));
    $this->createdby=htmlspecialchars(strip_tags( $row['createdby']));
    //masterlist fields
    $this->dob=date('Y-m-d',strtotime(htmlspecialchars(strip_tags( $row['dob'])))); 
    $this->mobilenumber=htmlspecialchars(strip_tags( $row['mobilenumber'])); 
    $this->email=htmlspecialchars(strip_tags( $row['email'])); 
    $this->gsisbpnumber=htmlspecialchars(strip_tags( $row['gsisbpnumber']));
    $this->sssnumber=htmlspecialchars(strip_tags( $row['sssnumber'])); 
    $this->phicnumber=htmlspecialchars(strip_tags( $row['phicnumber'])); 
    $this->pagibignumber=htmlspecialchars(strip_tags( $row['pagibignumber'])); 
    $this->tin=htmlspecialchars(strip_tags( $row['tin'])); 
    $this->bloodtype=htmlspecialchars(strip_tags( $row['tin'])); 
    $this->empposition=htmlspecialchars(strip_tags( $row['empposition'])); 
    $this->divoffice=htmlspecialchars(strip_tags( $row['divoffice']));
    $this->oldemployeenumber=htmlspecialchars(strip_tags( $row['oldemployeenumber'])); 
    $this->bureauservice=htmlspecialchars(strip_tags( $row['bureauservice'])); 
    $this->workshift=htmlspecialchars(strip_tags( $row['workshift'])); 
    $this->employeestatus=htmlspecialchars(strip_tags( $row['employeestatus']));
    $this->pmkey=htmlspecialchars(strip_tags( $row['pmkey']));
   
   }
   // update the product
   function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                firstname=:firstname, middlename=:middlename, lastname=:lastname, maidenname=:maidenname, suffix=:suffix,
 	        dob=:dob, mobilenumber=:mobilenumber, email=:email, gsisbpnumber=:gsisbpnumber,
		sssnumber=:sssnumber, phicnumber=:phicnumber, pagibignumber=:pagibignumber, 
		tin=:tin, bloodtype=:tin, empposition=:empposition, divoffice=:divoffice,
	        oldemployeenumber=:oldemployeenumber, bureauservice=:bureauservice, 
		workshift=:workshift, employeestatus=:employeestatus, pmkey=:pmkey
            WHERE
                employee_id = :employeeid";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->middlename=htmlspecialchars(strip_tags($this->middlename));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->maidenname=htmlspecialchars(strip_tags($this->maidenname));
    $this->suffix=htmlspecialchars(strip_tags($this->suffix));
    //masterlist fields
    $this->dob=htmlspecialchars(strip_tags($this->dob)); 
    $this->mobilenumber=htmlspecialchars(strip_tags($this->mobilenumber)); 
    $this->email=htmlspecialchars(strip_tags($this->email)); 
    $this->gsisbpnumber=htmlspecialchars(strip_tags($this->gsisbpnumber));
    $this->sssnumber=htmlspecialchars(strip_tags($this->sssnumber)); 
    $this->phicnumber=htmlspecialchars(strip_tags($this->phicnumber)); 
    $this->pagibignumber=htmlspecialchars(strip_tags($this->pagibignumber)); 
    $this->tin=htmlspecialchars(strip_tags($this->tin)); 
    $this->bloodtype=htmlspecialchars(strip_tags($this->tin)); 
    $this->empposition=htmlspecialchars(strip_tags($this->empposition)); 
    $this->divoffice=htmlspecialchars(strip_tags($this->divoffice));
    $this->oldemployeenumber=htmlspecialchars(strip_tags($this->oldemployeenumber)); 
    $this->bureauservice=htmlspecialchars(strip_tags($this->bureauservice)); 
    $this->workshift=htmlspecialchars(strip_tags($this->workshift)); 
    $this->employeestatus=htmlspecialchars(strip_tags($this->employeestatus));
    $this->pmkey=htmlspecialchars(strip_tags($this->pmkey));

    // bind new values
    $stmt->bindParam(":employeeid", $this->employeeid);
    $stmt->bindParam(":firstname", $this->firstname);
    $stmt->bindParam(":middlename", $this->middlename);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":maidenname", $this->maidenname);
    $stmt->bindParam(":suffix", $this->suffix);
    //from master list 
    $stmt->bindParam(":dob", $this->dob);
    $stmt->bindParam(":mobilenumber", $this->mobilenumber); 
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":gsisbpnumber", $this->gsisbpnumber);
    $stmt->bindParam(":sssnumber", $this->sssnumber);
    $stmt->bindParam(":phicnumber", $this->phicnumber); 
    $stmt->bindParam(":pagibignumber", $this->pagibignumber); 
    $stmt->bindParam(":tin", $this->tin);
    $stmt->bindParam(":bloodtype", $this->tin); 
    $stmt->bindParam(":empposition", $this->empposition); 
    $stmt->bindParam(":divoffice", $this->divoffice);
    $stmt->bindParam(":oldemployeenumber",$this->oldemployeenumber); 
    $stmt->bindParam(":bureauservice", $this->bureauservice);
    $stmt->bindParam(":workshift", $this->workshift);
    $stmt->bindParam(":employeestatus", $this->employeestatus);
    $stmt->bindParam(":pmkey", $this->pmkey);

    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
    }
    // delete the product
   function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
    }
    // search employee
    function search($keywords){
 
    // select all query
   
    $query = "SELECT
                employee_id, firstname, middlename, lastname, maidenname, suffix, createddatetime, createdby
            FROM
                " . $this->table_name . "
	    WHERE
                firstname like ?  OR 
                middlename  like ? OR 
	        lastname  like ?
            ORDER BY
                createddatetime DESC";


    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
// read products with pagination
public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                employee_id, firstname, middlename, lastname, maidenname, suffix, createddatetime, createdby
            FROM
                " . $this->table_name . "
            ORDER BY
                createddatetime DESC

            LIMIT ?, ?";
 
    // prepare query statement
    //echo $query;
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}
// used for paging products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function EmpIdExists($empid){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "where empoyee_id='".$empid."'";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}



/* Append modulus 11 check digit to supplied string of digits. */


public function CreateEmpIdNumber() {
   /* create random 6 numbers */ 
   /* generate number with Check Digit */

   $empid ="n/a";
   $checkdigit="";
   $exists=1;
  
   //while (($empid=="n/a")||($checkdigit=="")||($checkdigit=="1")) {
   while (strlen($empid)!=9) {
      $eight_digit_random_number = mt_rand(00000001, 99999999);
      $empid = $this->GenMOD11($eight_digit_random_number);
      $exists=$this->EmpIdExists($empid);
      echo $exists;
      //Generatelog($empid);
      //$checkdigit=substr($empid,8,1);
   }
  
   /* EDU-XX-XXXXXX-Y */
   return substr($empid,0,2)."-".substr($empid,2,6)."-".substr($empid,8,1) ;

}



public function GenMOD11( $base_val )
{
   $result = "";
   $weight = array( 2, 3, 4, 5, 6, 7,
                    2, 3, 4, 5, 6, 7,
                    2, 3, 4, 5, 6, 7,
                    2, 3, 4, 5, 6, 7 );

   /* For convenience, reverse the string and work left to right. */
   $reversed_base_val = strrev( $base_val );
   for ( $i = 0, $sum = 0; $i < strlen( $reversed_base_val ); $i++ )
   {
      /* Calculate product and accumulate. */
      $sum += substr( $reversed_base_val, $i, 1 ) * $weight[ $i ];
   }

   /* Determine check digit, and concatenate to base value. */
   $remainder = $sum % 11;
   switch ( $remainder )
   {
   case 0:
      $result = $base_val . 0;
      break;
   case 1:
      $result = "n/a";
      break;
   default:
      $check_digit = 11 - $remainder;
      $result = $base_val . $check_digit;
      break;
   }

   return $result;
}

}