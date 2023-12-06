<?php
$nomDuServeur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = '';

// Tenter d'établir une connexion à la base de données :
try
{
    // Instancier une nouvelle connexion.
    $pdo = new PDO("mysql:host=$nomDuServeur", $nomUtilisateur, $motDePasse);

    // Définir le mode d'erreur sur "exception".
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Exécuter la requête SQL pour créer la base de données "bdd_ifosup".
    $pdo->exec("CREATE DATABASE bdd_projet_web DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;");
}
// Capturer les exceptions en cas d'erreur de connexion :
catch(PDOException $e)
{
    echo 'Erreur : ' . $e->getMessage();
}
?>