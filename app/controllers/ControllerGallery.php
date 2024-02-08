<?php
namespace App\Controllers;

use Core\DisplayView;

class ControllerGallery
{
    private static $pageInfos = [
        'view' => 'view_gallery',
        'title' => "Galerie d'images",
        'description' => "Galerie d'images",
        'baseUrl' => BASE_URL . '/' . 'galerie' . '/'
    ];

    public static function index()
    {
        DisplayView::show_view(self::$pageInfos, 'index');
    }
}

?>