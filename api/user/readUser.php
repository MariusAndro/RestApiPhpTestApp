<?php
//required headers
header("Access-Control-Allow-Orifin");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/users.php';

//echo json_encode(
//            array("message" => "Test"));
//die();
//instantiate database and user object
$database = new Database();
$db = $database->getConnection();

//initialize object
$user = new User($db);

//query users

$stmt = $user->read();
//print_r($stmt);
$num = $stmt->num_rows;

//check if there is more than 1 row
if($num>0){    

    $users_arr = array();
    $users_arr["records"] =array();
    while ($row = $stmt->fetch_assoc()){
        //extract row
        extract($row);
        //print_r($row);
        $user_ind = array(
            "User_ID" => $row["User_ID"],
            "personal_id_number" => $row["personal_id_number"],
            "First_name" => $row["First_Name"],
            "Last_name" => $row["Last_Name"],
            "Email" => $row["Email"],
            "Country" => $row["Country"],
            "City" => $row["City"],
            "Street"=>$row["Street"],
            "Number" => $row["Number"],
            "Company_Name"=>$row["Company_Name"],
            "User_Rank"=>$row["User_Rank"]
        );
        array_push($users_arr["records"], $user_ind);
        //var_dump($users_arr);
    }
     //set response code - 200 OK
        http_response_code(200);
        
        //show users data in json format
        
        echo json_encode($users_arr);
}
else {
    //set response code to 404
    http_response_code(404);
    
    //tell the user no users found
    echo json_encode(
            array("message" => "No users found."));
}

