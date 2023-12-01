<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

function get_pageInfos()
{
    return [
        'vue' => 'vue_contact',
        'titre' => "Formulaire de contact",
        'description' => "Formulaire de contact",
        'baseUrl' => BASE_URL . '/' . 'contact' . '/'
    ];;
}

function index ()
{
    show_vue(get_pageInfos(), 'index');
};


?>