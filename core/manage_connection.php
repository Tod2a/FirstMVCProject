<?php

function check_password (string $user, string $post)
{
    return password_verify($post, $user);
}

function start_connection (array $user)
{
    $_SESSION['id'] = $user['uti_id'];
    $_SESSION['actived'] = $user['uti_compte_active'];
}

function disconect_user ()
{
    unset($_SESSION['id']);;
}

?>