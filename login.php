<?php

    session_start();
    require_once('functions.php');

    if (empty($_POST['username']) || empty($_POST['password'])) {
        header('Location: index.php');
        exit;
    }

    $db = connectToDb();

    $username = $_POST['username'];
    $password = $_POST['password'];

    login($username, $password);


    header('Location: home.php');
    exit;
?>
