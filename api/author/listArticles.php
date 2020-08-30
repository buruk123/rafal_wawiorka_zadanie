<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../config/Database.php');
include_once('../objects/Article.php');
include_once('../objects/Author.php');

$database = new Database();
$db = $database->getConnection();

$article = new Article($db);
$author = new Author($db);

session_start();

$stmt = $author->getAllArticlesByAuthorId($_SESSION['author_id']);
$num = $stmt->rowCount();

if ($num > 0) {
    $articles = array();
    $articles['records'] = array();
    $authors = array();
    $authors['authors'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $article_item = array(
            'article_id' => $article_id,
            'article_title' => $article_title,
            'article_text' => $article_text,
            'article_creation_date' => $article_creation_date,
        );

        $stmt2 = $author->getAuthorsByArticleId($article_item['article_id']);
        $authors = array();
        $authors['authors'] = array();
        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            extract($row2);
            $author_item = array(
                'author_first_name' => $user_first_name,
                'author_last_name' => $user_last_name,
            );
            array_push($authors['authors'], $author_item);
        }

        $article_item['authors'] = $authors['authors'];
        array_push($articles['records'], $article_item);
    }

    http_response_code(200);
    echo json_encode($articles);
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'No articles found')
    );
}
