<?php
namespace App\Controllers;

use Core\{
    DisplayView,
    ManageForm
};

use App\Models\ModelUser;


class ControllerRegistration
{
    private static $pageInfos = [
        'view' => 'view_connection',
        'title' => "Page d'inscription",
        'description' => "Page d'inscription",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'inscription'
    ];

    public static function index ()
    {
        DisplayView::show_view(self::$pageInfos, 'registration');
    }

    public static function send_registration ()
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
        DisplayView::show_view(self::$pageInfos, 'registration', $result);
        }
    }
    
}

?>