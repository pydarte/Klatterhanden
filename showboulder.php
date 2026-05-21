<?php
    require_once 'functions.php';

    // Startar session, kontrollerar inloggning och hämtar boulderdata
    session_start();
    $db = connectToDb();
    requireLogin();
    $user = getUserById($db, $_SESSION['userId']);
    $boulderId = $_GET['id'];
    $boulder = getBoulder($db, $boulderId);
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($boulder['boulder']); ?></title>
        <link href="css/header-footer.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="pictures/klatterhand.png">
    </head>
    <body>
        <div class="container">
            <div class="post">
                <h1><?php echo htmlspecialchars($boulder['boulder']); ?></h1>
                <p>Gradering: <?php echo htmlspecialchars($boulder['grade']); ?></p>
                <p>Område: <?php echo htmlspecialchars($boulder['area']); ?></p>
                <p>Kommentar:<br><?php echo htmlspecialchars($boulder['comment']); ?></p>

                <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') { 
                    // Visar endast redigera-knapp för admin
                    ?>
                    <a href="edit-boulder.php?id=<?php echo $boulder['id']; ?>" class="admin-btn">
                        Edit Boulder
                    </a>
                <?php } ?>
                
                <a href="boulderlist.php" class="back-btn">
                    Tillbaka till boulderlistan
                </a>
            </div>
        </div>
    </body>
</html>