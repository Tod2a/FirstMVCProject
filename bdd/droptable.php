<?php

// entrée 1 : TodAa, ThomasCopin
$nomDuServeur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = '';
$nomBDD = "bdd_projet_web";

// Tenter d'établir une connexion à la base de données :
try
{
    // Instancier une nouvelle connexion.
    $pdo = new PDO("mysql:host=$nomDuServeur;dbname=$nomBDD", $nomUtilisateur, $motDePasse);

    // Définir le mode d'erreur sur "exception".
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $requete = 
    "
        DROP TABLE t_utilisateur_uti
    ";

    // Exécuter la requête SQL pour créer la table "t_utilisateur_uti".
    $pdo->exec($requete);
}
// Capturer les exceptions en cas d'erreur de connexion :
catch(PDOException $e)
{
    echo 'Erreur : ' . $e->getMessage();
}
?>