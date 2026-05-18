<?php
    require_once 'functions.php';
    session_start();

    requireLogin();
    $db = connectToDb();
    requireAdmin();

    $boulder = $_POST['boulder']; //Hämtar data från POST.
    $grade = $_POST['grade'];
    $area = $_POST['area'];
    $comment = $_POST['comment'];

    $statement = $db->prepare("INSERT INTO bouldertable (boulder, grade, area, comment) VALUES (?, ?, ?, ?)"); //Kör SQL-fråga för att spara bouldern i databasen.
    $statement->bind_param("ssss", $boulder, $grade, $area, $comment);
    $statement->execute();

    header("Location: boulderlist.php");
    exit();
?>