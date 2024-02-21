<?php

$serverName = 'localhost';
$username = 'root';
$password = '';
$dbName = "bdd_projet_web";
/*
Script used to drop the table
*/
// Try to establish a connection to the database:
try
{
    // Instantiate a new connection.
    $pdo = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);

    // Set the error mode to "exception".
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to drop the "t_utilisateur_uti" table.
    $query = 
    "
        DROP TABLE t_utilisateur_uti
    ";

    // Execute the SQL query to drop the "t_utilisateur_uti" table.
    $pdo->exec($query);
}
// Catch exceptions in case of a connection error:
catch(PDOException $e)
{
    echo 'Error: ' . $e->getMessage();
}
?>