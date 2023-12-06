<?php
const SERVEUR = 'localhost';
const UTILISATEUR = 'root';
const MDP = '';
const BDD = "bdd_projet_web";
const TABLE = "t_utilisateur_uti";

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

function get_tableValues (array $userValues, array $tableFields)
{
    $values = [];
    foreach ($tableFields as $field => $value)
    {
        if(!isset($value['type']) || $value['type'] != 'confirm')
        {
            if (isset($value['type']) && $value['type'] === 'motDePasse')
            {
                $values[$field] = password_hash($userValues[$field], PASSWORD_BCRYPT);
            }
            else
            {
                $values[$field] = $userValues[$field];
            }
        }
    }
    return $values;
}

function set_insertrequest (array $tableFields, string $table)
{
    $number = 0;
    foreach ($tableFields as $key => $value)
    {
        if (isset($value['tableField']) && !empty($value['tableField']))
        {
            $number++;
        }
    }
    $tableRequest = '';
    $valuesRequest = '';
    $values = [];
    $count = 0;

    foreach($tableFields as $field => $value)
    {
        $count++;
        if ($count < $number && isset($value['tableField']) && !empty($value['tableField']))
        {
            $tableRequest .= $value['tableField'] . ", ";
            $valuesRequest .= ":" . $field . ", ";
            $values[$field] = ":" . $field;
        }
        elseif (isset($value['tableField']) && !empty($value['tableField']))
        {
            $tableRequest .= $value['tableField'];
            $valuesRequest .= ":" . $field;
            $values[$field] = ":" . $field;
        }
    }
    $request = "INSERT INTO " . $table . " (" . $tableRequest . ") VALUES (" . $valuesRequest . ")";
    return [$request, $values];
}

function insert_values (array $userValues, array $fieldsConfig, string $table)
{
    
    $pdo = connect_db();
        
    [$request, $values] = set_insertrequest($fieldsConfig, $table);
    $user = get_tableValues ($userValues, $fieldsConfig);

    $stmt = $pdo->prepare($request);

    foreach($values as $value => $field)
    {
        $valeur=$user[$value];
                        
        $stmt->bindValue($field, $valeur);
    }

    $stmt->execute();

    return "inscription réussie";

}

function send_validateMail (array $account)
{
    $destinataire = $account['uti_email'];
    $sujet = 'Code de validation de votre compte';
    $message = 'voici votre code de validation ' . $account['uti_code_activation'];
    $entete = "From: supersite@site.fr\r\n" . 
        "To: $destinataire\r\n" . 
        "Suject: $sujet\r\n" . 
        "Content-Type: text/html; charset=\"UTF-8\"\r\n" . 
        "Content-Transfer-Encoding: quoted-printable\r\n";
    mail($destinataire, $sujet, $message, $entete);
}

function get_userByPseudo (string $pseudo, string $tablepseudo, string $table = TABLE)
{
    $pdo = connect_db();
    $request = "SELECT * FROM $table WHERE $tablepseudo='$pseudo'";
    $stmt = $pdo->prepare($request);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($user[0]))
    {
        return $user[0];
    }
}

function get_userById (int $id, string $tableid, string $table = TABLE)
{
    $pdo = connect_db();
    $request = "SELECT * FROM $table WHERE $tableid=$id";
    $stmt = $pdo->prepare($request);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $user[0];
}

function check_password (string $user, string $post)
{
    return password_verify($post, $user);
}


?>