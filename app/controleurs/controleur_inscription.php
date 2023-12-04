<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

function get_pageInfos()
{
    return [
        'vue' => 'vue_inscription',
        'titre' => "Page d'inscription",
        'description' => "Page d'inscription",
        'baseUrl' => BASE_URL . '/' . 'inscription' . '/'
    ];
}

function index ()
{
    show_vue(get_pageInfos(), 'index');
}

?>