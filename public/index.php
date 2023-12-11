<?php
// Importer le routeur d'URL.

session_start();

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'routeur.php';

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
    obtenir_route('GET', '/contact', 'controleur_contact', 'index'),
    obtenir_route('POST', '/contact', 'controleur_contact', 'PostedForm'),
    obtenir_route('GET', '/connexion', 'controleur_connexion', 'index'),
    obtenir_route('GET', '/connexion/inscription', 'controleur_inscription', 'index'),
    obtenir_route('POST', 'connexion/inscription', 'controleur_inscription', 'send_inscription'),
    obtenir_route('POST', 'connexion', 'controleur_connexion', 'try_connection'),
    obtenir_route('GET', 'connexion/activation', 'controleur_activation', 'index'),
    obtenir_route('POST', 'connexion/activation', 'controleur_activation', 'activation'),
    obtenir_route('GET', 'connexion/profil', 'controleur_profil', 'index'),
    obtenir_route('POST', 'connexion/profil', 'controleur_profil', 'disconect')
];

demarrer_routeur($routes, $patterns);