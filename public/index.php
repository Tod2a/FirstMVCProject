<?php
// Importer le routeur d'URL.
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'noyau' . DIRECTORY_SEPARATOR . 'routeur.php';

// Etat de l'environnement : 'dev' en mode développement ou 'prod' en mode production.
// Ceci me permet d'utiliser des conditions pour réaliser certaines actions seulement si je suis dans un mode spécifique.
// Par exemple, dans le fichier /noyau/gestion_bdd.php, les erreurs ne s'afficheront dans le navigateur que si la constante ENV est configurée sur "dev".
define('ENV', 'dev');

// Chemin de base de l'application (Utile si l'application est hebergée dans un sous-dossier. Dans ce cas, n'oubliez pas d'adapter le fichier .htaccess).
// Par exemple si votre url racine est le suviant : localhost/monprojet/,
// Alors vous devrez configurer BASE_URL à '/monprojet' et dans le fichier .htacces : RewriteCond %{REQUEST_URI} !^monprojet/public/
define('BASE_URL', '');

// Routes :
$patterns = ['id' => '\d+'];
$routes = [
    obtenir_route('GET', '/', 'controleur_accueil', 'index'),
    obtenir_route('GET', '/admin-gestion-utilisateur', 'controleur_admin_gestion_utilisateur', 'index'),
    obtenir_route('DELETE', '/admin-gestion-utilisateur', 'controleur_admin_gestion_utilisateur', 'detruire'),
    obtenir_route('GET', '/admin-gestion-utilisateur/creer', 'controleur_admin_gestion_utilisateur', 'creer'),
    obtenir_route('POST', '/admin-gestion-utilisateur/creer', 'controleur_admin_gestion_utilisateur', 'stocker'),
    obtenir_route('GET', '/admin-gestion-utilisateur/{id}', 'controleur_admin_gestion_utilisateur', 'montrer'),
    obtenir_route('GET', '/admin-gestion-utilisateur/{id}/editer', 'controleur_admin_gestion_utilisateur', 'editer'),
    obtenir_route('PUT', '/admin-gestion-utilisateur/{id}/editer', 'controleur_admin_gestion_utilisateur', 'actualiser')
];

demarrer_routeur($routes, $patterns);