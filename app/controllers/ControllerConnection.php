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
    private static $pageInfos = [
        'view' => 'view_connection',
        'title' => "Page de connexion",
        'description' => "Page de connexion",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/'
    ];

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

    public static function try_connection ()
    {
        if (!ManageForm::is_validCSRFAndFrequency())
        {
            DisplayView::show_error404();
        }
        else
        {
            $nomTable = "t_utilisateur_uti";
            $result = ManageForm::is_validateform(ModelUser::get_fieldConnexionConfig(), $_POST, $nomTable);
            if(count($result['errors']) == 0)
            {
                $user = ModelUser::get_userByPseudo($_POST['connexion_pseudo'], ModelUser::get_fieldConnexionConfig()['connexion_pseudo']['tableField']);
                if (empty($user))
                {
                    $result['finalMessage'] = "Veuillez d'abord vous inscrire";
                    DisplayView::show_view(self::$pageInfos, 'index', $result);
                }
                else 
                {
                    if (ManageConnection::check_password($user[ModelUser::get_fieldConnexionConfig()['connexion_motDePasse']['tableField']], $_POST['connexion_motDePasse']))
                    {
                        $result['finalMessage'] = "";
                        ManageConnection::start_connection ($user);
                        if ($user['uti_compte_active'] == 1)
                        {
                            $_SESSION['activated'] = true;
                            header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'profil');
                        }
                        else
                        {
                            $_SESSION['activated'] = false;
                            ModelUser::set_activationCode($_SESSION['id']);
                            header('Location: ' . BASE_URL . '/' . 'connexion' . '/' . 'activation');
                            exit();
                        }
                    }
                    else 
                    {
                        $result['finalMessage'] = 'Mot de passe erroné';
                        DisplayView::show_view(self::$pageInfos, 'index', $result);
                    }
                }
            }
        }
    }
}

?>