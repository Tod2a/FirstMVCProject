<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'modeles' . DIRECTORY_SEPARATOR . 'modele_contact.php';

function get_pageInfos()
{
    return [
        'vue' => 'vue_contact',
        'titre' => "Formulaire de contact",
        'description' => "Formulaire de contact",
        'baseUrl' => BASE_URL . '/' . 'contact' . '/'
    ];
}

function index ()
{
    show_vue(get_pageInfos(), 'index');
}

function PostedForm ()
{
    if (!is_validCSRF()  || !is_validRequestFrequency())
    {
        show_error404();
    }
    else
    {
    $result = is_validateform(get_fieldConfig(), $_POST);
    if (count($result['errors']) === 0)
    {
        send_mail($_POST);
    }
    show_vue(get_pageInfos(), 'index', $result);
    }
}


?>