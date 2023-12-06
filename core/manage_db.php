<?php

function connect_db ()
{
    $nomDuServeur = 'localhost';
    $nomUtilisateur = 'root';
    $motDePasse = '';
    $nomBDD = "bdd_projet_web";
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

?>