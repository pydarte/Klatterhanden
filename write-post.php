<?php
    require_once 'functions.php';
    session_start();

    requireLogin();

    $db = connectToDb();
    $user = getUserById($db, $_SESSION['userId']);
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Skapa inlägg</title>

    <link href="css/header-footer.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="pictures/klatterhand.png">
</head>

<body>


<div class="container">

    <div class="post-form-wrapper">

        <h1>Skapa nytt inlägg</h1>

        <form action="save-post.php" method="post" class="create-post-form">


            <p>
                <label for="title">Titel</label><br>
                <input type="text" id="title" name="title" required>
            </p>

            <p>
                <label for="content">Innehåll</label><br>
                <textarea id="content" name="content" rows="10" required></textarea>
            </p>

            <button type="submit">Publicera inlägg</button>

            <a href="climberforum.php" class="back-btn">
                Tillbaka till forumet
            </a>

        </form>

    </div>

</div>


</body>
</html>