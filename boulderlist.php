<?php
require 'functions.php'; 

session_start(); 
$db = connectToDb();  

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);
}

$db->set_charset('utf8');
$result = $db->query("SELECT * FROM bouldertable ORDER BY id ASC");


?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The boulder list</title>
    <link href="css/header-footer.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="pictures/klatterhand.png">
</head>
<body>

<header>
    <div class="header-inner">
        <img class="header-logo" onclick="window.location='home.php';" src="pictures/klatterhand.png" alt="Klätterhanden logotyp">
        <nav>
            <a href="home.php">Home</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php" class="active">Boulderlista</a>
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

<div class="container">
    <section class="hero-banner">
        <img src="pictures/boulderimg.png" alt="Boulderlista bild">
        <div class="welcome-box">
            <h1>Boulderlista</h1>
            <p><strong>Lista över några av dem svåraste boulders i Sverige. Kommentarer är skrivna av olika medlemmar.</strong></p>
        </div>
    </section>

    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') { ?>
        <div class="actions">
            <a href="add-boulder.php" class="admin-btn">Add boulder</a>
        </div>
    <?php } ?>

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
                    echo '<tr>';echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td><a href="showboulder.php?id=' . $row['id'] . '">' . htmlspecialchars($row['boulder']) . '</a></td>';
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
            <a href="home.php">Home</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php" class="active">Boulderlista</a>
        </nav>
    </div>
</footer>

</body>
</html>



