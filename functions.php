<?php

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


function connectToDb(): mysqli {
    $dbUser = $_ENV['DB_USER'] ?? '';
    $dbPass = $_ENV['DB_PASS'] ?? '';
    $dbName = $_ENV['DB_NAME'] ?? '';

    if ($dbUser === '' || $dbPass === '' || $dbName === '') {
        throw new RuntimeException('Missing DB configuration. Check your .env file.');
    }

    $db = new mysqli(
        'ostrawebb.se',
        $dbUser,
        $dbPass,
        $dbName
    );

    if ($db->connect_error) {
        throw new RuntimeException('Database connection failed: ' . $db->connect_error);
    }

    return $db;

}


function getUserById($db, $userId) {
    $statement = $db->prepare("SELECT * FROM blogg_users WHERE id = ?");
    $statement->bind_param('i', $userId);
    $statement->execute();
    $result = $statement->get_result();
    $user = $result->fetch_assoc();
    return $user;
}



function getUserByUsername($db, $username) {
    $statement = $db->prepare("SELECT * FROM blogg_users WHERE username = ?");
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
    
    return true; 
}




?>