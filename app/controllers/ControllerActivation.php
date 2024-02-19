<?php
namespace App\Controllers;

use Core\{
    DisplayView,
    ManageForm,
};

use App\Models\ModelUser;

class ControllerActivation 
{
    // Define static page information for the activation process
    private static $pageInfos = [
        'view' => 'view_connection',
        'title' => "Page de connexion",
        'description' => "Page de connexion",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'activation'
    ];

    //Display the activation page if the user is logged but not activated
    public static function index ()
    {
        if (isset($_SESSION['id']) && $_SESSION['activated'] == 0)
        {
            DisplayView::show_view(self::$pageInfos, 'activation');
        }
        else
        {
            //redirect if not logged or already activated
            header('Location: ' . BASE_URL . '/' . 'connexion' );      
        }
    }

    //Process the activation form submission
    public static function activation ()
    {
        //Check CSRF token and submission frequency
        if (!ManageForm::is_validCSRFAndFrequency()  )
        {
            //Show error 404 page
            DisplayView::show_error404();
        }
        else
        {
            //Check if the form is correct
            $result = ManageForm::is_validateform(ModelUser::get_fieldActivationConfig(), $_POST, ModelUser::get_table());

            //Proceed to activation if no error
            if(count($result['errors']) === 0)
            {
                //Try to activate
                $result['finalMessage'] = ModelUser::set_validation($_POST['activation_code']);

                //If the account is activated, redirect to the login page
                if ($result['finalMessage'] === 'Compte activé')
                {
                header('Location: ' . BASE_URL . '/' . 'connexion');
                exit();
                }
                else
                {
                    // If activation failed, display the activation page with the final message
                    DisplayView::show_view(self::$pageInfos, 'activation', $result);
                }
            }
            else
            {
                // If validation errors exist, display the activation page with the errors
                DisplayView::show_view(self::$pageInfos, 'activation', $result);
            }
        }
    }
}

?>