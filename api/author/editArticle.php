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

$author = new Author($db);
$article = new Article($db);

$json_article_update = json_encode($article->updateArticle($_GET['id'], $_GET['title'], $_GET['text'], $_GET['creation_date']));
$json_article_update = json_decode($json_article_update);

$authors = explode(";", $_GET['authors']);

//$author->deleteOldArticleAuthors($_GET['id']);

$json_authors_delete = json_encode($author->deleteOldArticleAuthors($_GET['id']));
$json_authors_delete = json_decode($json_authors_delete);

if ($json_article_update->check == 'success') {
    for ($i = 0; $i < count($authors); $i++) {
        $author_name = explode(' ', $authors[$i]);
        if (count($author_name) == 2) {
            $author->addNewAuthorToArticle($_GET['id'], $author->getAuthorIdByName($author_name[0], $author_name[1]));
        }
    }
}


header('Location: ../../listArticles.php');




