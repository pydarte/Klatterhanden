<?php

// Load installed packages
require_once 'vendor/autoload.php';

// Load secrets from the file .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'functions.php';

$mysqli = connectToMysqli();



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <title>Klätterhanden</title>
</head>

<body>
    <header>

    </header>



    <div class = "form-container">



    </div>



</body>

</html>