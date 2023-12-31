<?php
// Importer le routeur d'URL.

session_start();

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'router.php';

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

Router::config_route('GET', '/', 'controller_homepage', 'index');
Router::config_route('GET', '/contact', 'controller_contact', 'index');
Router::config_route('POST', '/contact', 'controller_contact', 'PostedForm');
Router::config_route('GET', '/connexion', 'controller_connection', 'index');
Router::config_route('GET', '/connexion/inscription', 'controller_registration', 'index');
Router::config_route('POST', 'connexion/inscription', 'controller_registration', 'send_registration');
Router::config_route('POST', 'connexion', 'controller_connection', 'try_connection');
Router::config_route('GET', 'connexion/activation', 'controller_activation', 'index');
Router::config_route('POST', 'connexion/activation', 'controller_activation', 'activation');
Router::config_route('GET', 'connexion/profil', 'controller_profile', 'index');
Router::config_route('POST', 'connexion/profil', 'controller_profile', 'disconect');


Router::start_router($patterns);