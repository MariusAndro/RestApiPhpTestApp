<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/users.php';

$utilities = new Utilities();

//instantiate database and user object
$database = new Database();
$db = $database->getConnection();

$user = new User();

$stmt = $user->readPaging($from_record_num, $records_per_page);
$num = $stmt->num_rows;

if($num>0){
    //users array
    
    $users_arr = array();
    $users_arr["records"] = array();
    $users_arr["paging"] = array();
    
    
}
?>