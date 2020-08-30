<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../config/Database.php');
include_once('../objects/Article.php');

$database = new Database();
$db = $database->getConnection();

$article = new Article($db);

$stmt = $article->getArticleById($_GET['id']);
$num = $stmt->rowCount();


if ($num > 0) {
    $articles_arr = array();
    $articles_arr['records'] = array();
    $articles_authors = array();
    $articles_authors['authors'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $stmt2 = $article->getAuthorsByArticleId($article_id);
        $article_item = array(
            "article_id" => $article_id,
            "article_title" => $article_title,
            "article_text" => $article_text,
            "article_creation_date" => $article_creation_date,
        );
        $articles_authors = array();
        $articles_authors['authors'] = array();
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $article_author = array(
                "author_first_name" => $user_first_name,
                "author_last_name" => $user_last_name
            );
            array_push($articles_authors['authors'], $article_author);
        }

        $article_item['authors'] = $articles_authors['authors'];
        array_push($articles_arr['records'], $article_item);
    }

    http_response_code(200);
    echo json_encode($articles_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No articles found")
    );
}