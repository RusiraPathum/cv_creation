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

// set ID property of product to be edited
$user->userId = $data->userId;

// make sure data is not empty
if(!empty($data->userId) && !empty($data->name) && !empty($data->email) && !empty($data->password)){

    // set user property values
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;
//    $user->created = date('Y-m-d H:i:s');

    // update the product
    if($user->update()){

        // set response code - 200 ok
        http_response_code(200);

        // tell the user
        echo json_encode(array("message" => "User was updated."));
    } else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to update user."));
    }

}else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to update user. Data is incomplete."));
}