<?php
namespace App\Controllers;

use Core\{
    DisplayView,
    ManageForm
};

use App\Models\ModelUser;


class ControllerRegistration
{
    // Define static page information for the registration page
    private static $pageInfos = [
        'view' => 'view_connection',
        'title' => "Page d'inscription",
        'description' => "Page d'inscription",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'inscription'
    ];

    // Display the registration page
    public static function index ()
    {
        DisplayView::show_view(self::$pageInfos, 'registration');
    }

    // Process the submitted registration form
    public static function send_registration ()
    {
        // Check CSRF token and form submission frequency
        if (!ManageForm::is_validCSRFAndFrequency())
        {
            // Show a 404 error if CSRF token or form frequency is not valid
            DisplayView::show_error404();
        }
        else
        {
            //check if the form is valid
            $result = ManageForm::is_validateform(ModelUser::get_fieldRegistrationConfig(), $_POST, ModelUser::get_table());

            //If no errors, insert the values into the database
            if(count($result['errors']) === 0)
            {
                $result['finalMessage'] = ModelUser::insert_values($_POST, ModelUser::get_fieldRegistrationConfig());
            }

            //display the registration page with the result
            DisplayView::show_view(self::$pageInfos, 'registration', $result);
        }
    }
    
}

?>