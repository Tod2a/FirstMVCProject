<?php
namespace App\Controllers;

use Core\{
    DisplayView,
    ManageForm,
    ManageConnection,
    ManageDb
};

use App\Models\ModelUser;


class ControllerProfile 
{
    private static $pageInfos = [
        'view' => 'view_connection',
        'title' => "Page de profil",
        'description' => "Page de profil",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'profil'
    ];

    public static function index()
    {
        if (ManageConnection::is_connected() )
        {
            $user = ManageDb::get_byId($_SESSION['id'], 'uti_id', ModelUser::get_table());
            DisplayView::show_view(self::$pageInfos, 'profile', $user);
        }
        else
        {
            header('Location: ' . BASE_URL . '/' . 'connexion' );      
        }
    }

    public static function disconect()
    {
        if (!ManageForm::is_validCSRFAndFrequency())
        {
            ManageConnection::disconect_user();
            DisplayView::show_error404();
        }
        else
        {
        ManageConnection::disconect_user();
        header('Location: ' . BASE_URL . '/' . 'connexion');
        }
    }
}

?>