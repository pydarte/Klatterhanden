<?php
session_start();
require 'functions.php';

$db = connectToDb();


$title = $_POST['title'];
$content = $_POST['content'];
$userId = $_SESSION['userId']; 

if (createPost($db, $title, $userId, $content)) {
    $_SESSION['message'] = "Inlägget är upplagt!";
} else {
    $_SESSION['message'] = "Fel: " . $db->error;
}

header('Location: climberforum.php');
exit();