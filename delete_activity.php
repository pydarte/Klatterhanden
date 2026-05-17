<?php
require 'functions.php';
session_start();

$db = connectToDb();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: activities.php");
    exit();
}

$id = $_POST['id'];

$statement = $db->prepare("DELETE FROM activities WHERE id = ?");
$statement->bind_param("i", $id);
$statement->execute();

header("Location: activities.php");
exit();
?>