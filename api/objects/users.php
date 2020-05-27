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

            $rquery = "SELECT a.User_ID, a. personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, b.City, b.Street, b.Number"
                    . ",c.Company_Name,c.User_Rank FROM users a LEFT JOIN users_adress b on a.User_ID = b.User_ID "
                    . " LEFT JOIN (SELECT a.User_ID, a.User_Rank,b.Company_Name FROM users_company a LEFT JOIN company b ON a.Company_ID=b.Company_ID)c ON a.User_ID = c.User_ID";

            $stmt = $this->connection->query($rquery);

            if (!$stmt) {
                trigger_error('Invalid query: ' . $this->conn->error);
            }

            //execute query
            //$stmt->execute();
            return $stmt;
        }

        function create(){

            //if($this->checkUniqueCnp() && $this->checkUniqueEmail())
            if(true){

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
            else{
                return false;
            }
        }
        //check if personal id number and email are unique
        function checkUniqueCnp(){
            $cnp = htmlspecialchars($this->connection->real_escape_string($this->personalIDNumber));
            $squery = "SELECT a. personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, b.City, b.Street, b.Number FROM users a LEFT JOIN users_adress b on a.User_ID = b.User_ID WHERE a. personal_id_number = ".$cnp ;

            $stmt = $this->connection->query($squery);

            $row = $stmt->fetch_assoc();
            if($stmt->num_rows>0){
                //set values to the object properties
                return false;
            }
            else{
                return true;
            }

        }

        function checkUniqueEmail(){
            $email = htmlspecialchars($this->connection->real_escape_string($this->email));
            $squery = "SELECT a. personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, b.City, b.Street, b.Number FROM users a LEFT JOIN users_adress b on a.User_ID = b.User_ID WHERE a. personal_id_number = ".$email ;

            $stmt = $this->connection->query($squery);

            $row = $stmt->fetch_assoc();
            if($stmt->num_rows>0){
                //set values to the object properties
                return false;
            }
            else{
                return true;
            }

        }

        function checkCompany(){
            $company = htmlspecialchars($this->connection->real_escape_string($this->company));
            $squery = "SELECT a. personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, b.City, b.Street, b.Number FROM users a LEFT JOIN users_adress b on a.User_ID = b.User_ID WHERE a. personal_id_number = ".$company;

            $stmt = $this->connection->query($squery);

            $row = $stmt->fetch_assoc();
            if($stmt->num_rows>0){
                //set values to the object properties
                return false;
            }
            else{
                return true;
            }
        }

        //used when filling the update user form
        function readOne(){
            //query to select single user
            $squery = "SELECT a.User_ID, a. personal_id_number, a.First_Name, a.Last_Name, a.Email,a.Password, b.Country, b.City, b.Street, b.Number"
                    . ",c.Company_Name,c.User_Rank FROM users a LEFT JOIN users_adress b on a.User_ID = b.User_ID "
                    . " LEFT JOIN (SELECT a.User_ID, a.User_Rank,b.Company_Name FROM users_company a LEFT JOIN company b ON a.Company_ID=b.Company_ID)c ON a.User_ID = c.User_ID WHERE a.User_ID = ".intval($this->userID) ;

            $stmt = $this->connection->query($squery);

            //get retrieved row

            $row = $stmt->fetch_assoc();
            if($stmt->num_rows>0){
            //set values to the object properties
            $this->personalIDNumber = $row['personal_id_number'];
            $this->firstName = $row['First_Name'];
            $this->lastName = $row['Last_Name'];
            $this->email = $row['Email'];
            $this->password = $row['Password'];
            $this->country = $row['Country'];
            $this->city = $row['City'];
            $this->street = $row['Street'];
            $this->number = $row['Number'];
            $this->company = $row["Company_Name"];
            $this->rank = $row["User_Rank"];
            }
            else{
                $this->firstName = "";
            }

        }

        //update user data
        function update(){
            $vCNP = htmlspecialchars($this->connection->real_escape_string($this->personalIDNumber));

            //Extract user ID
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

            //Extract the Company ID
            $company = htmlspecialchars($this->connection->real_escape_string($this->company));
            $selectUserDetail = "SELECT Company_ID FROM company WHERE Company_Name = '".$company."'";
            $cobj = $this->connection->query($selectUserDetail);


            if($this->connection->connect_errno){
                die("Connection failed: " . $this->connection->connect_error);
            }

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

            $uc=intval($uc);

            $updateUserAdress = "UPDATE users, users_adress,users_company SET users.personal_id_number=?,users.First_Name=?,users.Last_Name=?,users.Email=?,"
                    . " users.Password=?, users_adress.Country =?, users_adress.City =?, users_adress.Street =?,"
                    . " users_adress.Number =?, users_company.Company_ID=?, users_company.User_Rank=?"
                    . " WHERE users.User_ID =? AND users_adress.User_ID=? AND users_company.User_ID=?";

            //$vCNP = htmlspecialchars($this->connection->real_escape_string($this->personalIDNumber));
            $vFirstName = htmlspecialchars($this->connection->real_escape_string($this->firstName));
            $vLastName = htmlspecialchars($this->connection->real_escape_string($this->lastName));
            $vEmail = htmlspecialchars($this->connection->real_escape_string($this->email));
            $vPassword = htmlspecialchars($this->connection->real_escape_string($this->password));
            $vCountry = htmlspecialchars($this->connection->real_escape_string($this->country));
            $vCity = htmlspecialchars($this->connection->real_escape_string($this->city));
            $vStreet = htmlspecialchars($this->connection->real_escape_string($this->street));
            $vNumber = htmlspecialchars($this->connection->real_escape_string($this->number));
            $vCompany = $uc;
            $vRank = htmlspecialchars($this->connection->real_escape_string($this->rank));
            $id = intval($ui);

            $userAdressStmt = $this->connection->prepare($updateUserAdress);

            $userAdressStmt->bind_param("sssssssssisiii",$vCNP,$vFirstName,$vLastName,$vEmail,$vPassword,$vCountry,$vCity,$vStreet,$vNumber,$vCompany,$vRank,$id,$id,$id);
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
        //read users with pagination
        public function readPaging($from_record_num, $records_per_page){
            var_dump($from_record_num);
            var_dump($records_per_page);
            //select query
            $rquery = "SELECT a.User_ID, a. personal_id_number, a.First_Name, a.Last_Name, a.Email, b.Country, b.City, b.Street, b.Number FROM "
                    . "users a LEFT JOIN users_adress b on a.User_ID = b.User_ID "; //LIMIT ".$from_record_num.", ".$records_per_page;

            $stmt = $this->connection->query($rquery);

            if (!$stmt) {
                trigger_error('Invalid query: ' . $this->conn->error);
            }
            return $stmt;
        }

        //method used for paging users
        public function count(){
            $query = "SELECT COUNT(*) AS total_rows FROM users";
            $stmt = $this->connection->query($query);

            $row = $stmt->fetch_assoc();
            return $row['total_rows'];
        }

        //check if given email exists in the database
        function emailExists(){
            //query to check if email exists
            $query =" SELECT a.User_ID, a. personal_id_number, a.First_Name, a.Last_Name, a.Email, a.Password"
                    . "FROM users a WHERE a.Email = ? ";

            //prepare query
            $stmt = $this->connection->prepare($query);

            //sanitize
            $this->email = htmlspecialchars(strip_tags($this->email));
            $vEmaill = $this->email;

            //bind given email value
            $stmt->bind_param("s", $vEmaill);

            //execute
            var_dump($stmt->execute());

            if($stmt->num_rows>0)
        {
            while($s = $stmt->fetch_assoc())
            {
                $this->userID = $s['User_ID'];
                $this->firstName = $s["First_Name"];
                $this->lastName = $s["Last_name"];
                $this->password = $s["Password"];

                return true;
            }
        }
        return false;
        }
    }
