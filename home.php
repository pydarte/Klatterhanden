<?php
    require_once 'functions.php';
    session_start();

    $db = connectToDb();

    requireLogin();


    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);

    $latestPosts = getLatestPosts($db);
    require 'includes/header.php';
?>



<div class="container">
    <section class="hero-banner">
        <img src="pictures/homeclimbingselfie.png" alt="Boulderlista bild">
        <div class="welcome-box">
            <h1>Välkommen till Klätterhanden!</h1>
            <p><strong>En plats för klättrare att dela erfarenheter och hitta nya utmaningar!</strong></p>
        </div>
    </section>


    <h2>Våra forums diskussioner</h2>

<div class="post-container">



<?php foreach ($latestPosts as $post): ?>

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


<?php 
    require 'includes/footer.php'; 
?>