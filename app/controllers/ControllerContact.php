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
            $args = ManageForm::is_validateform(ModelContact::get_fieldConfig(), $_POST);
            if (count($args['errors']) === 0)
            {
                ManageForm::send_mail($_POST);
            }
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            {
                require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'view_contact' . DIRECTORY_SEPARATOR . 'contactForm.php';
            }
            else
            {
                DisplayView::show_view(self::$pageInfos, 'index', $args);
            }
        }
    }
}

?>