<?php

class ManageConnection
{

    public static function check_password (string $user, string $post)
    {
        return password_verify($post, $user);
    }

    public static function start_connection (array $user)
    {
        $_SESSION['id'] = $user['uti_id'];
    }

    public static function disconect_user ()
    {
        unset($_SESSION['id']);
        unset($_SESSION['activated']);
    }

    public static function is_connected(): bool
    {
        return isset($_SESSION['id']) && $_SESSION['activated'];
    }

}

?>