<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_view.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_connection.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_db.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'modele_user.php';

function get_pageInfos()
{
    return [
        'vue' => 'vue_connexion',
        'titre' => "Page de profil",
        'description' => "Page de profil",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'profil'
    ];
}

function index()
{
    if (is_connected() )
    {
        $user = get_byId($_SESSION['id'], 'uti_id', TABLE);
        show_view(get_pageInfos(), 'profil', $user);
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
        show_error404();
    }
    else
    {
    disconect_user();
    header('Location: ' . BASE_URL . '/' . 'connexion');
    }
}
?>