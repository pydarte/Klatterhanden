<?php
require 'functions.php';
session_start();

$db = connectToDb();

if ( ! isset($_SESSION['loggedIn']) || ! $_SESSION['loggedIn']) {
    header('Location: index.php');
    exit();
}


    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);



?>


<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Klätterhanden</title>

</head>
<body>

<header> <h2>Klätterhanden</h2> </header>


</body>
</html>