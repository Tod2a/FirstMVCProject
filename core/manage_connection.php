<?php

function check_password (string $user, string $post)
{
    return password_verify($post, $user);
}

function start_connection (array $user)
{
    $_SESSION['id'] = $user['uti_id'];
}

function disconect_user ()
{
    unset($_SESSION['id']);
    unset($_SESSION['activated']);
}

function is_connected(): bool
{
    return isset($_SESSION['id']) && $_SESSION['activated'];
}

?>