<?php

//fonction qui va "monter" la page avec l'entete et le fichier souhaiter
function show_vue (array $pageInfos, string $action, ?array $args = null)
{
    $roadOfVues = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'vues' . DIRECTORY_SEPARATOR;

    $roadOfVuesPart = $roadOfVues . DIRECTORY_SEPARATOR . 'part' . DIRECTORY_SEPARATOR;

    $title = $pageInfos['titre'];
    
    require_once $roadOfVuesPart . 'header.php';
    
    require_once $roadOfVues . $pageInfos['vue'] . DIRECTORY_SEPARATOR . $action . '.php';
    
    require_once $roadOfVuesPart . 'footer.php';

}
//fonction qui affiche la page erreur404
function show_error404()
{
    // Indiquer au navigateur qu'il s'agit d'une erreur 404.
    header("HTTP/1.0 404 Not Found");
    // Charger la vue pour la page d'erreur 404.
    afficher_vue(['vue' => 'vue_erreur404'], 'index');
    exit();
}

?>