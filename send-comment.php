<?php
session_start();
require 'functions.php';

if ( ! isset($_SESSION['loggedIn']) || ! $_SESSION['loggedIn']) {
    header('Location: index.php');
    exit();
}

$db = connectToDb();

$postId = $_POST['postid'];
$userId = $_SESSION['userId'];
$comment = $_POST['comment'];
$parentCommentId = isset($_POST['parent_comment_id']) && $_POST['parent_comment_id'] !== '' ? (int) $_POST['parent_comment_id'] : null;

if (saveComment($db, $postId, $userId, $comment, $parentCommentId)) {
    $_SESSION['message'] = "Kommentar sparad!";
} else {
    $_SESSION['message'] = "Fel: " . $db->error;
}

header('Location: climberforum.php');
exit();
?>
