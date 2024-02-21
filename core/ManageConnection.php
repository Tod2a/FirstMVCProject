<?php
namespace Core;

use \PDO;

use Core\ManageDb;

class ManageConnection
{
    //check if the password send mathc with the password hash in the database
    public static function check_password (string $user, string $post)
    {
        return password_verify($post, $user);
    }

    //start a user session
    public static function start_connection (array $user): void
    {
        $_SESSION['id'] = $user['uti_id'];
    }

    //disconect user
    public static function disconect_user (): void
    {
        unset($_SESSION['id']);
        unset($_SESSION['activated']);
    }

    //Check if a user is currently connected by verifying session variables.
    public static function is_connected(): bool
    {
        return isset($_SESSION['id']) && $_SESSION['activated'];
    }

    //functien to check if the token is not already set to another user in the database
    private static function is_uniqueToken(string $testToken, string $table, string $field): bool
    {
        //connect to the database
        $pdo = ManageDb::connect_db();

        //select all the tokens
        $request = "SELECT $field FROM $table";
        $stmt = $pdo->prepare($request);
        $stmt->execute();
        $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        //check if the token is already set and return false if he's not unique
        foreach($tokens as $token)
        {
            if ($token === $testToken)
            {
                return false;
            }
        }

        //return true if he's unique
        return true;
    }

    //function to set a token used to stay connected to the profile
    public static function set_tokenToStayConnected(string $pseudo, string $table, string $field)
    {        
        //create a token of 60 characters based to the pseudo and the current datetime
        do
        {
            $token = password_hash($pseudo . date('Ym-d H:i:s'), PASSWORD_BCRYPT);
        } while (!ManageConnection::is_uniqueToken($token, $table, $field));
        
        return $token;
    }

    //function to check if a cookie is set to stay connected and return the id of the user
    public static function check_connectionTokenIsSet(string $table)
    {
        if (isset($_COOKIE['tokenconnection']) && !self::is_connected()) {
            $token = $_COOKIE['tokenconnection'];

            $pdo = ManageDb::connect_db();
            $request = "SELECT * FROM $table";
            $stmt = $pdo->prepare($request);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                if ($user['uti_token'] == $token) {
                    return $user['uti_id'];
                }
            }
        }
        return 0;
    }
}

?>