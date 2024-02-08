<?php

//importer l'autoloader
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Autoloader.php';

// start autoloader.
Autoloader::init();

//start de session
session_start();

// Importer le routeur.
use Core\Router;

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

Router::config_route('GET', '/', 'ControllerHomepage', 'index');
Router::config_route('GET', '/contact', 'ControllerContact', 'index');
Router::config_route('POST', '/contact', 'ControllerContact', 'postedForm');
Router::config_route('GET', '/connexion', 'ControllerConnection', 'index');
Router::config_route('GET', '/connexion/inscription', 'ControllerRegistration', 'index');
Router::config_route('POST', 'connexion/inscription', 'ControllerRegistration', 'send_registration');
Router::config_route('POST', 'connexion', 'ControllerConnection', 'try_connection');
Router::config_route('GET', 'connexion/activation', 'ControllerActivation', 'index');
Router::config_route('POST', 'connexion/activation', 'ControllerActivation', 'activation');
Router::config_route('GET', 'connexion/profil', 'ControllerProfile', 'index');
Router::config_route('POST', 'connexion/profil', 'ControllerProfile', 'disconect');
Router::config_route('GET', '/galerie', 'ControllerGallery', 'index');


Router::start_router($patterns);