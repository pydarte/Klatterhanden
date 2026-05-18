<?php
    require_once 'functions.php';
    session_start();


    requireLogin();

    $db = connectToDb();

    requireAdmin();

    $id = $_POST['id'];
    $boulder = $_POST['boulder'];
    $grade = $_POST['grade'];
    $area = $_POST['area'];
    $comment = $_POST['comment'];

    updateBoulder($db, $id, $boulder, $grade, $area, $comment);

    header("Location: showboulder.php?id=" . $id);
    exit();
?>