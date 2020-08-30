<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../config/Database.php');
include_once('../objects/Article.php');
include_once('../objects/Author.php');

session_start();

$database = new Database();
$db = $database->getConnection();

$author = new Author($db);
$article = new Article($db);

$stmt = $author->addArticle($_GET['title'], $article->replaceDoubleQuoteToSingle($_GET['text']));
$authors = explode(";", $_GET['authors']);

$json_article_id = json_encode($article->getLastArticleId());
$json_article_id = json_decode($json_article_id);
$id = $json_article_id->article_id;

foreach ($authors as $auth) {
    $author_name = explode(" ", $auth);
    if (count($author_name) == 2) {
        $author_id = $author->getAuthorIdByName($author_name[0], $author_name[1]);
        $author->addAuthorToArticle($author_id, $id);
    }

}

header('Location: ../../listArticles.php');
