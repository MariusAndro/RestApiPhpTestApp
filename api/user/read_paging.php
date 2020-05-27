<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/users.php';

$utilities = new Utilities();

//instantiate database and user object
$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$stmt = $user->readPaging($from_record_num, $records_per_page);
$num = $stmt->num_rows;

if($num>0){
    //users array
    
    $users_arr = array();
    $users_arr["records"] = array();
    $users_arr["paging"] = array();
    
    while ($row = $stmt->fetch_assoc()){
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
            "Number" => $row["Street"]
        );
        array_push($users_arr["records"], $user_ind);
    }
    
    //include paging
    $total_rows = $user->count();
    $page_url= "{$home_url}user/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $users_arr["paging"] = $paging;
    
    //set response code - 200 OK
    http_response_code(200);
    
    //make it json format
    echo json_encode($users_arr);   
}
else {
    //set response code - 404 Not found
    http_response_code(404);
    
    echo json_encode(array("message"=> "No users found"));
}
?>