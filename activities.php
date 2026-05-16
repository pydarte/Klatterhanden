<?php
require 'functions.php';
session_start();

$db = connectToDb();

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);
}

$db->set_charset('utf8');

$result = $db->query("SELECT * FROM activities ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktiviteter</title>
    <link href="css/header-footer.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>

<body>

<header>
    <div class="header-inner">
        <img class="header-logo" src="pictures/klatterhand.png" alt="Klätterlogga">

        <nav>
            <a href="members.php">Medlemmar</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php">Boulderlista</a>
            <a href="activities.php" class="active">Aktiviteter</a>
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
        <img src="pictures/climbingactivity.jpg" alt="Klubbaktiviteter bild">
        <div class="welcome-box">
            <h1>Klubb aktiviteter</h1>
            <p><strong>Se våra kommande aktiviteter och anmäl dig!</strong></p>
        </div>
    </section>

<?php if ($_SESSION['username'] === 'admin') { ?>

<div class="activity-form">
    <h3>Lägg till aktivitet</h3>

    <form method="post" action="add_activity.php">
        <input type="text" name="title" placeholder="Titel" required>
        <input type="date" name="date" required>
        <input type="text" name="location" placeholder="Plats" required>
        <textarea name="description" placeholder="Beskrivning" required></textarea>

        <button type="submit">Skapa aktivitet</button>
    </form>
</div>

<?php } ?>

    <div class="activity-list">

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="activity-card">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>

                <p class="activity-meta">
                    Tid: <?php echo htmlspecialchars($row['date']); ?>  
                    Plats: <?php echo htmlspecialchars($row['location']); ?>
                </p>

                <p class="activity-desc">
                    <?php echo htmlspecialchars($row['description']); ?>
                </p>

            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') { ?>

                <form method="post" action="delete_activity.php" style="margin-top:10px;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="delete-btn">Radera</button>
                </form>

            <?php } ?>
            </div>

        <?php } ?>

    </div>

</div>

<footer>
    <div class="footer-inner">
        <p>&copy; 2026 David Buwaj</p>
        <nav>
            <a href="members.php">Medlemmar</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php">Boulderlista</a>
            <a href="activities.php" class="active">Aktiviteter</a>
        </nav>
    </div>
</footer>

</body>
</html>