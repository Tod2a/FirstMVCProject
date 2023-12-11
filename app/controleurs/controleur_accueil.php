<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'display_vue.php';

function get_pageInfos(){
    return [
    'vue' => 'vue_accueil',
    'titre' => "Page d'Accueil",
    'description' => "Description de la page d'accueil...",
    //?????
    'baseUrl' => BASE_URL . '/'
];
}
function index(): void
{
    // Afficher la vue "vue_accueil.php".
    show_vue(get_pageInfos(), 'index');
}

?>