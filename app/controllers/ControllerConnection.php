<?php
namespace App\Controllers;

use Core\{
    DisplayView,
    ManageForm,
    ManageConnection
};

use App\Models\ModelUser;


class ControllerConnection
{
    // Define static page information for the connection process
    private static $pageInfos = [
        'view' => 'view_connection',
        'title' => "Page de connexion",
        'description' => "Page de connexion",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/'
    ];

    // Display the connection page or redirect to the profile page if already connected
    public static function index ()
    {
        if (ManageConnection::is_connected())
        {
            header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'profil');    
        }
        else
        {
            DisplayView::show_view(self::$pageInfos, 'index');
        }
    }

    // Process the connection form submission
    public static function try_connection ()
    {
        // Check CSRF token and form submission frequency
        if (!ManageForm::is_validCSRFAndFrequency())
        {
            // Show a 404 error if CSRF token or form frequency is not valid
            DisplayView::show_error404();
        }
        else
        {
            //check if the form is correct
            $result = ManageForm::is_validateform(ModelUser::get_fieldConnexionConfig(), $_POST, ModelUser::get_table());

            //if no errors proceed with connection attempt
            if(count($result['errors']) == 0)
            {
                //get user by his pseudo
                $user = ModelUser::get_userByPseudo($_POST['connexion_pseudo'], ModelUser::get_fieldConnexionConfig()['connexion_pseudo']['tableField']);
                
                //if user doesn't exist, show the connection page with errors
                if (empty($user))
                {
                    $result['finalMessage'] = "Veuillez d'abord vous inscrire";
                    DisplayView::show_view(self::$pageInfos, 'index', $result);
                }
                else 
                {
                    //check if password is correct
                    if (ManageConnection::check_password($user[ModelUser::get_fieldConnexionConfig()['connexion_motDePasse']['tableField']], $_POST['connexion_motDePasse']))
                    {
                        //Start the connection 
                        $result['finalMessage'] = "";
                        ManageConnection::start_connection ($user);

                        //check if the account is activated
                        if ($user['uti_compte_active'] == 1)
                        {
                            //redirect to profile if activated
                            $_SESSION['activated'] = true;
                            header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'profil');
                        }
                        else
                        {
                            //if not activated, set activation code and redirect to activation page
                            $_SESSION['activated'] = false;
                            ModelUser::set_activationCode($_SESSION['id']);
                            header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'activation');
                            exit();
                        }
                    }
                    else 
                    {
                        //if incorrect password, show the connection page with message
                        $result['finalMessage'] = 'Mot de passe erroné';
                        DisplayView::show_view(self::$pageInfos, 'index', $result);
                    }
                }
            }
            else
            {
                // If validation errors exist, display the connection page with the errors
                DisplayView::show_view(self::$pageInfos, 'index', $result);
            }
        }
    }
}

?>