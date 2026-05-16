<?php
require 'functions.php';  // Inkluderar funktionsfilen med alla databasfunktioner

session_start(); // Startar en ny session
$db = connectToDb();  // Skapar databasanslutning

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);
}

$db->set_charset('utf8');
$result = $db->query("SELECT * FROM bouldertable ORDER BY id ASC");  // Hämtar alla filmer, sorterade efter ID i stigande ordning


?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The boulder list</title>
    <link href="css/header-footer.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>

<header>
    <div class="header-inner">
        <img class="header-logo" src="pictures/klatterhand.png" alt="Klätterhanden logotyp">
        <nav>
            <a href="members.php">Medlemmar</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php" class="active">Boulderlista</a>
            <a href="activities.php">Aktiviteter</a>
        </nav>
        <div class="user-info">
            <span>Inloggad som: <strong><?php echo htmlspecialchars($user['username']); ?></strong></span>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn">Logga ut</button>
            </form>
        </div>
    </div>
</header>

<div class="container">
    <section class="hero-banner">
        <img src="pictures/boulderlista.png" alt="Boulderlista bild">
        <div class="welcome-box">
            <h1>Boulderlista</h1>
            <p><strong>Lista över några av dem svåraste boulders i Sverige. Kommentarer är skrivna av olika medlemmar.</strong></p>
        </div>
    </section>

    <div class="table-wrapper">
        <table class="boulder-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Boulder</th>
                    <th>Gradering</th>
                    <th>Område</th>
                    <th>Kommentar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()){
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['boulder']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['grade']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['area']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['comment']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <div class="footer-inner">
        <p>&copy; 2026 David Buwaj</p>
        <nav>
            <a href="members.php">Medlemmar</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php" class="active">Boulderlista</a>
        </nav>
    </div>
</footer>

</body>
</html>



