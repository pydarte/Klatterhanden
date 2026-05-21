<?php
    require_once 'functions.php';

    // Startar session och kontrollerar att användaren är inloggad och är admin
    session_start();
    requireLogin();
    requireAdmin();
    $db = connectToDb();

    // Hämtar data från formuläret
    $title = $_POST['title'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Lägger till ny aktivitet i databasen med prepared statement
    $statement = $db->prepare("INSERT INTO activities (title, date, location, description) VALUES (?, ?, ?, ?)");
    $statement->bind_param("ssss", $title, $date, $location, $description);
    $statement->execute();

    // Skickar tillbaka användaren till aktivitets-sidan efter insättningen
    header("Location: activities.php");
    exit();
?>