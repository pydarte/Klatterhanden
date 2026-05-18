<?php
    require_once 'functions.php';
    session_start();


    requireLogin();

    requireAdmin();

    $db = connectToDb();

    $title = $_POST['title'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $statement = $db->prepare("INSERT INTO activities (title, date, location, description) VALUES (?, ?, ?, ?)");
    $statement->bind_param("ssss", $title, $date, $location, $description);

    $statement->execute();

    header("Location: activities.php");
    exit();
?>