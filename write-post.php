<html>

<body>


<form action="save-post.php" method="post">
    <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['userId']; ?>"> 

    <p>
    <label for="title">Titel:</label><br>
    <input type="text" id="title" name="title" required><br><br>
</p>

<p>
    <label for="content">Innehåll:</label><br>
    <textarea id="content" name="content" rows="10" cols="50" required></textarea><br><br>
    <p>

    <input type="submit" value="Publicera inlägg">
</form>

<style>

</style>

</body>
</html>