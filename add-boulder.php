<?php
    require_once 'functions.php';
    session_start();

    requireLogin();

    requireAdmin();
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Add Boulder</title>
    <link href="css/main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="pictures/klatterhand.png">
</head>

<body>

<div class="container">

    <div class="post-form-wrapper">
    <h1>Add Boulder</h1>

    <form action="save-boulder.php" method="post" class="create-post-form">

        <p><input type="text" name="boulder" placeholder="Boulder name" required></p>
        <p><input type="text" name="grade" placeholder="Grade" required></p>
        <p><input type="text" name="area" placeholder="Area" required></p>
        <p><textarea name="comment" placeholder="Comment" required></textarea></p>

        <button type="submit">Save Boulder</button>
        <a href="boulderlist.php" class="back-btn">Back</a>
    </form>
    

    </div>

</div>

</body>
</html>