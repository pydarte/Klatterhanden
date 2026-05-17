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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="css/header-footer.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="pictures/klatterhand.png">
</head>
<body>

<header>
    <div class="header-inner">
        <img class="header-logo" onclick="window.location='home.php';" src="pictures/klatterhand.png" alt="Klätterhanden logotyp">
        <nav>
            <a href="home.php" class="active">Home</a>
            <a href="climberforum.php">Klätterforum</a>
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



<footer>
    <div class="footer-inner">
        <p>&copy; 2026 David Buwaj</p>
        <nav>
            <a href="home.php" class="active">Home</a>
            <a href="climberforum.php">Klätterforum</a>
            <a href="boulderlist.php">Boulderlista</a>
            <a href="activities.php">Aktiviteter</a>
        </nav>
    </div>
</footer>

</body>
</html>