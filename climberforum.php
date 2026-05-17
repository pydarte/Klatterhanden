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

    $latestPosts = getLatestPosts($db, 50);
?>


<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Klätterforum</title>
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
            <a href="climberforum.php" class="active">Klätterforum</a>
            <a href="boulderlist.php">Boulderlista</a>
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
        <img src="pictures/climbingforum.png" alt="Klätterforum bild">
        <div class="welcome-box">
            <h1>Klätterforumet</h1>
            
            <p>
            Här kan du som medlem i Klätterhanden skapa inlägg och diskutera allt som har med klättring att göra. Dela dina erfarenheter, ställ frågor eller ge tips till andra klättrare. Välkommen att delta i diskussionen!
            </p>

        </div>
    </section>

    <hr style="width:100%; border: 0; height: 1px; background: #ccc; margin: 20px 0;">

    <h2>Senaste inläggen</h2>
    <div class="actions">
        <form action="write-post.php" method="get">
            <button type="submit">Skapa nytt inlägg</button>
        </form>
    </div>

    <div class="post-container">
    <?php foreach ($latestPosts as $post): ?>
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
        ?>

        <?php if ($_SESSION['username'] === 'admin') { ?>
            <form method="post" action="delete-post.php" style="margin-top:10px;">
                <input type="hidden" name="postid" value="<?php echo $post['id']; ?>">
                <button type="submit" class="delete-btn">Radera inlägg</button>
            </form>
        <?php } ?>

        
    </div>
<?php endforeach; ?>
    </div>
</div>

<footer>
    <div class="footer-inner">
        <p>&copy; 2026 David Buwaj</p>
        <nav>
            <a href="home.php">Home</a>
            <a href="climberforum.php" class="active">Klätterforum</a>
            <a href="boulderlist.php">Boulderlista</a>
            <a href="activities.php">Aktiviteter</a>
        </nav>
    </div>
</footer>

</body>
</html>