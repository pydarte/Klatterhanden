<?php
session_start();
require_once('functions.php');
$db = connectToDb();


$errors = [];

$username = $_POST['username'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];
$email = $_POST['email'];


if (strlen($username) < 3) {
    $errors[] = 'Användarnamn för kort.';
}

if (strlen($password) < 4) {
    $errors[] = 'Lösenord för kort.';
}

if ($password != $passwordConfirm) {
    $errors[] = 'Lösenord stämmer inte.';
}

/* Hanteringen */
if(count($errors) > 0) {
    $_SESSION['formErrors'] = $errors;
    header('Location: index.php');
    
} else {

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


$statement = $db->prepare("INSERT INTO blogg_users (username, password, email) VALUES (?, ?, ?)");
$statement->bind_param('sss', $username, $hashedPassword, $email);
$statement->execute();



header('Location: index.php');
exit;
}

?>