<?php

    // Startar session, kontrollerar inloggning och ansluter till databasen
    require_once 'functions.php';
    session_start();
    requireLogin();
    $db = connectToDb();

    // Hämtar data från formuläret
    $postId = $_POST['postid'];
    $userId = $_SESSION['userId'];
    $comment = $_POST['comment'];

    // Sätter parent comment om det är ett svar, annars null
    $parentCommentId = isset($_POST['parent_comment_id']) && $_POST['parent_comment_id'] !== '' ? (int) $_POST['parent_comment_id'] : null; 
    // Sparar kommentar och sätter statusmeddelande
    if (saveComment($db, $postId, $userId, $comment, $parentCommentId)) { 
        $_SESSION['message'] = "Kommentar sparad!";
    } else {
        $_SESSION['message'] = "Fel: " . $db->error;
    }

    // Skickar tillbaka till forumet
    header('Location: climberforum.php');
    exit();
?>
