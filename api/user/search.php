<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/users.php';

//instantiate database and user object
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

//get keywords

$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

//query products
$stmt = $user->search($keywords);
$num = $stmt->num_rows;

//check if more than 0 records
//var_dump($num);
if($num>0){
    //users array
    $users_arr = array();
    $users_arr["records"]=array();
    while ($row = $stmt->fetch_assoc()){
        //extract row
        extract($row);
        //print_r($row);
        $user_ind = array(            
            "personal_id_number" => $row["personal_id_number"],
            "First_name" => $row["First_Name"],
            "Last_name" => $row["Last_Name"],
            "Email" => $row["Email"],
            "Country" => $row["Country"],
            "City" => $row["City"],
            "Number" => $row["Street"]
        );
        array_push($users_arr["records"], $user_ind);
 
        //set response code - 200 OK
        http_response_code(200);
        
        //show users data in json format
        echo json_encode($user_ind);
        }
    }
    else {
    //set response code to 404
    http_response_code(404);
    
    //tell the user no users found
    echo json_encode(
            array("message" => "No users found."));
    }

?>