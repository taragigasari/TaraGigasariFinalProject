<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once '../../config/dbms.php';
include_once '../../models/movie.php';


$database = new dbms();
$db = $database->connect();


$movie = new movie($db);

$movie->searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : die();

$movie->search();

$num = $result->rowCount();


if ($num > 0) {
    
    $movie_arr = array();
    $movie_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $movie_item = array(
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'year' => $year,
            'poster' => $poster,
        );
       
        array_push($movie_arr['data'], $movie_item);
    }

    
    echo json_encode($movie_arr);
} else {
    
    $emptyArray = array();
    $emptyArray['data'] = array();
    echo json_encode(
        $emptyArray
    );
}
