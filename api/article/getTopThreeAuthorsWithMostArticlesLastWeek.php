<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../config/Database.php');
include_once('../objects/Article.php');

$database = new Database();
$db = $database->getConnection();

$author = new Article($db);

$stmt = $author->getTopThreeAuthorsWithMostArticlesLastWeek();
$num = $stmt->rowCount();

if ($num > 0) {
    $authors_arr = array();
    $authors_arr['records'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $author_item = array(
            "author_first_name" => $user_first_name,
            "author_last_name" => $user_last_name
        );
        array_push($authors_arr['records'], $author_item);
    }

    http_response_code(200);
    echo json_encode($authors_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No products found")
    );
}
