<?php

session_start();

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_connection.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'modeles' . DIRECTORY_SEPARATOR . 'modele_user.php';

function get_pageInfos()
{
    return [
        'vue' => 'vue_connexion',
        'titre' => "Page de connexion",
        'description' => "Page de connexion",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'activation'
    ];
}

function index ()
{
    if (isset($_SESSION['id']) && $_SESSION['actived'] == 0)
    {
        show_vue(get_pageInfos(), 'activation');
    }
    else
    {
        header('Location: ' . BASE_URL . '/' . 'connexion' );      
    }
}

function activation ()
{
    if (!is_validCSRF()  || !is_validRequestFrequency())
    {
        show_error404();
    }
    else
    {
        $nomTable = "t_utilisateur_uti";
        [$errors, $values, $access, $finalMessage] = is_validateform(get_fieldActivationConfig(), $_POST, $nomTable);
        $result['errors'] = $errors;
        $result['values'] = $values;
        $result['access'] = $access;
        $result['finalMessage'] = $finalMessage;
        if(count($errors) === 0)
        {
            $result['finalMessage'] = set_validation($_POST['activation_code']);
            header('Location: ' . BASE_URL . '/' . 'connexion');
            exit();
        }
        else
        {
            show_vue(get_pageInfos(), 'activation', $result);
        }
    }
}

?>