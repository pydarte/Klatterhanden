<?php
    require_once 'functions.php';
    session_start();

    requireLogin();
    requireAdmin();
    $db = connectToDb();
    $postId = $_POST['postid'];

    $statement = $db->prepare("DELETE FROM forumpost WHERE id = ?");
    $statement->bind_param("i", $postId);
    $statement->execute();

    header("Location: climberforum.php");
    exit();
?>