<?php
    require_once 'functions.php';
    session_start();

    // Startar session och kontrollerar att användaren är inloggad och admin
    requireLogin();
    $db = connectToDb();
    requireAdmin();

    // Hämtar aktivitets-ID från formuläret
    $id = $_POST['id'];

    // Tar bort vald aktivitet från databasen (säker deletion med prepared statement)
    $statement = $db->prepare("DELETE FROM activities WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();

    // Skickar tillbaka till aktivitets-sidan efter borttagning
    header("Location: activities.php");
    exit();
?>