<?php
//show error reporting
ini_set('display errors', 1);
error_reporting(E_ALL);

//set default time zone
date_default_timezone_set('Europe/Bucharest');

// variables used for jwt
$key = "example_key";
$iss = "http://example.org";
$aud = "http://example.com";
$iat = 1356999524;
$nbf = 1357000000;

////home page url
//$home_url = "http://localhost:8080/NetBeans/UserManagement/RestApiPhpTestApp/api/";
//
////page given in URL parameter, default page is one
//$page = isset($_GET['page']) ? $_GET['page'] : 1;
//
////set number of records per page
//$records_per_page = 10;
//
////calculate for the query LIMIT clause
//$from_record_num = ($records_per_page * $page) - $records_per_page;
//var_dump($from_record_num);