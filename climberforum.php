<?php
    require_once 'functions.php';
    
    // Startar session och säkerställer att användaren är inloggad
    session_start();
    $db = connectToDb();
    requireLogin();

    // Hämtar användarinformation och de senaste foruminläggen
    $userId = $_SESSION['userId'];
    $user = getUserById($db, $userId);
    $latestPosts = getLatestPosts($db, 50);

    require 'includes/header.php';
?>


<div class="container">
    <section class="hero-banner">
        <img src="pictures/climbingforum.png" alt="Klätterforum bild">
        <div class="welcome-box">
            <h1>Klätterforumet</h1>
            
            <p>
            Här kan du som medlem i Klätterhanden skapa inlägg och diskutera allt som har med klättring att göra. Dela dina erfarenheter, ställ frågor eller ge tips till andra klättrare. Välkommen att delta i diskussionen!
            </p>

        </div>
    </section>

    <h2>Senaste inläggen</h2>
    <div class="actions">
        <form action="write-post.php" method="get">
            <button type="submit">Skapa nytt inlägg</button>
        </form>
    </div>

    <div class="post-container">
    <?php foreach ($latestPosts as $post): 
        // Loopar igenom och visar alla foruminlägg
        ?>
    <div class="post">
        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        
        <small>
            Skrivet av: <strong><?php echo htmlspecialchars($post['username']); ?></strong> 
            | Publicerad: <?php echo htmlspecialchars($post['created_at']); ?>
        </small>

        <?php 
            $postId = $post['id'];
            include 'comment.php';
            // Visar kommentarer kopplade till aktuellt inlägg
        ?>

        <?php if ($_SESSION['username'] === 'admin') { 
            // Endast administratören kan radera inlägg
            ?>
            <form method="post" action="delete-post.php" style="margin-top:10px;">
                <input type="hidden" name="postid" value="<?php echo $post['id']; ?>">
                <button type="submit" class="delete-btn">Radera inlägg</button>
            </form>
        <?php } ?>

        
    </div>
        <?php endforeach; ?>
    </div>
</div>

<?php 
    require 'includes/footer.php'; 
?>