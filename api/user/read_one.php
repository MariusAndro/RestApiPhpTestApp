<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//include database and object files

include_once '../config/database.php';
include_once '../objects/users.php';

//get database connection
$database = new Database();
$db = $database->getConnection();

//prepare user object
$user = new User($db);

//set the id for the user we want to read
$user->userID = isset($_GET['userID']) ? $_GET["userID"] : die();

//read the details for one user
$user->readOne();

if($user->firstName !=null){
    //create array
    $user_arr = array(
        "personalIdNumber" => $user->personalIDNumber,
        "firstName" => $user->firstName,
        "lastName" => $user->lastName,
        "email" => $user->email,
        "country" => $user->country,
        "city" => $user->city,
        "street" => $user->street,
        "number" => $user->number        
    );
    //set response code code -200 OK
    http_response_code(200);
    
    //make data injson format
    echo json_encode($user_arr);
}
else {
    //set response code - 404 Not found
    http_response_code(404);
    
    //notify user does not exist
    echo json_encode(array("message"=>"User does not exist"));
}


?>

