<?php

include_once('../config/Database.php');
include_once('../objects/User.php');

$database = new Database();
$db = $database->getConnection();

session_start();

$user = new User($db);
$author = new Author($db);

$stmt = $user->makeAnAuthor($_SESSION['user_id']);
$num = $stmt->rowCount();
if ($num > 0) {
    $_SESSION['type'] = 'author';
    $_SESSION['author_id'] = $author->getAuthorId($_SESSION['user_id']);
    header('Location: ../../index.php');
}

