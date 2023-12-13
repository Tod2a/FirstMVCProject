<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_view.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'model_user.php';

function get_pageInfos()
{
    return [
        'view' => 'view_connection',
        'title' => "Page de connexion",
        'description' => "Page de connexion",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'activation'
    ];
}

function index ()
{
    if (isset($_SESSION['id']) && $_SESSION['activated'] == 0)
    {
        DisplayView::show_view(get_pageInfos(), 'activation');
    }
    else
    {
        header('Location: ' . BASE_URL . '/' . 'connexion' );      
    }
}

function activation ()
{
    if (!ManageForm::is_validCSRFAndFrequency()  )
    {
        DisplayView::show_error404();
    }
    else
    {
        $nomTable = "t_utilisateur_uti";
        $result = ManageForm::is_validateform(get_fieldActivationConfig(), $_POST, $nomTable);
        if(count($result['errors']) === 0)
        {
            $result['finalMessage'] = set_validation($_POST['activation_code']);
            if ($result['finalMessage'] === 'Compte activé')
            {
            header('Location: ' . BASE_URL . '/' . 'connexion');
            exit();
            }
            else
            {
                DisplayView::show_view(get_pageInfos(), 'activation', $result);
            }
        }
        else
        {
            DisplayView::show_view(get_pageInfos(), 'activation', $result);
        }
    }
}

?>