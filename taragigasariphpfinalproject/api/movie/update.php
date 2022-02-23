<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/dbms.php';
include_once '../../models/movie.php';


$database = new dbms();
$db = $database->connect();


$movie = new movie($db);


$data = json_decode((file_get_contents("php://input")));

$movie->id = $data->id;
$movie->name = $data->name;
$movie->description = $data->description;
$movie->year = intval($data->year);
$movie->poster = $data->poster;


if (isset($movie->name) && isset($movie->description) && isset($movie->year) && isset($movie->poster) && $movie->edit()) {
    echo json_encode(array('message' => 'movie has been updated.'));
} else {
    echo json_encode(array('message' => 'Error in updating.'));
}
