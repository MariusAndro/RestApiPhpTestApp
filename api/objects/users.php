<?php

    class User{
        //database connection and table
        private $connection;
        //private $table_name = "users";
        
        //objecty properties
        public $userID;
        public $personalIDNumber;
        public $firstName;
        public $lastName;
        public $email;
        public $password;
        public $country;
        public $city;
        public $street;
        public $number;
        public $company;
        public $rank;
        
        //constructor with $db as database connection
        public function __construct($db){
            $this->connection = $db;
        }
        
        function read(){
            //select query
            
            $rquery = "SELECT a.User_ID, a. personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, b.City, b.Street, b.Number FROM users a LEFT JOIN users_adress b on a.User_ID = b.User_ID";
            
            
            // prepare statement
            $stmt = $this->connection->query($rquery);
            
            if (!$stmt) {
                trigger_error('Invalid query: ' . $this->conn->error);
            }
            
            //execute query
            //$stmt->execute();
            return $stmt;
        }
        
        function create(){
            
            $insertUser = "INSERT INTO users (personal_id_number,First_name, Last_name, Email, Password)"
        . "VALUES (?,?,?,?,?)";
                        
        
        $vCNP = htmlspecialchars($this->connection->real_escape_string($this->personalIDNumber));
        $vFirstName = htmlspecialchars($this->connection->real_escape_string($this->firstName));
        $vLastName = htmlspecialchars($this->connection->real_escape_string($this->lastName));
        $vEmail = htmlspecialchars($this->connection->real_escape_string($this->email));
        $vPswd = htmlspecialchars($this->connection->real_escape_string($this->password));
               
        //prepare query
        $userStmt = $this->connection->prepare($insertUser);
        $userStmt->bind_param("sssss",$vCNP,$vFirstName,$vLastName,$vEmail,$vPswd);
                
        $userStmt->execute();                
        
        //Extract the User ID
        $selectUserDetail = "SELECT User_ID FROM users WHERE personal_id_number = ".$vCNP;
        $iobj = $this->connection->query($selectUserDetail);

        if($this->connection->connect_errno){
            die("Connection failed: " . $this->connection->connect_error);
        } 

        if($iobj->num_rows>0)
        {
            while($s = $iobj->fetch_assoc())
            {                  
                $ui = $s['User_ID'];
            }
        }
        
        $insertUserAdress = "INSERT INTO users_adress (User_ID,Country, City, Street, Number)"
        . "VALUES (?,?,?,?,?)";
        
        $vUserId = $ui;
        $vCountry = htmlspecialchars($this->connection->real_escape_string($this->country));
        $vCity = htmlspecialchars($this->connection->real_escape_string($this->city));
        $vStreet = htmlspecialchars($this->connection->real_escape_string($this->street));
        $vNumber = htmlspecialchars($this->connection->real_escape_string($this->number));        
               
        $userAdressStmt = $this->connection->prepare($insertUserAdress);
        $userAdressStmt->bind_param("issss",$vUserId,$vCountry,$vCity,$vStreet,$vNumber);
                
        
        $userAdressStmt->execute();
        
        //Extract the Company ID
        $company = htmlspecialchars($this->connection->real_escape_string($this->company));
        $selectUserDetail = "SELECT Company_ID FROM company WHERE Company_Name = '".$company."'";        
        $cobj = $this->connection->query($selectUserDetail);
        
        //var_dump($company);
        
        if($this->connection->connect_errno){
            die("Connection failed: " . $this->connection->connect_error);
        } 
        //var_dump($cobj->num_rows);
        if($cobj->num_rows>0)
        {
            while($s = $cobj->fetch_assoc())
            {                  
                $uc = $s['Company_ID'];
            }
        }
        else{
            //echo json_encode(array("message"=>"Add company"));
        }                        
        //var_dump($uc);
        $insertUserCompany = "INSERT INTO users_company (User_ID, Company_ID, User_Rank)"
        . "VALUES (?,?,?)";
        
        $vUId = $ui;
        $vCompanyId = $uc; 
        $vRank = htmlspecialchars($this->connection->real_escape_string($this->rank));        
                
        $userCompanyStmt = $this->connection->prepare($insertUserCompany);
        $userCompanyStmt->bind_param("iis",$vUId, $vCompanyId,$vRank);
        
        if($userCompanyStmt->execute()){        
            return true;
        }
        return false;
        }
        
        //used when filling the update user form
        function readOne(){
            //query to select single user
            $squery = "SELECT a.User_ID, a. personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, b.City, b.Street, b.Number FROM users a LEFT JOIN users_adress b on a.User_ID = b.User_ID WHERE a.User_ID = ".intval($this->userID) ;
            
            $stmt = $this->connection->query($squery);
            
            //get retrieved row
           
            $row = $stmt->fetch_assoc();
            if($stmt->num_rows>0){
            //set values to the object properties
            $this->personalIDNumber = $row['personal_id_number'];
            $this->firstName = $row['First_Name'];
            $this->lastName = $row['Last_Name'];
            $this->email = $row['Email'];
            $this->country = $row['Country'];
            $this->city = $row['City'];            
            $this->street = $row['Street'];
            $this->number = $row['Number'];
            }
            else{
                $this->firstName = "";
            }
            
        }
        
        //update user data
        function update(){
            
            $updateUserAdress = "UPDATE users, users_adress SET users.personal_id_number=?,users.First_Name=?,users.Last_Name=?,users.Email=?,"
                    . " users.Password=?, users_adress.Country =?, users_adress.City =?, users_adress.Street =?,"
                    . " users_adress.Number =? WHERE users.User_ID =? AND users_adress.User_ID=?";        
            
            $vCNP = htmlspecialchars($this->connection->real_escape_string($this->personalIDNumber));
            $vFirstName = htmlspecialchars($this->connection->real_escape_string($this->firstName));
            $vLastName = htmlspecialchars($this->connection->real_escape_string($this->lastName));
            $vEmail = htmlspecialchars($this->connection->real_escape_string($this->email));
            $vPassword = htmlspecialchars($this->connection->real_escape_string($this->password));                        
            $vCountry = htmlspecialchars($this->connection->real_escape_string($this->country)); 
            $vCity = htmlspecialchars($this->connection->real_escape_string($this->city)); 
            $vStreet = htmlspecialchars($this->connection->real_escape_string($this->street)); 
            $vNumber = htmlspecialchars($this->connection->real_escape_string($this->number));         
            $id = intval($this->userID);
            
            $userAdressStmt = $this->connection->prepare($updateUserAdress);
            
            $userAdressStmt->bind_param("sssssssssii",$vCNP,$vFirstName,$vLastName,$vEmail,$vPassword,$vCountry,$vCity,$vStreet,$vNumber,$id,$id);
            
            if($userAdressStmt->execute()){
                return true;
            }
            else{
                return false;
            }
            
        }
        
        //delete user data
        function delete(){
            
            //delete from users table
            $deleteUser = "DELETE FROM users WHERE User_ID = ?";
            
            $stmtOne = $this->connection->prepare($deleteUser);
            $id = intval($this->userID);
            
            $stmtOne->bind_param("i",$id);
            
            //delete from users_adress table
            $deleteUserFromAdress = "DELETE FROM users_adress WHERE User_ID = ?";
            $stmtTwo = $this->connection->prepare($deleteUserFromAdress);            
            
            $stmtTwo->bind_param("i",$id);
            
            //delete from users_company table
            $deleteFromUsersCompany = "DELETE FROM users_company WHERE User_ID = ?";
            $stmtThree = $this->connection->prepare($deleteFromUsersCompany);            
            
            $stmtThree->bind_param("i",$id);
            
            // execute query
            if($stmtOne->execute() && $stmtTwo->execute() && $stmtThree->execute()){
                return true;
            }

            return false;

        }
        
        //search users
        function search($keywords){
            
            //sanitize
            $keywords = htmlspecialchars(strip_tags($keywords));
            $keywords = "%{$keywords}%";
            
            //select all query
            $squery = "SELECT a.personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, "
                    . "b.City, b.Street, b.Number FROM users a "
                    . "LEFT JOIN users_adress b on a.User_ID = b.User_ID WHERE b.Country LIKE '".$keywords."' OR b.City LIKE '".$keywords
                    . "' OR b.Street LIKE '".$keywords."'";
                        
            $stmt = $this->connection->query($squery);            
            
            return $stmt;
            
        }
    }

?>
