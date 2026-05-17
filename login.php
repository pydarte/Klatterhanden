<?php

session_start();
require_once('functions.php');
$db = connectToDb();

$username = $_POST['username'];
$password = $_POST['password'];
$user = getUserByUsername($db,$username);

login($username, $password);


header('Location: home.php');

?>
