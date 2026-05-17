<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: boulderlist.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Add Boulder</title>

    <link href="css/main.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <h1>Add Boulder</h1>

    <form action="save-boulder.php" method="post">

        <p><input type="text" name="boulder" placeholder="Boulder name" required></p>
        <p><input type="text" name="grade" placeholder="Grade" required></p>
        <p><input type="text" name="area" placeholder="Area" required></p>
        <p><textarea name="comment" placeholder="Comment" required></textarea></p>

        <p><input type="submit" value="Save Boulder"></p>

    </form>

    <br>
    <a href="boulderlist.php">Back</a>

</div>

</body>
</html>