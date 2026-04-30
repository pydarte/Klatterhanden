<?php
require 'functions.php';
session_start();

$db = connectToDb();

if ( ! isset($_SESSION['loggedIn']) || ! $_SESSION['loggedIn']) {
    header('Location: index.php');
    exit();
}


    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);



?>