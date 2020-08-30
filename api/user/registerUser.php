<?php

include_once('../config/Database.php');
include_once('../objects/User.php');

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

session_start();

$json_user_add = json_encode($user->addUser($_POST['user_first_name'], $_POST['user_last_name']));
$json_user_add = json_decode($json_user_add);
$check_for_user_add = $json_user_add->check;

$json_user_id = json_encode($user->getLastUserId());
$json_user_id = json_decode($json_user_id);
$id = $json_user_id->user_id;

$json_check_user_credentials = json_encode($user->addUserCredentials($id, $_POST['user_login'], $_POST['user_password']));
$json_check_user_credentials = json_decode($json_check_user_credentials);
$check_for_credentials = $json_check_user_credentials->check;


if ($check_for_credentials == 'failure') {
    $user->deleteUser($id);
    $_SESSION['register_failure'] = "yes";
} else {
    $_SESSION['register_failure'] = "no";
}

header('Location: ../../register.php');
