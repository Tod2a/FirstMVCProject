<?php

session_start();

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_connection.php';

function get_pageInfos()
{
    return [
        'vue' => 'vue_connexion',
        'titre' => "Page de prifl",
        'description' => "Page de profil",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'profil'
    ];
}

function index()
{
    if (is_connected() )
    {
        show_vue(get_pageInfos(), 'profil');
    }
    else
    {
        header('Location: ' . BASE_URL . '/' . 'connexion' );      
    }
}

function disconect()
{
    if (!is_validCSRF())
    {
        header('Location: ' . BASE_URL . '/' . 'error' ); 
    }
    else
    {
    disconect_user();
    header('Location: ' . BASE_URL . '/' . 'connexion');
    }
}
?>