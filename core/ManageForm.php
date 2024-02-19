<?php
namespace Core;

use \PDO;

use Core\ManageDb;

class ManageForm
{
    //Look if the field is empty and return a bool
    private static function is_empty (string $field, array $usersEntries): bool
    {
        return isset($usersEntries[$field]) && !empty($usersEntries[$field]);
    }

    //Look if the mail is valid
    private static function is_validEmail (string $field, array $usersEntries): bool
    {
        return filter_var($usersEntries[$field], FILTER_VALIDATE_EMAIL);
    }

    //Look if the length is long enough
    private static function is_minLength (string $field, array $usersEntries, int $minLength): bool
    {
        return strlen($usersEntries[$field]) >= $minLength;
    }

    //Look if the length is not too long
    private static function is_maxLength (string $field, array $usersEntries, int $maxLength): bool
    {
        return strlen($usersEntries[$field]) <= $maxLength;
    }

    //Combine the min and max length to look if the length is correct
    private static function is_minMaxLength (string $field, array $usersEntries, int $minLength, int $maxLength): bool
    {
        return ManageForm::is_minLength($field, $usersEntries, $minLength) && ManageForm::is_maxLength($field, $usersEntries, $maxLength);
    }

    //Look if the two field matches, using for the confirm fields
    private static function is_confirmed (string $field, array $usersEntries, string $secondField):bool
    {
        return $usersEntries[$field] === $usersEntries[$secondField];
    }

    //Look if the value send is already insert into the databe.
    private static function is_unique (string $field, array $usersEntries, string $table, string $entry):bool
    {
        $values;

        $pdo = ManageDb::connect_db();

        //select all values of the selected field
        $stmt = $pdo->query("SELECT $entry FROM $table");

        //put them on the variable
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
        //check if the value is already in the databse
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

        //return true if the value is not in the database
        return true;
    }
    
    //Format the access for the HTML
    private static function format_access (string $field) 
    {
        return 'aria-invalid="true" aria-describedby="' . $field . '-error"';
    }

    //Format the final message for the form
    public static function format_finalMessage (int $errors)
    {
        return $errors === 0 ? 'Formulaire bien envoyé!' : 'Formulaire invalide.';
    }

    /**
    * Validates a form based on specified rules for each field.
    *
    * @param array  $fields      An associative array defining the form fields and their validation rules.
    * @param array  $userEntries User-submitted form data.
    * @param string $table       Optional table name for unique constraint validation.
    * @param string $dataBase    Optional database name for unique constraint validation.
    *
    * @return array An array containing validation results, including errors, values, access, and a final message.
    */ 
    public static function is_validateForm (array $fields, array $userEntries, string $table = "", string $dataBase = "bdd_projet_web")
    {
        // Arrays to store validation results
        $errors = [];
        $access = [];
        $values = [];

        foreach($fields as $fieldName => $entry)
        {
            // Check if the field is not empty when required
            if (!ManageForm::is_empty($fieldName, $userEntries) && isset($entry['required']) && $entry['required'] === true)
            {
                // Set error message and update access attribute
                $errors[$fieldName] = "Ce champ est requis.";
                $access[$fieldName] = ManageForm::format_access($fieldName);
            }
            elseif (ManageForm::is_empty($fieldName, $userEntries))
            {
                //Check for valid email if necessary
                if (isset($entry['type']) && $entry['type'] === 'email' && !ManageForm::is_validEmail($fieldName, $userEntries))
                {
                    $errors[$fieldName] = "Il faut donner un email valide";
                    $access[$fieldName] = ManageForm::format_access($fieldName);
                }
                //Check for confirm field if necessary
                elseif (isset($entry['type']) && $entry['type'] === 'confirm' && !ManageForm::is_confirmed($fieldName, $userEntries, $entry['argConfirm']))
                {
                    $secondFieldError = $entry['argConfirm'];
                    $errors[$fieldName] = "Ces champs doivent être identiques";
                    $errors[$secondFieldError] = "Ces champs doivent être identiques";
                    $access[$fieldName] = ManageForm::format_access($fieldName);
                    $access[$secondFieldError] = ManageForm::format_access($secondFieldError);
                }
                //Check for the length
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
                //Check for unique field in the database if necessary
                elseif (isset($entry['unique']) && $entry['unique'] === true && !ManageForm::is_unique($fieldName, $userEntries, $table, $entry['tableField']))
                {
                    $errors[$fieldName] = 'ce champ existe déjà, entrez une valeur différente';
                    $access[$fieldName] = ManageForm::format_access($fieldName);
                }
            }
            //save the form value
            $values[$fieldName] = $userEntries[$fieldName];

            //Set the acces attribute if no errors
            if (!isset($errors[$fieldName]))
            {
                $access[$fieldName] = 'aria-invalid="false"';
            }
        }

        //If the form is valid, clean the values to clean de form
        if (count($errors) === 0)
        {
            $values = [];
        }

        //Format the final message
        $finalMessage = ManageForm::format_finalMessage(count($errors));

        //return the a golbal array with errors, values, access and the final message
        return ['errors'=>$errors, 'values'=>$values, 'access'=>$access, 'finalMessage'=>$finalMessage];
    }

    // Generates a CSRF token, stores it in the session, and returns the generated token.

    public static function set_CSRFToken(): string
    {
        // Generate 32 bytes (256 bits) of random data and convert it to a 64-character hexadecimal string.
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }

    //Validates whether the submitted CSRF token in the POST request matches the stored CSRF token in the session.

    private static function is_validCSRF(): bool
    {
        return (
            isset($_POST['csrf_token']) &&
            $_POST['csrf_token'] === $_SESSION['csrf_token']
        );
    }


    /**
    * Validates the frequency of incoming requests based on a maximum allowed number of requests
    * within a specified time window.
    *
    * @param int $maxRequests The maximum allowed number of requests within the given time window.
    * @param int $timeWindow  The time window (in seconds) during which the maximum number of requests is allowed.
    *
    * @return bool Returns true if the current request frequency is valid, false otherwise.
    */
    private static function is_validRequestFrequency($maxRequests = 5, $timeWindow = 10): bool
    {
        // Get the current timestamp
        $currentTime = time();

        // Check if the session contains information about the last submitted request
        if (isset($_SESSION['last_submit_time'])) {
            $lastSubmitTime = $_SESSION['last_submit_time'];

            // Calculate the time difference between the current time and the last submitted request
            $timeDifference = $currentTime - $lastSubmitTime;

            // Check if the time difference is within the specified time window and the maximum requests limit is not reached
            if ($timeDifference <= $timeWindow && $_SESSION['num_requests'] < $maxRequests) {
                $_SESSION['num_requests']++;
                return true; // Valid request frequency
            } elseif ($timeDifference > $timeWindow) {
                // Reset request count and update last submitted time for a new time window
                $_SESSION['num_requests'] = 1;
                $_SESSION['last_submit_time'] = $currentTime;
                return true; // Valid request frequency
            } else {
                return false; // Request frequency exceeded
            }
        } else {
            // Initialize session variables for the first request
            $_SESSION['num_requests'] = 1;
            $_SESSION['last_submit_time'] = $currentTime;
            return true; // Valid request frequency
        }
    }


    //Check if CSRF and request fraquency are valid
    public static function is_validCSRFAndFrequency(): bool
    {
        return ManageForm::is_validRequestFrequency() && ManageForm::is_validCSRF();
    }

}
?>