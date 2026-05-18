<?php
    session_start();
    session_destroy(); //Förstör sessionen så att användaren loggas ut.
    
    header('Location: index.php');
?>