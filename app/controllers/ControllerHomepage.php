<?php
namespace App\Controllers;

use Core\DisplayView;

class ControllerHomepage
{
    private static $pageInfos = [
        'view' => 'view_homepage',
        'title' => "Page d'Accueil",
        'description' => "Description de la page d'accueil...",
        'baseUrl' => BASE_URL . '/'
    ];

    public static function index(): void
    {
        // Afficher la vue "vue_accueil.php".
        DisplayView::show_view(self::$pageInfos, 'index');
    }
}

?>