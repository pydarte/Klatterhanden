<?php

    require_once 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    /**
     * Skapar en anslutning till databasen.
     *
     * Hämtar databasuppgifter från .env-filen och
     * returnerar ett mysqli-objekt.
     *
     * @return mysqli Databasanslutning.
    */

    function connectToDb() {
        $dbHost = 'ostrawebb.se';
        $dbUser = $_ENV['DB_USER'];
        $dbPassword = $_ENV['DB_PASS'];
        $dbDatabase = $_ENV['DB_NAME'];
        $db = new mysqli($dbHost, $dbUser, $dbPassword, $dbDatabase);

        return $db;
    }

    /**
     * Hämtar en användare baserat på ID.
     *
     * @param mysqli $db Databasanslutning.
     * @param int $userId Användarens ID.
     * @return array|null Assoc-array med användardata eller null.
    */

    function getUserById($db, $userId) {
        $statement = $db->prepare("SELECT * FROM site_users WHERE id = ?");
        $statement->bind_param('i', $userId);
        $statement->execute();
        $result = $statement->get_result();
        $user = $result->fetch_assoc();
        return $user;
    }

    /**
     * Hämtar en användare baserat på användarnamn.
     *
     * @param mysqli $db Databasanslutning.
     * @param string $username Användarnamn.
     * @return array|null Assoc-array med användardata eller null.
    */

    function getUserByUsername($db, $username) {
        $statement = $db->prepare("SELECT * FROM site_users WHERE username = ?");
        $statement->bind_param('s', $username);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_assoc(); 
    }

    /**
     * Hanterar användarinloggning.
     *
     * Verifierar användarnamn och lösenord samt
     * sätter sessionsvariabler vid lyckad inloggning.
     *
     * @param string $username Användarnamn.
     * @param string $password Lösenord.
     * @return bool True vid lyckad inloggning.
    */

    function login($username, $password) {
        $db = connectToDb();
        $user = getUserByUsername($db, $username);

        if ( ! $user) {
            $_SESSION['message'] = "Användarnamn eller lösenord felaktigt!"; 
            header('Location: index.php');
            exit();
        }

        $hashedPassword = $user['password'];
        if ( ! password_verify($password, $hashedPassword)) {
            $_SESSION['message'] = "Användarnamn eller lösenord felaktigt!"; 
            header("Location: index.php");
            exit();
        }

        $_SESSION['loggedIn'] = TRUE;
        $_SESSION['userId'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true; 
    }

    /**
     * Kontrollerar att användaren är inloggad.
     *
     * Om användaren inte är inloggad skickas
     * användaren tillbaka till inloggningssidan.
     *
     * @return void
    */

    function requireLogin() {
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
            header("Location: index.php");
            exit;
        }
    }

    /**
     * Kontrollerar att användaren är administratör.
     *
     * Endast användaren med användarnamnet "admin"
     * får åtkomst till skyddade funktioner.
     *
     * @return void
    */

    function requireAdmin() {
        if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
            header("Location: home.php");
            exit;
        }
    }

    /**
     * Skapar ett nytt foruminlägg.
     *
     * Sparar titel, innehåll och användar-ID
     * i databasen tillsammans med datum och tid.
     *
     * @param mysqli $db Databasanslutning.
     * @param string $title Titel på inlägget.
     * @param int $user_id ID för användaren.
     * @param string $content Innehåll i inlägget.
     * @return bool True om inlägget sparades korrekt.
    */

    function createPost($db, $title, $user_id, $content) {
        $createdAt = date('Y-m-d H:i:s'); 
        $statement = $db->prepare("INSERT INTO forumpost (user_id, title, content, created_at) VALUES (?, ?, ?, ?)"); 
        $statement->bind_param('isss', $user_id, $title, $content, $createdAt);
        return $statement->execute(); 
    }

    /**
     * Hämtar de senaste foruminläggen.
     *
     * Standardvärdet är 3 inlägg, men detta kan ändras
     * genom att ange ett annat limit-värde.
     *
     * @param mysqli $db Databasanslutning.
     * @param int $limit Antal inlägg som ska hämtas.
     * @return array Lista med foruminlägg.
    */

    function getLatestPosts($db, $limit = 3) { 
        $sql = "SELECT forumpost.*, site_users.username FROM forumpost JOIN site_users 
                ON forumpost.user_id = site_users.id ORDER BY created_at DESC LIMIT " . (int)$limit;
        $result = $db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Hämtar kommentarer till ett specifikt foruminlägg.
     *
     * Kommentarerna sorteras i stigande ordning efter datum.
     *
     * @param mysqli $db Databasanslutning.
     * @param int $postId ID för foruminlägget.
     * @return array Lista med kommentarer.
    */

    function getComments($db, $postId) {
        $statement = $db->prepare("SELECT comments.*, site_users.username FROM comments JOIN site_users ON comments.userid = site_users.id 
                                WHERE comments.postid = ? ORDER BY comments.posted_at ASC");
        $statement->bind_param('i', $postId);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Sparar en kommentar till ett foruminlägg.
     *
     * Funktionen stödjer även svar på kommentarer
     * genom parent_comment_id.
     *
     * @param mysqli $db Databasanslutning.
     * @param int $postId ID för inlägget.
     * @param int $userId ID för användaren.
     * @param string $comment Kommentarens innehåll.
     * @param int|null $parentCommentId ID för föräldrakommentar.
     * @return bool True om kommentaren sparades korrekt.
    */

    function saveComment($db, $postId, $userId, $comment, $parentCommentId = null) {
        $postedAt = date('Y-m-d H:i:s');
        $statement = $db->prepare("INSERT INTO comments (postid, userid, comment, posted_at, parent_comment_id) VALUES (?, ?, ?, ?, ?)");
        $statement->bind_param('iissi', $postId, $userId, $comment, $postedAt, $parentCommentId);
        
        return $statement->execute();
    }

    /**
     * Hämtar en specifik boulder från databasen.
     *
     * @param mysqli $db Databasanslutning.
     * @param int $boulderId Boulderns ID.
     * @return array|null Assoc-array med boulderdata eller null.
    */

    function getBoulder($db, $boulderId) { 
        $statement = $db->prepare("SELECT * FROM bouldertable WHERE id = ?");
        $statement->bind_param('i', $boulderId);
        $statement->execute();
        $result = $statement->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Uppdaterar information om en boulder.
     *
     * @param mysqli $db Databasanslutning.
     * @param int $id Boulderns ID.
     * @param string $boulder Boulderns namn.
     * @param string $grade Svårighetsgrad.
     * @param string $area Område.
     * @param string $comment Kommentar om bouldern.
     * @return void
    */

    function updateBoulder($db, $id, $boulder, $grade, $area, $comment) {
        $statement = $db->prepare("UPDATE bouldertable SET boulder = ?, grade = ?, area = ?, comment = ? WHERE id = ?");
        $statement->bind_param('ssssi', $boulder, $grade, $area, $comment, $id);
        $statement->execute();
    }

    /**
     * Hämtar aktiviteter sorterade efter datum.
     *
     * Standardvärdet är 3 aktiviteter, men detta
     * kan ändras genom limit-parametern.
     *
     * @param mysqli $db Databasanslutning.
     * @param int $limit Antal aktiviteter som ska hämtas.
     * @return mysqli_result Resultat från databasen.
    */

    function getActivities($db, $limit = 3) { 
        $sql = "SELECT * FROM activities ORDER BY date ASC LIMIT " . (int)$limit;
        return $db->query($sql);
    }
?>
