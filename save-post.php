<?php
    require_once 'functions.php';
    session_start();

    requireLogin();
    $db = connectToDb();

    $userId = $_SESSION['userId']; 
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (createPost($db, $title, $userId, $content)) { //Skapar nytt inlägg, visar om det lyckades eller ej.
        $_SESSION['message'] = "Inlägget är upplagt!";
    } else {
        $_SESSION['message'] = "Fel: " . $db->error;
    }

    header('Location: climberforum.php');
    exit();
?>
