<?php
class Database{
 
    // specify your own database credentials
    //Dev or local host
    private $host = "localhost"; 
    private $username = "root";
    private $password = "";
    private $db_name = "mooe";

    //prod
    // private $host = "mooe-prod-db.mysql.database.azure.com"; 
    // private $username = "deped_mooe_admin@mooe-prod-db";
    // private $password = "Production_web";
    // private $db_name = "mooe";

   
 


    // get the database connection
    public function getConnection(){
 
        $this->conn = null;

        //set timezone to mysql 

        $now = new DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = ($mins < 0 ? -1 : 1);
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;
        $offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);

        //increase db timeout
        ini_set('mysql.connect_timeout', 300);
        ini_set('default_socket_timeout', 300); 

        //
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET time_zone='$offset';");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>