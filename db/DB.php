<?php
$nomDuServeur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = '';
/*
script used to create the database for the project
*/
// Try to establish a connection to the database:
try
{
    // Instantiate a new connection.
    $pdo = new PDO("mysql:host=$serverName", $username, $password);

    // Set the error mode to "exception".
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Execute the SQL query to create the "bdd_projet_web" database.
    $pdo->exec("CREATE DATABASE bdd_projet_web DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;");
}
// Catch exceptions in case of a connection error:
catch(PDOException $e)
{
    echo 'Error: ' . $e->getMessage();
}
?>