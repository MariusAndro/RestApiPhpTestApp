<?php

class Company{
    //database connection and table name
    private $connection;
    
    //object properties
    public $companyID;
    public $companyName;
    public $companyRank;
    //company adress properties
    // Main adress is manadatory, secondary adress is optional
    public $mainCountry;
    public $mainCity;
    public $mainStreet;
    public $mainNumber;    
    public $secondaryCountry;
    public $secondaryCity;
    public $secondaryStreet;
    public $secondaryNumber;            
    
    public function __construct($db){
        $this->connection = $db;
    }
    
    function read(){
        $rquery = "SELECT a.Company_ID, a.Company_Name, a.Company_rank, b.Main_Country, b.Main_City, b.Main_Street, b.Main_Number,"
                . " b.Secondary_Country, b.Secondary_City, b.Secondary_Street, b.Secondary_Number FROM company a "
                . "LEFT JOIN company_adress b ON a.Company_ID = b.Company_ID";
            
                        
            $stmt = $this->connection->query($rquery);
            //var_dump($stmt);
            if (!$stmt) {
                trigger_error('Invalid query: ' . $this->conn->error);
            }            
            return $stmt;        
    }
    
    function create(){
        
    }
}

?>