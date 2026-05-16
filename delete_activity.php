<?php
require 'functions.php';
session_start();

$db = connectToDb();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: activities.php");
    exit();
}

$id = $_POST['id'];

$stmt = $db->prepare("DELETE FROM activities WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: activities.php");
exit();
?>