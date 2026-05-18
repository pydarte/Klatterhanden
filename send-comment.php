<?php
    require_once 'functions.php';
    session_start();

    requireLogin();
    $db = connectToDb();

    $postId = $_POST['postid'];
    $userId = $_SESSION['userId'];
    $comment = $_POST['comment'];
    $parentCommentId = isset($_POST['parent_comment_id']) && $_POST['parent_comment_id'] !== '' ? (int) $_POST['parent_comment_id'] : null; //hämtar parent_comment om det finns annars sätter den det till NULL alltså inget.

    if (saveComment($db, $postId, $userId, $comment, $parentCommentId)) { //Försöker spara kommentar och visar meddelandet beroende på om det lyckades eller ej.
        $_SESSION['message'] = "Kommentar sparad!";
    } else {
        $_SESSION['message'] = "Fel: " . $db->error;
    }

    header('Location: climberforum.php');
    exit();
?>
