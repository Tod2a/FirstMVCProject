<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_view.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'model_user.php';

function get_pageInfos()
{
    return [
        'view' => 'view_connection',
        'title' => "Page d'inscription",
        'description' => "Page d'inscription",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'inscription'
    ];
}

function index ()
{
    DisplayView::show_view(get_pageInfos(), 'registration');
}

function send_registration ()
{
    if (!ManageForm::is_validCSRFAndFrequency())
    {
        DisplayView::show_error404();
    }
    else
    {
    $result = ManageForm::is_validateform(ModelUser::get_fieldInscriptionConfig(), $_POST, ModelUser::get_table());
    if(count($result['errors']) === 0)
    {
        $result['finalMessage'] = ModelUser::insert_values($_POST, ModelUser::get_fieldInscriptionConfig());
    }
    DisplayView::show_view(get_pageInfos(), 'registration', $result);
    }
}

?>