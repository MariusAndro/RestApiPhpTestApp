<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object files
include_once '../config/database.php';
include_once '../objects/users.php';

//get database connection
$database = new Database();
$db = $database->getConnection();

//prepare user object
$user = new User($db);

//get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

//set id property of user to be edited


//set user properties values
$user->personalIDNumber = $data->personal_id_number;
$user->firstName = $data->First_name;
$user->lastName = $data->Last_name;
$user->email = $data->Email;
$user->password = $data->Password;
$user->country = $data->Country;
$user->city = $data->City;
$user->street = $data->Street;
$user->number = $data->Number;
$user->company = $data->Company;
$user->rank = $data->Rank;


//update
if($user->update()){
    //set response code - 200 ok
    http_response_code(200);

    echo json_encode(array("message"=>"Users data has been updated"));
}
else{
  //set response code - 503 service unavailable
  http_response_code(503);

  echo json_encode(array("message"=>"Unable to update"));

}
