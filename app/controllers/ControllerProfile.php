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
    // Define static page information for the profile page
    private static $pageInfos = [
        'view' => 'view_connection',
        'title' => "Page de profil",
        'description' => "Page de profil",
        'baseUrl' => BASE_URL . '/' . 'connexion' . '/' . 'profil'
    ];

    // Display the user's profile page if connected, otherwise redirect to login
    public static function index()
    {
        if (ManageConnection::is_connected() )
        {
            //If connected, get user data form the database by user id
            $user = ManageDb::get_byId($_SESSION['id'], 'uti_id', ModelUser::get_table());
            DisplayView::show_view(self::$pageInfos, 'profile', $user);
        }
        else
        {
            //redirect to login page if not connected
            header('Location: ' . BASE_URL . '/' . 'connexion' );      
        }
    }

    //Disconect the user and redirect to the login page 
    public static function disconect()
    {
        //check CSRF token and submission frequency
        if (!ManageForm::is_validCSRFAndFrequency())
        {
            //disconect user and show a 404 error
            ModelUser::unset_cookieToStayConnected($_SESSION['id']);
            ManageConnection::disconect_user();
            DisplayView::show_error404();
        }
        else
        {
            //disconect user and redirect to the login page
            ModelUser::unset_cookieToStayConnected($_SESSION['id']);
            ManageConnection::disconect_user();
            header('Location: ' . BASE_URL . '/' . 'connexion');
        }
    }
}

?>