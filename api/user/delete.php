<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object file
include_once '../config/database.php';
include_once '../objects/users.php';

//get database connection
$database = new Database();
$db = $database->getConnection();

$user = new User($db);

//get user id
$data = json_decode(file_get_contents("php://input"));

//set product to be deleted
$user->userID = $data->userID;

//delete product
if($user->delete()){
    //set response code - 200 ok
    http_response_code(200);
    
    echo json_encode(array("message"=>"User was deleted!"));
}
else{
    //set response code - 503 service unavialble
    http_response_code(503);
    
    echo json_encode(array("message"=>"Unable to delete user"));
}

?>

