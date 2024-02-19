<?php
namespace Core;

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

}

?>