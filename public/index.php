<?php

// Import the autoloader
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Autoloader.php';

// Start the autoloader.
Autoloader::init();

// Start the session
session_start();

// Import the router.
use Core\Router;

// Environment state: 'dev' in development mode or 'prod' in production mode.
// This allows using conditions to perform certain actions only if in a specific mode.
// For example, in the file /core/database_management.php, errors will only display in the browser if the ENV constant is set to "dev".
define('ENV', 'dev');

// Base path of the application (Useful if the application is hosted in a subfolder. In this case, remember to adjust the .htaccess file).
// For example, if your root URL is the following: localhost/myproject/,
// Then you should configure BASE_URL to '/myproject' and in the .htaccess file: RewriteCond %{REQUEST_URI} !^myproject/public/
define('BASE_URL', '');

// Routes:
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