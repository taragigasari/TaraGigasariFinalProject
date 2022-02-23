<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/dbms.php';
include_once '../../models/movie.php';


$database = new dbms();
$db = $database->connect();


$newMovie = new movie($db);


$data = json_decode((file_get_contents("php://input")));

$newMovie->name = $data->name;
$newMovie->description = $data->description;
$newMovie->year = intval($data->year);
$newMovie->poster = $data->poster;


if (isset($newMovie->name) && isset($newMovie->description) && isset($newMovie->year) && isset($newMovie->poster) && $newMovie->create()) {
    echo json_encode(array('message' => 'Movie is added.'));
} else {
    echo json_encode(array('message' => 'Error in adding.'));
}
