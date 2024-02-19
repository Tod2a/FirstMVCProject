<?php
namespace App\Models;

use Core\ManageDb;

use \PDO;

class ModelUser
{
    // Define the table name for user data
    private const TABLE = "t_utilisateur_uti";

    public static function get_table()
    {
        return self::TABLE;
    }

    // Field configuration for the connection form
    public static function get_fieldConnexionConfig()
    {
        return [
            'connexion_pseudo' => [
                'required' => true,
                'type' => 'pseudo',
                'minLength' => 2,
                'maxLength' => 255,
                'tableField' => 'uti_pseudo'
            ],
            'connexion_motDePasse' => [
                'required' => true,
                'minLength' => 8,
                'maxLength' => 72,
                'type' => 'motDePasse',
                'tableField' => 'uti_motdepasse'
            ]
        ];
    }

    // Field configuration for the activation form
    public static function get_fieldActivationConfig()
    {
        return [
            'activation_utilisateurId' => [
                'tableField' => 'uti_id',
                'type' => 'id'
            ],
            'activation_code' => [
                'required' => true,
                'type' => 'activationCode',
                'minLength' => 5,
                'maxLength' => 5,
                'tableField' => 'uti_code_activation',
                'activedField' => 'uti_compte_active'
            ]
        ];
    }

    // Field configuration for the registration form
    public static function get_fieldRegistrationConfig()
    {
        return [
                    'inscription_pseudo' => [
                        'required' => true,
                        'unique' => true,
                        'tableField' => 'uti_pseudo',
                        'minLength' => 2,
                        'maxLength' => 255
                    ],
                    'inscription_email' => [
                        'required' => true,
                        'unique' => true,
                        'tableField' => 'uti_email',
                        'type' => 'email'
                    ],
                    'inscription_motDePasse' => [
                        'required' => true,
                        'minLength' => 8,
                        'maxLength' => 72,
                        'tableField' => 'uti_motdepasse',
                        'type' => 'motDePasse'
                    ],
                    'inscription_motDePasse_confirmation' => [
                        'required' => true,
                        'minLength' => 8,
                        'maxLength' => 72,
                        'type' => 'confirm',
                        'argConfirm' => 'inscription_motDePasse'
                    ]
                ];
    }

    // Function to get values for insertion into the database
    private static function get_tableValues (array $userValues, array $tableFields)
    {
        //set an empty array
        $values = [];

        //Browse fields and set te values to insert into the table
        foreach ($tableFields as $field => $value)
        {
            //check if the field is not a confirm field
            if(!isset($value['type']) || $value['type'] != 'confirm')
            {
                //check if the field is a password field
                if (isset($value['type']) && $value['type'] === 'motDePasse')
                {
                    //hash the value if its à password
                    $values[$field] = password_hash($userValues[$field], PASSWORD_BCRYPT);
                }
                else
                {
                    //insert the value and the field into the new array
                    $values[$field] = $userValues[$field];
                }
            }
        }
        //return the new array with the field and the value
        return $values;
    }

    // Function to set the INSERT SQL request and values
    /*this only works to insert into a single table, this function is not necessary 
    but in this project it works because there will be no other user tables*/
    private static function set_insertrequest (array $tableFields, string $table = self::TABLE)
    {
        //set the number on values
        $number = 0;
        foreach ($tableFields as $key => $value)
        {
            if (isset($value['tableField']) && !empty($value['tableField']))
            {
                $number++;
            }
        }

        //set the variables to make the request
        $tableRequest = '';
        $valuesRequest = '';
        $values = [];
        $count = 0;

        //format the table request and the value to make the sql request
        foreach($tableFields as $field => $value)
        {
            $count++;
            //check if it's the last value to insert
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

        //format the sql request
        $request = "INSERT INTO " . $table . " (" . $tableRequest . ") VALUES (" . $valuesRequest . ")";

        //return the request and the values to insert
        return [$request, $values];
    }

    // Function to insert user values into the database
    public static function insert_values (array $userValues, array $fieldsConfig)
    {
        //connect to the database
        $pdo = ManageDb::connect_db();

        //generate the SQL request, get the values
        [$request, $values] = ModelUser::set_insertrequest($fieldsConfig);
        $user = ModelUser::get_tableValues ($userValues, $fieldsConfig);

        $stmt = $pdo->prepare($request);

        //bind the values
        foreach($values as $value => $field)
        {
            $valeur=$user[$value];

            $stmt->bindValue($field, $valeur);
        }

        $stmt->execute();

        return "inscription réussie";

    }

    // Function to send a validation mail
    private static function send_validateMail (array $account, string $code)
    {
        //recover the mail in the right field and set the parameters with the code
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

    //function to get the user by pseudo
    public static function get_userByPseudo (string $pseudo, string $tablepseudo, string $table = self::TABLE)
    {
        //connect to the db
        $pdo = ManageDb::connect_db();

        //set the request, prepare and execute
        $request = "SELECT * FROM $table WHERE $tablepseudo='$pseudo'";
        $stmt = $pdo->prepare($request);
        $stmt->execute();

        //get the user and return it
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($user[0]))
        {
            return $user[0];
        }
    }

    // Function to set an activation code and send validation mail
    public static function set_activationCode (string $id, string $table = self::TABLE)
    {
        //Make a random five-digit code 
        $code = strval(rand(10000, 99999));

        //get the user by his id
        $user = ManageDb::get_byId($id, 'uti_id', $table);
    
        //update the db with the code
        $pdo = ManageDb::connect_db();
        $requete = "UPDATE $table SET uti_code_activation = :code WHERE uti_id = :id";
        $stmt = $pdo->prepare($requete);

        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':id', $id);

        //if the request is done, send the mail with the activation code
        if ($stmt->execute())
        {
            ModelUser::send_validateMail($user, $code);
        }
    }

    //Validates the activation code and activates the user account if the code is correct.
    public static function set_validation(string $code, string $table = self::TABLE)
    {
        //Define the table fields
        $tablefield ='uti_id';
        $activeField ='uti_compte_active';

        //retrieve the user id 
        $id = $_SESSION['id'];

        //get te user from the database
        $user = ManageDb::get_byId($id, $tablefield, $table);

        //Check if the provided activation code matches the stored activation code
        if($code === $user['uti_code_activation'])
        {
            //connect to database
            $pdo = ManageDb::connect_db(); 
            
            //set the update request to activate account
            $requete = "UPDATE $table SET $activeField = 1 WHERE $tablefield = $id";
            $stmt = $pdo->prepare($requete);
            $stmt->execute();
            $_SESSION['activated'] = true;

            //return the succes message
            return 'Compte activé';
        }
        else
        {
            //return the failed message
            return "erreur d'activation";
        }
    }
}


?>