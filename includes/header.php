<?php
    require_once 'functions.php';
    $db = connectToDb();
    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktiviteter</title>
    <link href="css/header-footer.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="pictures/klatterhand.png">
</head>

<body>

<header>
    <div class="header-inner">
        <img class="header-logo" onclick="window.location='home.php';" src="pictures/klatterhand.png" alt="Klätterlogga">

        <nav>
            <a href="home.php">Home</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php">Boulderlista</a>
            <a href="activities.php">Aktiviteter</a>
        </nav>

        <div class="user-info">
            Inloggad som: <strong><?php echo htmlspecialchars($user['username']); ?></strong>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn">Logga ut</button>
            </form>
        </div>
    </div>
</header>
