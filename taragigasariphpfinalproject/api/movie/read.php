<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/dbms.php';
include_once '../../models/movie.php';


$database = new dbms();
$db = $database->connect();


$movie = new movie($db);

$result = $movie->read();
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
   
    echo json_encode(
        array('message' => 'There are no movies to show.')
    );
}
