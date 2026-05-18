<?php

    require_once 'vendor/autoload.php'; //Dessa 3 rader laddar .env-filen
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    function connectToDb() { //Skapar databas anslutning och returnerar mysqli-objektet
        $dbHost = 'ostrawebb.se';
        $dbUser = $_ENV['DB_USER']; // Dessa 3 rader hämtar databasuppgifter från .env-filen
        $dbPassword = $_ENV['DB_PASS'];
        $dbDatabase = $_ENV['DB_NAME'];
        $db = new mysqli($dbHost, $dbUser, $dbPassword, $dbDatabase);

        return $db;
    }

    function getUserById($db, $userId) { //Hämmtar användare baserat på ID.
        $statement = $db->prepare("SELECT * FROM site_users WHERE id = ?");
        $statement->bind_param('i', $userId);
        $statement->execute();
        $result = $statement->get_result();
        $user = $result->fetch_assoc();
        return $user;
    }

    function getUserByUsername($db, $username) { //Hämmtar användare baserat på användarnamn.
        $statement = $db->prepare("SELECT * FROM site_users WHERE username = ?");
        $statement->bind_param('s', $username);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_assoc(); 
    }

    function login($username, $password) { //Hanterar inloggning, checkar om lösenordet stämmer till användarnnamnet, sätter också sessionsvariabler.
        $db = connectToDb();
        $user = getUserByUsername($db, $username);

        if ( ! $user) { //Om användaren inte finns i databasen.
            $_SESSION['message'] = "Användarnamn eller lösenord felaktigt!"; 
            header('Location: index.php');
            exit();
        }

        $hashedPassword = $user['password']; //Dessa rader verifierar lösenordet med det hashade lösenordet.
        if ( ! password_verify($password, $hashedPassword)) {
            $_SESSION['message'] = "Användarnamn eller lösenord felaktigt!"; 
            header("Location: index.php");
            exit();
        }

        $_SESSION['loggedIn'] = TRUE; //Dessa rader sätter sessionen vid lyckad (TRUE) inloggning.
        $_SESSION['userId'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true; 
    }

    function requireLogin() { //Stoppar alla användare som inte är inloggade på sidan och skickar tillbaka dem till inloggningssidan.
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
            header("Location: index.php");
            exit;
        }
    }

    function requireAdmin() { //Stoppar användare och gör att bara admin kontot kan komma åt vissa åtgärder.
        if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
            header("Location: home.php");
            exit;
        }
    }

    function createPost($db, $title, $user_id, $content) { //Skapar ett nytt foruminlägg i databasen.
        $createdAt = date('Y-m-d H:i:s'); 
        $statement = $db->prepare("INSERT INTO forumpost (user_id, title, content, created_at) VALUES (?, ?, ?, ?)"); 
        $statement->bind_param('isss', $user_id, $title, $content, $createdAt);
        return $statement->execute(); 
    }

    function getLatestPosts($db, $limit = 3) { //Hämtar dem senaste foruminläggen, vilket sattes som 3 som standard, men det kan ändras när i paramentern när det anropas (t.ex på forum sidan.) 
        $sql = "SELECT forumpost.*, site_users.username FROM forumpost JOIN site_users 
                ON forumpost.user_id = site_users.id ORDER BY created_at DESC LIMIT " . (int)$limit;
        $result = $db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getComments($db, $postId) { //Hämtar kommentarer till ett specifikt inlägg på forumet.
        $statement = $db->prepare("SELECT comments.*, site_users.username FROM comments JOIN site_users ON comments.userid = site_users.id 
                                WHERE comments.postid = ? ORDER BY comments.posted_at ASC");
        $statement->bind_param('i', $postId);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function saveComment($db, $postId, $userId, $comment, $parentCommentId = null) { //Sparar en kommentar till ett inlägg och är också svar på kommentarer via parent_comment.
        $postedAt = date('Y-m-d H:i:s');
        $statement = $db->prepare("INSERT INTO comments (postid, userid, comment, posted_at, parent_comment_id) VALUES (?, ?, ?, ?, ?)");
        $statement->bind_param('iissi', $postId, $userId, $comment, $postedAt, $parentCommentId);
        
        return $statement->execute();
    }

    function getBoulder($db, $boulderId) { //Hämtar en specifk boulder från databasen.
        $statement = $db->prepare("SELECT * FROM bouldertable WHERE id = ?");
        $statement->bind_param('i', $boulderId);
        $statement->execute();
        $result = $statement->get_result();

        return $result->fetch_assoc();
    }

    function updateBoulder($db, $id, $boulder, $grade, $area, $comment) { //Uppdaterar en boulder i databasen.
        $statement = $db->prepare("UPDATE bouldertable SET boulder = ?, grade = ?, area = ?, comment = ? WHERE id = ?");
        $statement->bind_param('ssssi', $boulder, $grade, $area, $comment, $id);
        $statement->execute();
    }

    function getActivities($db, $limit = 3) { //Hämtar aktiviteter sorterade efter datum, standarden är 3 precis som med foruminläggen.
        $sql = "SELECT * FROM activities ORDER BY date ASC LIMIT " . (int)$limit;
        return $db->query($sql);
    }
?>
