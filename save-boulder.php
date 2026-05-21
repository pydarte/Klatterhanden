<?php
    require_once 'functions.php';
    session_start();

    requireLogin();
    $db = connectToDb();
    requireAdmin();

    // Hämtar och lagrar formulärdata från POST
    $boulder = $_POST['boulder'];
    $grade = $_POST['grade'];
    $area = $_POST['area'];
    $comment = $_POST['comment'];

    // Lägger till ny boulder i databasen med prepared statement
    $statement = $db->prepare("INSERT INTO bouldertable (boulder, grade, area, comment) VALUES (?, ?, ?, ?)");
    $statement->bind_param("ssss", $boulder, $grade, $area, $comment);
    $statement->execute();

    // Skickar användaren tillbaka till boulderlistan efter insättning
    header("Location: boulderlist.php");
    exit();
?>