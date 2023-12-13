<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_view.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_connection.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_db.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'model_user.php';

function get_pageInfos()
{
    return [
        'view' => 'view_connection',
        'title' => "Page de profil",
        'description' => "Page de profil",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'profil'
    ];
}

function index()
{
    if (ManageConnection::is_connected() )
    {
        $user = ManageDb::get_byId($_SESSION['id'], 'uti_id', ModelUser::get_table());
        DisplayView::show_view(get_pageInfos(), 'profile', $user);
    }
    else
    {
        header('Location: ' . BASE_URL . '/' . 'connexion' );      
    }
}

function disconect()
{
    if (!ManageForm::is_validCSRFAndFrequency())
    {
        ManageConnection::disconect_user();
        DisplayView::show_error404();
    }
    else
    {
    ManageConnection::disconect_user();
    header('Location: ' . BASE_URL . '/' . 'connexion');
    }
}
?>