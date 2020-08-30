<?php

include_once('../config/Database.php');
include_once('../objects/User.php');

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (!isset($_POST['login']) || !isset($_POST['password'])) {
    header('Location: ../../loginRegister.php');
    echo("
<script type='text/javascript'>
    alert('Pola nie mogą być puste');
</script>");
    die();
}

$stmt = $user->loginUser($_POST['login'], $_POST['password']);
$num = $stmt->rowCount();

if ($num > 0) {
    $user_names = array();
    $user_names['records'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        session_start();
        $_SESSION['user_first_name'] = $user_first_name;
        $_SESSION['user_last_name'] = $user_last_name;
        $_SESSION['user_id'] = $user_id;
        if ($author_id == "") {
            $_SESSION['type'] = 'user';
        } else {
            $_SESSION['author_id'] = $author_id;
            $_SESSION['type'] = 'author';
        }
    }
    header('Location: ../../index.php');
} else {
    header('Location: ../../loginRegister.php');
}
