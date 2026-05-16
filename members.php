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
    <link href="css/header-footer.css" rel="stylesheet">
</head>
<body>

<header>
    <div class="header-inner">
        <img class="header-logo" src="pictures/klatterlogo.png" alt="Klätterhanden logotyp">
        <nav>
            <a href="members.php" class="active">Medlemmar</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php">Boulderlista</a>
        </nav>
        <div class="user-info">
            <span>Inloggad som: <strong><?php echo htmlspecialchars($user['username']); ?></strong></span>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn">Logga ut</button>
            </form>
        </div>
    </div>
</header>

<footer>
    <div class="footer-inner">
        <p>&copy; 2026 David Buwaj</p>
        <nav>
            <a href="members.php" class="active">Medlemmar</a>
            <a href="climberforum.php">Klätterforum</a>
        </nav>
    </div>
</footer>

</body>
</html>