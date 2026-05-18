<?php
    session_start();
    require_once('functions.php');
    $db = connectToDb();

    $errors = [];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $email = $_POST['email'];

    if (strlen($username) < 3) { //Kollar om användarnamn är under 3 tecken 
        $errors[] = 'Användarnamn för kort.';
    }

    if (strlen($username) > 16) { //Checkar om användarnamn är över 16 tecken
        $errors[] = 'Användarnamn för långt.';
    }

    if (strlen($password) < 4) { //Checkar om lösenord är under 4 tecken
        $errors[] = 'Lösenord för kort.';
    }

    if ($password != $passwordConfirm) { //Checkar om lösenord stämmer
        $errors[] = 'Lösenord stämmer inte.';
    }

    if(count($errors) > 0) { //Finns det fel så skickas användaren tillbaka till index sidan.
        $_SESSION['formErrors'] = $errors;
        header('Location: index.php');
        exit;
    } else {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //Hashar lösenordet innan det sparas i databasen.

    $statement = $db->prepare("INSERT INTO site_users (username, password, email) VALUES (?, ?, ?)"); //Skapar SQL förfrågan för att skapa nya användare.
    $statement->bind_param('sss', $username, $hashedPassword, $email);
    $statement->execute();

    header('Location: index.php');
    exit;
    }
?>