<?php
    require_once 'functions.php';
    session_start();


    requireLogin();

    $db = connectToDb();

    $userId = $_SESSION['userId']; 
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (createPost($db, $title, $userId, $content)) {
        $_SESSION['message'] = "Inlägget är upplagt!";
    } else {
        $_SESSION['message'] = "Fel: " . $db->error;
    }

    header('Location: climberforum.php');
    exit();
?>
