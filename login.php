<?php
    session_start();
    require_once('functions.php');

    if (empty($_POST['username']) || empty($_POST['password'])) { //Om användaren eller lösenordet saknas så skickas användaren tillbaka till index sidan.
        header('Location: index.php');
        exit;
    }

    $db = connectToDb();

    $username = $_POST['username'];
    $password = $_POST['password'];

    login($username, $password); //Anropar till funktionen som försöker logga in användaren.

    header('Location: home.php');
    exit;
?>
