<?php
session_start();
// Load installed packages
require_once 'vendor/autoload.php';
require 'functions.php';

$db = connectToDb();



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Klätterhanden är en klätterklubb i Handen, söder om Stockholm. Vi har klättring för alla, både inomhus och utomhus. Välkommen att bli medlem!">
    <link href="css/main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="pictures/logo.png">
    <title>Klätterhanden</title>
</head>

<body>
    <header>

    </header>



    <div class = "form-container">
        <form action="register.php" method="post">
            <h2>Skapa konto</h2>
            <p><input type="text" name="username" placeholder="Användarnamn"></p>
            <p><input type="password" name="password" placeholder="Lösenord"></p>
            <p><input type ="password" name="passwordConfirm" placeholder="Bekräfta lösenord">
            <p><input type="email" name="email" placeholder="E-post"></p>
            <p><input type="submit" value="Skapa konto"></p>
        </form>

        <form action="login.php" method="post">
            <h2>Logga in</h2>
            <p><input type="text" name="username" placeholder="Användarnamn"></p>
            <p><input type="password" name="password" placeholder="Lösenord"></p>
            <p><input type="submit" value="Logga in"></p>
        </form>
    </div>



</body>

</html>