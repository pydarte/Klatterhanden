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




?>