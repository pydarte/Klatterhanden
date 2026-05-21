<?php
    require_once 'functions.php';

    // Startar session och säkerställer att användaren är inloggad
    session_start();
    requireLogin();

    $db = connectToDb();
    $db->set_charset('utf8');

    // Hämtar användare och senaste aktiviteter från databasen
    $user = getUserById($db, $_SESSION['userId']);
    $latestActivities = getActivities($db, 20);

    require 'includes/header.php';
?>

<div class="container">
    <section class="hero-banner">
        <img src="pictures/climbingactivity.jpg" alt="Klubbaktiviteter bild">
        <div class="welcome-box">
            <h1>Klubb aktiviteter</h1>
            <p><strong>Se våra kommande aktiviteter och dyk upp på aktiviteterna!</strong></p>
        </div>
    </section>

    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') { 
        // Visar endast formuläret för admin (skapa ny aktivitet)
        ?>
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
        <?php while ($row = $latestActivities->fetch_assoc()) { 
            // Loopar igenom och visar alla aktiviteter
            ?>
            <div class="activity-card">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p class="activity-meta">
                    Tid: <?php echo htmlspecialchars($row['date']); ?>  
                    Plats: <?php echo htmlspecialchars($row['location']); ?>
                </p>
                <p class="activity-desc">
                    <?php echo htmlspecialchars($row['description']); ?>
                </p>

                <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') { 
                    // Visar admin-knapp för att radera aktiviteter
                    ?>
                    <form method="post" action="delete_activity.php" style="margin-top:10px;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="delete-btn">Radera</button>
                    </form>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

<?php 
    require 'includes/footer.php'; 
?>