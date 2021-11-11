<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../../../database/db.php';
include_once '../../model/user.php';

// instantiate database and product object
$database = new db();
$db = $database->getConnection();

// initialize object
$user = new user($db);

// read products will be here
$result = $user->readUser();
$rowCount = $result->rowCount();

if ($rowCount > 0) {

    $post_arr = array();
    $post_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
            'userId' => $row['userId'],
            'email' => $row['email'],
            'password' => $row['password']
        );

        array_push($post_arr['data'], $post_item);

    }
    http_response_code(200);
    echo json_encode($post_arr);

} else {
    http_response_code(404);
    echo json_encode(['message' => 'No user found']);
}