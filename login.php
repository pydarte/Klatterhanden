<?php

    // Startar session och laddar funktioner
    session_start();
    require_once('functions.php');

    if (empty($_POST['username']) || empty($_POST['password'])) { // Avbryter och skickar tillbaka om användarnamn eller lösenord saknas
        header('Location: index.php');
        exit;
    }

    // Anropar login-funktion som verifierar användaren
    $db = connectToDb();
    $username = $_POST['username'];
    $password = $_POST['password'];
    login($username, $password);

    // Vid lyckad inloggning skickas användaren till startsidan
    header('Location: home.php');
    exit;
?>
