<?php

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


function connectToDb() {
    $dbHost = 'ostrawebb.se';
    $dbUser = 'wsp2526_davbuw';
    $dbPassword = 'bixyjiti34';
    $dbDatabase = 'wsp2526_davbuw';
    $db = new mysqli($dbHost, $dbUser, $dbPassword, $dbDatabase);


    return $db;
}


function getUserById($db, $userId) {
    $statement = $db->prepare("SELECT * FROM site_users WHERE id = ?");
    $statement->bind_param('i', $userId);
    $statement->execute();
    $result = $statement->get_result();
    $user = $result->fetch_assoc();
    return $user;
}


function getUserByUsername($db, $username) {
    $statement = $db->prepare("SELECT * FROM site_users WHERE username = ?");
    $statement->bind_param('s', $username);
    $statement->execute();
    $result = $statement->get_result();
    return $result->fetch_assoc(); 
}


function login($username, $password) {
    $db = connectToDb();
    $user = getUserByUsername($db, $username);

    if ( ! $user) {
        $_SESSION['message'] = "Username or Password incorrect!"; 
        header('Location: index.php');
        exit();
    }

    $hashedPassword = $user['password'];

    if ( ! password_verify($password, $hashedPassword)) {
        $_SESSION['message'] = "Username or Password incorrect!"; 
        header("Location: index.php");
        exit();
    }

    $_SESSION['loggedIn'] = TRUE;
    $_SESSION['userId'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    return true; 
}


function createPost($db, $title, $user_id, $content) {
    $createdAt = date('Y-m-d H:i:s'); 

    $statement = $db->prepare("INSERT INTO forumpost (user_id, title, content, created_at) VALUES (?, ?, ?, ?)"); 

    $statement->bind_param('isss', $user_id, $title, $content, $createdAt);
    
    return $statement->execute(); 
}

function getLatestPosts($db) {

    $sql = "SELECT forumpost.*, site_users.username 
            FROM forumpost 
            JOIN site_users ON forumpost.user_id = site_users.id 
            ORDER BY created_at DESC LIMIT 10";
            
    $result = $db->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getComments($db, $postId) {
    $statement = $db->prepare("SELECT comments.*, site_users.username 
                              FROM comments 
                              JOIN site_users ON comments.userid = site_users.id 
                              WHERE comments.postid = ? 
                              ORDER BY comments.posted_at ASC");
    $statement->bind_param('i', $postId);
    $statement->execute();
    $result = $statement->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function saveComment($db, $postId, $userId, $comment, $parentCommentId = null) {
    $postedAt = date('Y-m-d H:i:s');
    
    $statement = $db->prepare("INSERT INTO comments (postid, userid, comment, posted_at, parent_comment_id) VALUES (?, ?, ?, ?, ?)");
    $statement->bind_param('iissi', $postId, $userId, $comment, $postedAt, $parentCommentId);
    
    return $statement->execute();
}



?>
