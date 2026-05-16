<?php
require 'functions.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: climberforum.php");
    exit();
}

$db = connectToDb();

$postId = $_POST['postid'];

$stmt = $db->prepare("DELETE FROM forumpost WHERE id = ?");
$stmt->bind_param("i", $postId);
$stmt->execute();

header("Location: climberforum.php");
exit();
?>