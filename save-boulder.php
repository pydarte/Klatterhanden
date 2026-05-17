<?php
session_start();

require 'functions.php';

$db = connectToDb();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: boulderlist.php");
    exit();
}

$boulder = $_POST['boulder'];
$grade = $_POST['grade'];
$area = $_POST['area'];
$comment = $_POST['comment'];

$statement = $db->prepare("INSERT INTO bouldertable (boulder, grade, area, comment) VALUES (?, ?, ?, ?)");
$statement->bind_param("ssss", $boulder, $grade, $area, $comment);

$statement->execute();

header("Location: boulderlist.php");
exit();
?>