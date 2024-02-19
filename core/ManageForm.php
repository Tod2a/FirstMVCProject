<?php
namespace Core;

use \PDO;

use Core\ManageDb;

class ManageForm
{


    //fonction qui va vérifier si le champ existe et est remplit
    private static function is_empty (string $field, array $usersEntries): bool
    {
        return isset($usersEntries[$field]) && !empty($usersEntries[$field]);
    }
    //fonction qui vérifie si l'email est valide
    private static function is_validEmail (string $field, array $usersEntries): bool
    {
        return filter_var($usersEntries[$field], FILTER_VALIDATE_EMAIL);
    }

    private static function is_minLength (string $field, array $usersEntries, int $minLength): bool
    {
        return strlen($usersEntries[$field]) >= $minLength;
    }

    private static function is_maxLength (string $field, array $usersEntries, int $maxLength): bool
    {
        return strlen($usersEntries[$field]) <= $maxLength;
    }

    private static function is_minMaxLength (string $field, array $usersEntries, int $minLength, int $maxLength): bool
    {
        return ManageForm::is_minLength($field, $usersEntries, $minLength) && ManageForm::is_maxLength($field, $usersEntries, $maxLength);
    }

    //fonction qui va vérifier si deux champs sont identiques en cas de nécéssité d'un champs de confirmation
    private static function is_confirmed (string $field, array $usersEntries, string $secondField):bool
    {
        return $usersEntries[$field] === $usersEntries[$secondField];
    }

    //fonction qui va vérifier dans une base de donnée si le champ existe déjà, à utiliser dans le cas des champs unique.
    private static function is_unique (string $field, array $usersEntries, string $table, string $entry):bool
    {
        $values;

        $pdo = ManageDb::connect_db();

        //on va chercher toutes les données stockées dans le champs voulu
        $stmt = $pdo->query("SELECT $entry FROM $table");

        //on les stocks dans une variable.
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
        //on vérifie si l'entrée de l'utilisateurs est déjà présente et si c'est le cas on return false.
        if(count($values) > 0)
        {
            foreach ($values as $value)
            {
                if ($value[$entry] === $usersEntries[$field])
                {
                    return false;
                }
            }
        }   

        return true;
    }
    
    //fonction qui automatise le formatage des balises d'access.
    private static function format_access (string $field) 
    {
        return 'aria-invalid="true" aria-describedby="' . $field . '-error"';
    }

    public static function format_finalMessage (int $errors)
    {
        return $errors === 0 ? 'Formulaire bien envoyé!' : 'Formulaire invalide.';
    }

    public static function is_validateForm (array $fields, array $userEntries, string $table = "test", string $dataBase = "bdd_projet_web")
    {
        $errors = [];
        $access = [];
        $values = [];

        foreach($fields as $fieldName => $entry)
        {
            if (!ManageForm::is_empty($fieldName, $userEntries) && isset($entry['required']) && $entry['required'] === true)
            {
                $errors[$fieldName] = "Ce champ est requis.";
                $access[$fieldName] = ManageForm::format_access($fieldName);
            }
            elseif (ManageForm::is_empty($fieldName, $userEntries))
            {
                if (isset($entry['type']) && $entry['type'] === 'email' && !ManageForm::is_validEmail($fieldName, $userEntries))
                {
                    $errors[$fieldName] = "Il faut donner un email valide";
                    $access[$fieldName] = ManageForm::format_access($fieldName);
                }
                elseif (isset($entry['type']) && $entry['type'] === 'confirm' && !ManageForm::is_confirmed($fieldName, $userEntries, $entry['argConfirm']))
                {
                    $secondFieldError = $entry['argConfirm'];
                    $errors[$fieldName] = "Ces champs doivent être identiques";
                    $errors[$secondFieldError] = "Ces champs doivent être identiques";
                    $access[$fieldName] = ManageForm::format_access($fieldName);
                    $access[$secondFieldError] = ManageForm::format_access($secondFieldError);
                }
                elseif (isset($entry['minLength']) && isset($entry['maxLength']) && !ManageForm::is_minMaxLength($fieldName, $userEntries, $entry['minLength'], $entry['maxLength']))
                {
                    $errors[$fieldName] = "Il faut entre " . $entry['minLength'] . " et " . $entry['maxLength'] . " caractères.";
                    $access[$fieldName] = ManageForm::format_access($fieldName);
                }
                elseif (isset($entry['minLength']) && !ManageForm::is_minLength($fieldName, $userEntries, $entry['minLength']))
                {
                    $errors[$fieldName] = 'Il faut minimum ' . $entry['minLength'] . " caractères.";
                    $access[$fieldName] = ManageForm::format_access($fieldName);
                }
                elseif (isset($entry['maxLength']) && !ManageForm::is_maxLength($fieldName, $userEntries, $entry['maxLength']))
                {
                    $errors[$fieldName] = 'il faut maximum ' . $entry['maxLength'] . " caractères.";
                    $access[$fieldName] = ManageForm::format_access($fieldName);
                }
                elseif (isset($entry['unique']) && $entry['unique'] === true && !ManageForm::is_unique($fieldName, $userEntries, $table, $entry['tableField']))
                {
                    $errors[$fieldName] = 'ce champ existe déjà, entrez une valeur différente';
                    $access[$fieldName] = ManageForm::format_access($fieldName);
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

        $finalMessage = ManageForm::format_finalMessage(count($errors));

        return ['errors'=>$errors, 'values'=>$values, 'access'=>$access, 'finalMessage'=>$finalMessage];
    }

    public static function send_mail (array $array)
    {
        $expediteur = $array['email'];
        $message = $array['message'];
        $destinataire = "test@test.fr";
        $sujet = "projet web - formulaire de contact";
        $entete = "From: $expediteur\r\n" . 
            "To: $destinataire\r\n" . 
            "Suject: $sujet\r\n" . 
            "Content-Type: text/html; charset=\"UTF-8\"\r\n" . 
            "Content-Transfer-Encoding: quoted-printable\r\n";
        mail($destinataire, $sujet, $message, $entete);
    }

    public static function set_CSRFToken(): string
    {
        // random_bytes(32) génère 32 octets (256 bits) de données aléatoires.
        // bin2hex() convertit les données binaires en chaîne de 64 caractères hexadécimaux.
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }

    private static function is_validCSRF(): bool
    {
        return (
            isset($_POST['csrf_token']) &&
            $_POST['csrf_token'] === $_SESSION['csrf_token']
        );
    }

    private static function is_validRequestFrequency($maxRequests = 5, $timeWindow = 10)
    {
        $currentTime = time();

        if (isset($_SESSION['last_submit_time'])) {
            $lastSubmitTime = $_SESSION['last_submit_time'];

            $timeDifference = $currentTime - $lastSubmitTime;

            if ($timeDifference <= $timeWindow && $_SESSION['num_requests'] < $maxRequests) {
                $_SESSION['num_requests']++; 
                return true; 
            } elseif ($timeDifference > $timeWindow) {
                $_SESSION['num_requests'] = 1;
                $_SESSION['last_submit_time'] = $currentTime;
                return true; 
            } else {
                return false; 
            }
        } else {
            $_SESSION['num_requests'] = 1;
            $_SESSION['last_submit_time'] = $currentTime;
            return true; 
        }
    }

    public static function is_validCSRFAndFrequency()
    {
        return ManageForm::is_validRequestFrequency() && ManageForm::is_validCSRF();
    }

}
?>