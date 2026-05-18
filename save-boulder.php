<?php
    require_once 'functions.php';
    session_start();


    requireLogin();

    $db = connectToDb();

    requireAdmin();

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