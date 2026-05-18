<?php
    require_once 'functions.php';
    session_start();

    requireLogin();
    $db = connectToDb();
    requireAdmin();

    $id = $_GET['id'];

    $statement = $db->prepare("SELECT * FROM bouldertable WHERE id = ?"); //Hämtar boulderdata från databasen baserat på ID:t.
    $statement->bind_param("i", $id);
    $statement->execute();

    $boulder = $statement->get_result()->fetch_assoc(); //Lagrar resultatet som en array som är associativ.
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="UTF-8">
        <title>Edit Boulder</title>
        <link href="css/main.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="post-form-wrapper">
                <h1>Edit Boulder</h1>
                <form action="update-boulder.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $boulder['id']; ?>">
                    <p>
                        <label>Boulder</label><br>
                        <input type="text" name="boulder" value="<?php echo htmlspecialchars($boulder['boulder']); /*htmlspecialchars används för att förhindra XSS-attacker genom att konvertera specialtecken till HTML-entiteter.*/
                        ?>"> 
                    </p>
                    <p>
                        <label>Grade</label><br>
                        <input type="text" name="grade" value="<?php echo htmlspecialchars($boulder['grade']); ?>">
                    </p>
                    <p>
                        <label>Area</label><br>
                        <input type="text" name="area" value="<?php echo htmlspecialchars($boulder['area']); ?>">
                    </p>
                    <p>
                        <label>Comment</label><br>
                        <textarea name="comment"><?php echo htmlspecialchars($boulder['comment']); ?></textarea>
                    </p>
                    <button type="submit">Save changes</button>
                    <a href="boulderlist.php" class="back-btn">Back</a>
                </form>
            </div>
        </div>
    </body>
</html>