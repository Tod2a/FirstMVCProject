<?php
$nomDuServeur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = '';
$nomBDD = "bdd_projet_web";

try
{
    // Instancier une nouvelle connexion.
    $pdo = new PDO("mysql:host=$nomDuServeur;dbname=$nomBDD", $nomUtilisateur, $motDePasse);

    // Définir le mode d'erreur sur "exception".
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pseudo = 'Tod2a';
    $email = 'claudy.foucaultn@email.com';
    $password = 'banana1234';
    $motDePasseHache = password_hash($password, PASSWORD_BCRYPT);

    $requete = "INSERT INTO t_utilisateur_uti (uti_pseudo, uti_email, uti_motdepasse) VALUES (:pseudo, :email, :passworld)";

    $stmt = $pdo->prepare($requete);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':passworld', $motDePasseHache);

    if ($stmt->execute())
    {
       echo "Enregistrement créé avec succès.";
    }
    else
    {
        echo "Erreur lors de la création de l'enregistrement.";
    }


}
// Capturer les exceptions en cas d'erreur de connexion :
catch(PDOException $e)
{
    echo 'Erreur : ' . $e->getMessage();
}



?>