<?php
    require_once 'functions.php';

    session_start();

    requireLogin();

    $db = connectToDb();
    $user = getUserById($db, $_SESSION['userId']);

    $db->set_charset('utf8');
    $result = $db->query("SELECT * FROM bouldertable ORDER BY id ASC");

    require 'includes/header.php';
?>


<div class="container">
    <section class="hero-banner">
        <img src="pictures/boulderimg.png" alt="Boulderlista bild">
        <div class="welcome-box">
            <h1>Boulderlista</h1>
            <p><strong>Lista över några av dem svåraste boulders i Sverige. Kommentarer är skrivna av olika medlemmar.</strong></p>
        </div>
    </section>

    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') { ?>
        <div class="actions">
            <a href="add-boulder.php" class="admin-btn">Add boulder</a>
        </div>
    <?php } ?>

    <div class="table-wrapper">
        <table class="boulder-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Boulder</th>
                    <th>Gradering</th>
                    <th>Område</th>
                    <th>Kommentar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()){
                    echo '<tr>';echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td><a href="showboulder.php?id=' . $row['id'] . '">' . htmlspecialchars($row['boulder']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['grade']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['area']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['comment']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
    require 'includes/footer.php'; 
?>



