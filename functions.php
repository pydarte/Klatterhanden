<?php

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function connectToDb(){

$db = new mysqli(
    'ostrawebb.se', 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'],
    $_ENV['DB_USER']
);
return $db;

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
    
    return true; 
}




?>