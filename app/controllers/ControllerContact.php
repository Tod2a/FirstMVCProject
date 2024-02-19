<?php
namespace App\Controllers;

use Core\{
    DisplayView,
    ManageForm
};

use App\Models\ModelContact;


class ControllerContact
{
    // Define static page information for the contact form
    private static $pageInfos = [
        'view' => 'view_contact',
        'title' => "Formulaire de contact",
        'description' => "Formulaire de contact",
        'baseUrl' => BASE_URL . '/' . 'contact' . '/'
    ];

    //Display the contact form page
    public static function index ()
    {
        DisplayView::show_view(self::$pageInfos, 'index');
    }

    // Process the submitted contact form
    public static function postedForm ()
    {
        //check the CSRF token and the submission frequency
        if (!ManageForm::is_validCSRFAndFrequency())
        {
            //show a 404 error if it's not valid 
            DisplayView::show_error404();
        }
        else
        {
            //Check if the form is valid
            $args = ManageForm::is_validateform(ModelContact::get_fieldConfig(), $_POST);

            //if no errors, send the mail
            if (count($args['errors']) === 0)
            {
                ManageForm::send_mail($_POST);
            }

            //check if the request is a javascript request
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            {
                //if it's an javascript request, include the contact form without reload the entire page
                require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'view_contact' . DIRECTORY_SEPARATOR . 'contactForm.php';
            }
            else
            {
                //if not, just show the contact page with the errors
                DisplayView::show_view(self::$pageInfos, 'index', $args);
            }
        }
    }
}

?>