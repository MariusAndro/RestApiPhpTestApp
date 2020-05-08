<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//get database connection
include_once '../config/database.php';
include_once '../objects/users.php';
$datbase = new Database();
$db = $datbase->getConnection();

$user = new User($db);

//get posted data
$data = json_decode(file_get_contents("php://input"));
//var_dump($data->personalIDnumb);
$personal = $data->personalIDnumb;

//check if the data is not empty
if(!empty($data->personalIDnumb) &&
        !empty($data->firstName) &&
        !empty($data->lastName) &&
        !empty($data->email) &&
        !empty($data->password) &&
        !empty($data->country) &&
        !empty($data->city) &&
        !empty($data->street) &&
        !empty($data->number) &&
        !empty($data->company) &&
        !empty($data->rank)
){
    
    //set User's properties
    $user->personalIDNumber = $personal;
    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;
    $user->email = $data->email;
    $user->password = $data->password;
    $user->company = $data->company;
    $user->rank = $data->rank;
    $user->country = $data->country;
    $user->city = $data->city;
    $user->street = $data->street;
    $user->number = $data->number;
    
    
    //create the product
    
    if ($user->create()){
        //set response code - 201 created
        http_response_code(201);
        
        //tell the user
        echo json_encode(array("message" => "User was created"));
    }
    else{
        //set response code - 503 service unavailable
        http_response_code(503);
        
        //tell the user
        echo json_encode(array("message"=>"Unable to create user!"));
    }
}
//tell the user data is incomplete
else{
    //set response code - 400 bad request
    http_response_code(400);
    
    //tell the user
    echo json_encode(array("message"=>"Unable to create user. Data is incomplete!"));
    
}

?>