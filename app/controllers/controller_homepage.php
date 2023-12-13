<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_view.php';

function get_pageInfos(){
    return [
    'view' => 'view_homepage',
    'title' => "Page d'Accueil",
    'description' => "Description de la page d'accueil...",
    //?????
    'baseUrl' => BASE_URL . '/'
];
}
function index(): void
{
    // Afficher la vue "vue_accueil.php".
    DisplayView::show_view(get_pageInfos(), 'index');
}

?>