<?php
namespace App\Controllers;

use Core\DisplayView;

class ControllerHomepage
{
    //// Define static page information for the homepage
    private static $pageInfos = [
        'view' => 'view_homepage',
        'title' => "Page d'Accueil",
        'description' => "Description de la page d'accueil...",
        'baseUrl' => BASE_URL . '/'
    ];

    //display the homepage
    public static function index(): void
    {
        DisplayView::show_view(self::$pageInfos, 'index');
    }
}

?>