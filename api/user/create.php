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
$data = file_get_contents("php://input");

$data= json_decode($data);


$personal = $data->personal_id_number;

//check if the data is not empty

if(!empty($data->personal_id_number) &&
        !empty($data->First_name) &&
        !empty($data->Last_name) &&
        !empty($data->Email) &&
        !empty($data->Password) &&
        !empty($data->Country) &&
        !empty($data->City) &&
        !empty($data->Street) &&
        !empty($data->Number) &&
        !empty($data->company_id) &&
        !empty($data->Rank)
){
    
    //set User's properties
    $user->personalIDNumber = $personal;
    $user->firstName = $data->First_name;
    $user->lastName = $data->Last_name;
    $user->email = $data->Email;
    $user->password = $data->Password;
    $user->company = $data->company_id;
    $user->rank = $data->Rank;
    $user->country = $data->Country;
    $user->city = $data->City;
    $user->street = $data->Street;
    $user->number = $data->Number;
        
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