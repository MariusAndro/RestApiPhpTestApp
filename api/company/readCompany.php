<?php
//required headers
header("Access-Control-Allow-Orifin");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/company.php';

//instantiate database and user object
$database = new Database();
$db = $database->getConnection();

//initialize object
$company = new Company($db);

//query users

$stmt = $company->read();
$num = $stmt->num_rows;
//check if there is more than 1 row
if($num>0){
    

    $company_arr = array();
    $company_arr["records"] =array();
    while ($row = $stmt->fetch_assoc()){
        //extract row
        extract($row);
        
        $company_ind = array(
            "Company_ID" => $row["Company_ID"],
            "Company_Name" => $row["Company_Name"],
            "Company_Rank" => $row["Company_Rank"],            
            "Main_Country" => $row["Main_Country"],
            "Main_City" => $row["Main_City"],
            "Main_Street" => $row["Main_Street"],
            "Main_Number" => $row["Main_Number"],
            "Secondary_Country" => $row["Secondary_Country"],
            "Secondary_City" => $row["Secondary_City"],
            "Secondary_Street" => $row["Secondary_Street"],
            "Secondary_Number" => $row["Secondary_Number"]
        );
        array_push($company_arr["records"], $company_ind);        
    }
    //set response code - 200 OK
        http_response_code(200);
        
        //show users data in json format
        echo json_encode($company_arr);
}
else {
    //set response code to 404
    http_response_code(404);
    
    //tell the user no users found
    echo json_encode(
            array("message" => "No companies found."));
}

?>
