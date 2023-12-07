<?php

session_start();

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

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
    show_vue(get_pageInfos(), 'profil');
}

function disconect()
{
    disconect_user();
    header('Location: ' . BASE_URL . '/' . 'connexion');
}
?>