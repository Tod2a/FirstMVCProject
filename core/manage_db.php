<?php
const SERVEUR = 'localhost';
const UTILISATEUR = 'root';
const MDP = '';
const BDD = "bdd_projet_web";

function connect_db (string $nomDuServeur = SERVEUR, string $nomBDD = BDD, string $nomUtilisateur = UTILISATEUR, string $motDePasse = MDP)
{
    try
    {

        $pdo = new PDO("mysql:host=$nomDuServeur;dbname=$nomBDD", $nomUtilisateur, $motDePasse);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo 'Erreur : ' . $e->getMessage();
    }
    return $pdo;
}

function get_byId (int $id, string $tableid, string $table)
{
    $pdo = connect_db();
    $request = "SELECT * FROM $table WHERE $tableid=$id";
    $stmt = $pdo->prepare($request);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $user[0];
}

?>