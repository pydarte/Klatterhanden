<?php
    require_once 'functions.php';
    session_start();

    requireLogin();

    $db = connectToDb();

    requireAdmin();

    $id = $_POST['id'];

    $statement = $db->prepare("DELETE FROM activities WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();

    header("Location: activities.php");
    exit();
?>