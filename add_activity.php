<?php
require 'functions.php';
session_start();

if ($_SESSION['username'] !== 'admin') {
    header("Location: activities.php");
    exit();
}

$db = connectToDb();

$title = $_POST['title'];
$date = $_POST['date'];
$location = $_POST['location'];
$description = $_POST['description'];

$stmt = $db->prepare("INSERT INTO activities (title, date, location, description) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $date, $location, $description);

$stmt->execute();

header("Location: activities.php");
exit();
?>