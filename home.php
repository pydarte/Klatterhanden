<?php
    require_once 'functions.php';
    session_start();
    $db = connectToDb();
    requireLogin();

    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);

    $latestPosts = getLatestPosts($db);
    $latestActivities = getActivities($db);
    require 'includes/header.php'; //Hänvisar till header
?>

<div class="container">
    <section class="hero-banner">
        <img src="pictures/homeclimbingselfie.png" alt="Boulderlista bild">
        <div class="welcome-box">
            <h1>Välkommen till Klätterhanden!</h1>
            <p><strong>En plats för klättrare att dela erfarenheter och hitta nya utmaningar!</strong></p>
        </div>
    </section>

    <div class="post-container">
        <h2>Kommande aktiviteter</h2>
        <div class="activity-list">

            <?php while ($row = $latestActivities->fetch_assoc()) { /*While loopen loopar igenom aktiviteterna och visar varje aktivitet i en "activity-card" (alltså en ruta).*/
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
                    <a href="activities.php">Se alla aktiviteter</a>
                </div>
            <?php } ?>

            <h2>Våra forums diskussioner</h2>

            <?php foreach ($latestPosts as $post): /*Loopar igenom de senaste foruminläggen och visar varje inlägg i en "post" (alltså också en ruta).*/
                ?> 
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p>
                        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                    </p>
                    <small>
                        Av: <strong><?php echo htmlspecialchars($post['username']); ?></strong>
                        | <?php echo htmlspecialchars($post['created_at']); ?>
                    </small>
                    <br><br>
                    <a href="climberforum.php">Gå till forum</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php 
    require 'includes/footer.php';  //Hänvisar till footer
?>