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

    $latestPosts = getLatestPosts($db);
?>


<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Klätterforum</title>
    <link href="css/header-footer.css" rel="stylesheet">
</head>
<body>

<header>
    <div class="header-inner">
        <img class="header-logo" src="pictures/klatterlogo.png" alt="Klätterhanden logotyp">
        <nav>
            <a href="members.php">Medlemmar</a>
            <a href="climberforum.php" class="active">Klätterforum</a>
        </nav>
    </div>
</header>

<div class="container">
    <div class="welcome-box">
        <h1>Välkommen!</h1>
        <p>Inloggad som: <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
        
        <div class="actions">
            <form action="write-post.php" method="get">
                <button type="submit">Skapa nytt inlägg</button>
            </form>

            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn">Logga ut</button>
            </form>
        </div>
    </div>

    <hr style="width:100%; border: 0; height: 1px; background: #ccc; margin: 20px 0;">

    <h2>Senaste inläggen</h2>

    <div class="post-container">
    <?php foreach ($latestPosts as $post): ?>
    <div class="post">
        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        
        <small>
            Skrivet av: <strong><?php echo htmlspecialchars($post['username']); ?></strong> 
            | Publicerad: <?php echo htmlspecialchars($post['created_at']); ?>
        </small>
    </div>
<?php endforeach; ?>
    </div>
</div>

<footer></footer>

</body>
</html>