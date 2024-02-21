<?php
$serverName = 'localhost';
$username = 'root';
$password = '';
$dbName = "bdd_projet_web";

// Script used to create the table
// Try to establish a connection to the database:
try
{
    // Instantiate a new connection.
    $pdo = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);

    // Set the error mode to "exception".
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to create the "t_utilisateur_uti" table.
    $query = "
        CREATE TABLE t_utilisateur_uti (
            uti_id INT AUTO_INCREMENT PRIMARY KEY,
            uti_pseudo VARCHAR(255) NOT NULL UNIQUE,
            uti_email VARCHAR(255) NOT NULL UNIQUE,
            uti_motdepasse char(60) NOT NULL,
            uti_role ENUM('utilisateur', 'administrateur') NOT NULL DEFAULT 'utilisateur',
            uti_compte_active BOOLEAN NOT NULL DEFAULT 0,
            uti_code_activation char(5),
            uti_token char(60)
        )
    ";

    // Execute the SQL query to create the "t_utilisateur_uti" table.
    $pdo->exec($query);
}
// Catch exceptions in case of a connection error:
catch(PDOException $e)
{
    echo 'Error: ' . $e->getMessage();
}

?>