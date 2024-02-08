<?php
namespace App\Controllers;

use Core\{
    DisplayView,
    ManageForm
};

use App\Models\ModelContact;


class ControllerContact
{
    private static $pageInfos = [
        'view' => 'view_contact',
        'title' => "Formulaire de contact",
        'description' => "Formulaire de contact",
        'baseUrl' => BASE_URL . '/' . 'contact' . '/'
    ];

    public static function index ()
    {
        DisplayView::show_view(self::$pageInfos, 'index');
    }

    public static function postedForm ()
    {
        if (!ManageForm::is_validCSRFAndFrequency())
        {
            DisplayView::show_error404();
        }
        else
        {
        $result = ManageForm::is_validateform(ModelContact::get_fieldConfig(), $_POST);
        if (count($result['errors']) === 0)
        {
            ManageForm::send_mail($_POST);
        }
        DisplayView::show_view(self::$pageInfos, 'index', $result);
        }
    }
}

?>