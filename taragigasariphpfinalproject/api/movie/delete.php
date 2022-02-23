<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/dbms.php';
include_once '../../models/movie.php';


$database = new dbms();
$db = $database->connect();


$movie = new movie($db);


$movie->id = isset($_GET['id']) ? $_GET['id'] : die();


$result = $movie->delete();