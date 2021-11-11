<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../../../database/db.php';
include_once '../../model/user.php';

// instantiate database and product object
$database = new db();
$db = $database->getConnection();

// initialize object
$user = new user($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!empty($data->name) && !empty($data->email) && !empty($data->password)){

    // set user property values
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;
//    $user->created = date('Y-m-d H:i:s');

    //create the user
    if($user->createUser()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "User was created."));

    } else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }

}else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
}