<?php
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

    $requete = "
        CREATE TABLE t_utilisateur_uti (
            uti_id INT AUTO_INCREMENT PRIMARY KEY,
            uti_pseudo VARCHAR(255) NOT NULL UNIQUE,
            uti_email VARCHAR(255) NOT NULL UNIQUE,
            uti_motdepasse char(60) NOT NULL,
            uti_role ENUM('utilisateur', 'administrateur') NOT NULL DEFAULT 'utilisateur',
            uti_compte_active BOOLEAN NOT NULL DEFAULT 0,
            uti_code_activation char(5)
        )
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