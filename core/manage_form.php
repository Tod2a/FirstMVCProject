<?php
//fonction qui va vérifier si le champ existe et est remplit
function is_empty (string $field, array $usersEntries): bool
{
    return isset($usersEntries[$field]) && !empty($usersEntries[$field]);
}
//fonction qui vérifie si l'email est valide
function is_validEmail (string $field, array $usersEntries): bool
{
    return filter_var($usersEntries[$field], FILTER_VALIDATE_EMAIL);
}

function is_minLength (string $field, array $usersEntries, int $minLength): bool
{
    return strlen($usersEntries[$field]) >= $minLength;
}

function is_maxLength (string $field, array $usersEntries, int $maxLength): bool
{
    return strlen($usersEntries[$field]) <= $maxLength;
}

function is_minMaxLength (string $field, array $usersEntries, int $minLength, int $maxLength): bool
{
    return is_minLength($field, $usersEntries, $minLength) && is_maxLength($field, $usersEntries, $maxLength);
}

//fonction qui va vérifier si deux champs sont identiques en cas de nécéssité d'un champs de confirmation
function is_confirmed (string $field, array $usersEntries, string $secondField):bool
{
    return $usersEntries[$field] === $usersEntries[$secondField];
}

//fonction qui va vérifier dans une base de donnée si le champ existe déjà, à utiliser dans le cas des champs unique.
function is_unique (string $field, array $usersEntries, string $database, string $table, string $entry):bool
{
    $nomDuServeur = 'localhost';
    $nomUtilisateur = 'root';
    $motDePasse = '';
    $nomBDD = $database;

    try
    {
        $pdo = new PDO("mysql:host=$nomDuServeur;dbname=$nomBDD", $nomUtilisateur, $motDePasse);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //on va chercher toutes les données stockées dans le champs voulu
        $stmt = $pdo->query("SELECT $entry FROM $table");

        //on les stocks dans une variable.
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    catch(PDOException $e)
    {
     echo 'Erreur : ' . $e->getMessage();
    }

    //on vérifie si l'entrée de l'utilisateurs est déjà présente et si c'est le cas on return false.
    foreach ($values as $values)
    {
        if ($values[$entry] === $usersEntries[$field])
        {
            return false;
        }
    }

    return true;
}

//fonction qui automatise le formatage des balises d'access.
function format_access (string $field) 
{
    return 'aria-invalid="true" aria-describedby="' . $field . '-error"';
}

function format_finalMessage (int $errors)
{
    return $errors === 0 ? 'Formulaire bien envoyé!' : 'Formulaire invalide.';
}

function is_validateForm (array $fields, array $userEntries, string $dataBase = "test", string $table = "test")
{
    $errors = [];
    $access = [];
    $values = [];

    foreach($fields as $fieldName => $entry)
    {
        if (!is_empty($fieldName, $userEntries) && isset($entry['requis']) && $entry['requis'] === true)
        {
            $errors[$fieldName] = "Ce champ est requis.";
            $access[$fieldName] = format_access($fieldName);
        }
        elseif (is_empty($fieldName, $userEntries))
        {
            if (isset($entry['type']) && $entry['type'] === 'email' && !is_validEmail($fieldName, $userEntries))
            {
                $errors[$fieldName] = "Il faut donner un email valide";
                $access[$fieldName] = format_access($fieldName);
            }
            elseif (isset($entry['type']) && $entry['type'] === 'confirm' && !is_confirmed($fieldName, $userEntries, $entry['argConfirm']))
            {
                $secondFieldError = $entry['argConfirm'];
                $errors[$fieldName] = "Ces champs doivent être identiques";
                $errors[$secondFieldError] = "Ces champs doivent être identiques";
                $access[$fieldName] = format_access($fieldName);
                $access[$secondFieldError] = format_access($secondFieldError);
            }
            elseif (isset($entry['minLength']) && isset($entry['maxLength']) && !is_minMaxLength($fieldName, $userEntries, $entry['minLength'], $entry['maxLength']))
            {
                $errors[$fieldName] = "Il faut entre " . $entry['minLength'] . " et " . $entry['maxLength'] . " caractères.";
                $access[$fieldName] = format_access($fieldName);
            }
            elseif (isset($entry['minLength']) && !is_minLength($fieldName, $userEntries, $entry['minLength']))
            {
                $errors[$fieldName] = 'Il faut minimum ' . $entry['minLength'] . " caractères.";
                $access[$fieldName] = format_access($fieldName);
            }
            elseif (isset($entry['maxLength']) && !is_maxLength($fieldName, $userEntries, $entry['maxLength']))
            {
                $errors[$fieldName] = 'il faut maximum ' . $entry['maxLength'] . " caractères.";
                $access[$fieldName] = format_access($fieldName);
            }
            elseif (isset($entry['unique']) && $entry['unique'] === true && !is_unique($fieldName, $userEntries, $dataBase, $table, $entry['tableField']))
            {
                $errors[$fieldName] = 'ce champ existe déjà, entrez une valeur différente';
                $access[$fieldName] = format_access($fieldName);
            }
        }
        $values[$fieldName] = $userEntries[$fieldName];
        if (!isset($errors[$fieldName]))
        {
            $access[$fieldName] = 'aria-invalid="false"';
        }
    }
    if (count($errors) === 0)
    {
        $values = [];
    }

    return [$errors, $values, $access];
}

?>