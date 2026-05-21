<?php

    // Startar session, kontrollerar inloggning och ansluter till databasen
    require_once 'functions.php';
    session_start();
    requireLogin();
    $db = connectToDb();

    // Hämtar data från formuläret (nytt inlägg)
    $userId = $_SESSION['userId']; 
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Sparar statusmeddelande i session beroende på om inlägget skapades
    if (createPost($db, $title, $userId, $content)) {
        $_SESSION['message'] = "Inlägget är upplagt!";
    } else {
        $_SESSION['message'] = "Fel: " . $db->error;
    }

    // Skickar användaren tillbaka till forumet
    header('Location: climberforum.php');
    exit();
?>
