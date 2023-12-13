<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_view.php';

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'manage_form.php';

require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'model_contact.php';

function get_pageInfos()
{
    return [
        'view' => 'view_contact',
        'title' => "Formulaire de contact",
        'description' => "Formulaire de contact",
        'baseUrl' => BASE_URL . '/' . 'contact' . '/'
    ];
}

function index ()
{
    DisplayView::show_view(get_pageInfos(), 'index');
}

function PostedForm ()
{
    if (!ManageForm::is_validCSRFAndFrequency())
    {
        DisplayView::show_error404();
    }
    else
    {
    $result = ManageForm::is_validateform(get_fieldConfig(), $_POST);
    if (count($result['errors']) === 0)
    {
        ManageForm::send_mail($_POST);
    }
    DisplayView::show_view(get_pageInfos(), 'index', $result);
    }
}


?>