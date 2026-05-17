<?php
require 'functions.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: climberforum.php");
    exit();
}

$db = connectToDb();

$postId = $_POST['postid'];

$statement = $db->prepare("DELETE FROM forumpost WHERE id = ?");
$statement->bind_param("i", $postId);
$statement->execute();

header("Location: climberforum.php");
exit();
?>