<?php
namespace App\Controllers;

use Core\DisplayView;

class ControllerGallery
{
    // Define static page information for the gallery page
    private static $pageInfos = [
        'view' => 'view_gallery',
        'title' => "Galerie d'images",
        'description' => "Galerie d'images",
        'baseUrl' => BASE_URL . '/' . 'galerie' . '/'
    ];

    //display the gallery page
    public static function index()
    {
        DisplayView::show_view(self::$pageInfos, 'index');
    }
}

?>