<?php
    require_once 'functions.php';

    // Startar session och säkerställer att användaren är inloggad som admin
    session_start();
    requireLogin();
    requireAdmin();
    $db = connectToDb();

    // Hämtar ID för inlägget som ska raderas
    $postId = $_POST['postid'];

    // Tar bort foruminlägget från databasen (säker deletion med prepared statement)
    $statement = $db->prepare("DELETE FROM forumpost WHERE id = ?");
    $statement->bind_param("i", $postId);
    $statement->execute();

    // Skickar tillbaka till forumet efter borttagning
    header("Location: climberforum.php");
    exit();
?>