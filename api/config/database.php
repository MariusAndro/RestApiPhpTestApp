<?php

class Database{
    //$_SESSION['userID'] = 2;


    private $password = "";
    private $user_name = "root";
    private $host = "localhost";
    private $db_name = "usermanagement";

    public function getConnection(){
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host,$this->user_name,$this->password,$this->db_name);
        } catch (mysqli_sql_exception $exception) {
            echo "Connection error: " .$exception->getMessage();
        }
        
        return $this->conn;
    }
}

