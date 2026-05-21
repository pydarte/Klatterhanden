<?php

    // Startar session och ansluter till databasen
    session_start();
    require_once('functions.php');
    $db = connectToDb();

    $errors = [];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $email = $_POST['email'];

    // Validering av användarnamn (minsta längd)
    if (strlen($username) < 3) {
        $errors[] = 'Användarnamn för kort.';
    }

    // Validering av användarnamn (maxlängd)
    if (strlen($username) > 16) {
        $errors[] = 'Användarnamn för långt.';
    }

    // Validering av lösenord (minsta längd)
    if (strlen($password) < 4) {
        $errors[] = 'Lösenord för kort.';
    }

    // Kontrollerar att lösenord matchar bekräftelsen
    if ($password != $passwordConfirm) {
        $errors[] = 'Lösenord stämmer inte.';
    }

    // Om valideringsfel finns skickas användaren tillbaka med felmeddelanden
    if(count($errors) > 0) {
        $_SESSION['formErrors'] = $errors;
        header('Location: index.php');
        exit;
    } else {

    // Krypterar lösenordet innan lagring i databasen
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Lägger in ny användare i databasen med prepared statement
    $statement = $db->prepare("INSERT INTO site_users (username, password, email) VALUES (?, ?, ?)");
    $statement->bind_param('sss', $username, $hashedPassword, $email);
    $statement->execute();

    header('Location: index.php');
    exit;
    }
?>