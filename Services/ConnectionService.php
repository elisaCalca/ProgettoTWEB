<?php
/*
Funzioni per la connessione al database.
*/

header('Content-Type: application/json');

function create_connection() {
    $dbname = "amazingdb";
    $host = "localhost";
    $username = "root";

    $dsn = "mysql:dbname=$dbname;host=$host";
    $db = new PDO($dsn, $username);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); # Exceptions are now enabled
    return $db;
}

?>