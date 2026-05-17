<?php
session_start();

require 'functions.php';
$db = connectToDb();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: boulderlist.php");
    exit();
}

$id = $_POST['id'];
$boulder = $_POST['boulder'];
$grade = $_POST['grade'];
$area = $_POST['area'];
$comment = $_POST['comment'];

updateBoulder($db, $id, $boulder, $grade, $area, $comment);

header("Location: showboulder.php?id=" . $id);
exit();
?>