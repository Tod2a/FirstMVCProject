<?php

session_start();

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_db.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'modeles' . DIRECTORY_SEPARATOR . 'modele_inscription.php';

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

function send_inscription ()
{
    $nomTable = "t_utilisateur_uti";
    [$errors, $values, $access, $finalMessage] = is_validateform(get_fieldConfig(), $_POST, $nomTable);
    $result['errors'] = $errors;
    $result['values'] = $values;
    $result['access'] = $access;
    $result['finalMessage'] = $finalMessage;
    if(count($errors) === 0)
    {
        $result['finalMessage'] = insert_values($_POST, get_fieldConfig(), $nomTable);
    }
    show_vue(get_pageInfos(), 'index', $result);
}

?>