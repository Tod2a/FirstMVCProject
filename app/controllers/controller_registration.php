<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_view.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'modele_user.php';

function get_pageInfos()
{
    return [
        'view' => 'vue_connexion',
        'title' => "Page d'inscription",
        'description' => "Page d'inscription",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'inscription'
    ];
}

function index ()
{
    show_view(get_pageInfos(), 'inscription');
}

function send_registration ()
{
    if (!is_validCSRF() || !is_validRequestFrequency())
    {
        show_error404();
    }
    else
    {
    $result = is_validateform(get_fieldInscriptionConfig(), $_POST, TABLE);
    if(count($result['errors']) === 0)
    {
        $result['finalMessage'] = insert_values($_POST, get_fieldInscriptionConfig(), $nomTable);
    }
    show_view(get_pageInfos(), 'inscription', $result);
    }
}

?>