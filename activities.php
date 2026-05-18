<?php
    require_once 'functions.php';

    session_start();
    requireLogin();

    $db = connectToDb();
    $user = getUserById($db, $_SESSION['userId']);
    $db->set_charset('utf8');
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

    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') { ?>
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
        <?php while ($row = $latestActivities->fetch_assoc()) { ?>
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

<?php 
    require 'includes/footer.php'; 
?>