<?php
namespace Core;

use \PDO;

class ManageDb
{

    private const SERVEUR = 'localhost';
    private const UTILISATEUR = 'root';
    private const MDP = '';
    private const BDD = "bdd_projet_web";

    //Establishes a database connection
    public static function connect_db (string $nomDuServeur = self::SERVEUR, string $nomBDD = self::BDD, string $nomUtilisateur = self::UTILISATEUR, string $motDePasse = self::MDP)
    {
        //try to connect to the database
        try
        {

            $pdo = new PDO("mysql:host=$nomDuServeur;dbname=$nomBDD", $nomUtilisateur, $motDePasse);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo 'Erreur : ' . $e->getMessage();
        }

        //return the PDO object
        return $pdo;
    }

    //Retrieves a user from the database based on the provided ID
    public static function get_byId (int $id, string $tableid, string $table)
    {
        //connect to the database and make the request
        $pdo = ManageDb::connect_db();
        $request = "SELECT * FROM $table WHERE $tableid=$id";
        $stmt = $pdo->prepare($request);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //return the array with the user values
        return $user[0];
    }

}

?>