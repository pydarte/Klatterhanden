<?php
    // Startar session, kontrollerar inloggning och adminbehörighet
    require_once 'functions.php';
    session_start();
    requireLogin();
    $db = connectToDb();
    requireAdmin();

    // Hämtar uppdaterad data från formuläret
    $id = $_POST['id'];
    $boulder = $_POST['boulder'];
    $grade = $_POST['grade'];
    $area = $_POST['area'];
    $comment = $_POST['comment'];

    // Uppdaterar boulder i databasen
    updateBoulder($db, $id, $boulder, $grade, $area, $comment);
    
    // Skickar användaren tillbaka till bouldersidan efter uppdatering
    header("Location: showboulder.php?id=" . $id);
    exit();
?>