<?php

function connectToMysqli(){

$mysqli = new mysqli(
    'ostrawebb.se', 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'],
    $_ENV['DB_USER']
);
return $mysqli;

}





?>