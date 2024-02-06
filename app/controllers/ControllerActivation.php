<?php
namespace App\Controllers;

use Core\{
    DisplayView,
    ManageForm,
};

use App\Models\ModelUser;

class ControllerActivation 
{
    private static $pageInfos = [
        'view' => 'view_connection',
        'title' => "Page de connexion",
        'description' => "Page de connexion",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'activation'
    ];

    public static function index ()
    {
        if (isset($_SESSION['id']) && $_SESSION['activated'] == 0)
        {
            DisplayView::show_view(self::$pageInfos, 'activation');
        }
        else
        {
            header('Location: ' . BASE_URL . '/' . 'connexion' );      
        }
    }

    public static function activation ()
    {
        if (!ManageForm::is_validCSRFAndFrequency()  )
        {
            DisplayView::show_error404();
        }
        else
        {
            $nomTable = "t_utilisateur_uti";
            $result = ManageForm::is_validateform(ModelUser::get_fieldActivationConfig(), $_POST, $nomTable);
            if(count($result['errors']) === 0)
            {
                $result['finalMessage'] = ModelUser::set_validation($_POST['activation_code']);
                if ($result['finalMessage'] === 'Compte activé')
                {
                header('Location: ' . BASE_URL . '/' . 'connexion');
                exit();
                }
                else
                {
                    DisplayView::show_view(self::$pageInfos, 'activation', $result);
                }
            }
            else
            {
                DisplayView::show_view(self::$pageInfos, 'activation', $result);
            }
        }
    }
}

?>