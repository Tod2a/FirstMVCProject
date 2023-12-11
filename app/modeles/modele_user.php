<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_db.php';

function get_fieldConnexionConfig()
{
    return [
        'connexion_pseudo' => [
            'requis' => true,
            'type' => 'pseudo',
            'minLength' => 2,
            'maxLength' => 255,
            'tableField' => 'uti_pseudo'
        ],
        'connexion_motDePasse' => [
            'requis' => true,
            'minLength' => 8,
            'maxLength' => 72,
            'type' => 'motDePasse',
            'tableField' => 'uti_motdepasse'
        ]
    ];
}

function get_fieldActivationConfig()
{
    return [
        'activation_utilisateurId' => [
            'tableField' => 'uti_id',
            'type' => 'id'
        ],
        'activation_code' => [
            'requis' => true,
            'type' => 'activationCode',
            'minLength' => 5,
            'maxLength' => 5,
            'tableField' => 'uti_code_activation',
            'activedField' => 'uti_compte_active'
        ]
    ];
}

function get_fieldInscriptionConfig()
{
    return [
                'inscription_pseudo' => [
                    'requis' => true,
                    'unique' => true,
                    'tableField' => 'uti_pseudo',
                    'minLength' => 2,
                    'maxLength' => 255
                ],
                'inscription_email' => [
                    'requis' => true,
                    'unique' => true,
                    'tableField' => 'uti_email',
                    'type' => 'email'
                ],
                'inscription_motDePasse' => [
                    'requis' => true,
                    'minLength' => 8,
                    'maxLength' => 72,
                    'tableField' => 'uti_motdepasse',
                    'type' => 'motDePasse'
                ],
                'inscription_motDePasse_confirmation' => [
                    'requis' => true,
                    'minLength' => 8,
                    'maxLength' => 72,
                    'type' => 'confirm',
                    'argConfirm' => 'inscription_motDePasse'
                ]
            ];
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

function send_validateMail (array $account, string $code)
{
    $destinataire = $account['uti_email'];
    $sujet = 'Code de validation de votre compte';
    $message = 'voici votre code de validation ' . $code;
    $entete = "From: supersite@site.fr\r\n" . 
        "To: $destinataire\r\n" . 
        "Subject: $sujet\r\n" . 
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

function set_activationCode (string $id, string $table = TABLE)
{
    $code = strval(rand(10000, 99999));
    $user = get_userById($id, 'uti_id');
  
    $pdo = connect_db();
    $requete = "UPDATE $table SET uti_code_activation = :code WHERE uti_id = :id";
    $stmt = $pdo->prepare($requete);

    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute())
    {
        send_validateMail($user, $code);
    }
}
//vérifie le code d'activation et active le compte si c'est correct
function set_validation(string $code, string $table = TABLE)
{
    $tablefield ='uti_id';
    $activeField ='uti_compte_active';
    $id = $_SESSION['id'];
    $user = get_userById($id, $tablefield);
    print_r($user);
    if($code === $user['uti_code_activation'])
    {
        $pdo = connect_db();           
        $requete = "UPDATE $table SET $activeField = 1 WHERE $tablefield = $id";
        $stmt = $pdo->prepare($requete);
        $stmt->execute();
        $_SESSION['activated'] = true;
        return 'Compte activé';
    }
    else
    {
        return "erreur d'activation";
    }
}

?>