<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../config/Database.php');
include_once('../objects/Author.php');

$database = new Database();
$db = $database->getConnection();

$author = new Author($db);

$stmt = $author->getAllArticlesByAuthorId($_GET['id']);
$num = $stmt->rowCount();

if ($num > 0) {
    $article_author_arr = array();
    $article_author_arr['records'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $article_author_item = array(
            "article_id" => $article_id,
            "article_title" => $article_title,
            "article_text" => $article_text,
            "article_creation_date" => $article_creation_date,
            "author_first_name" => $user_first_name,
            "author_last_name" => $user_last_name
        );

        array_push($article_author_arr['records'], $article_author_item);

        http_response_code(200);
    }

    echo json_encode($article_author_arr);

} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No products found")
    );


}