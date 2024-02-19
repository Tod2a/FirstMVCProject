<?php
use App\Views\Part\SetNav;

use Core\ManageConnection;

//check if a account is connected
if (ManageConnection::is_connected())
{
    //set the nav with the profile page
    $html = SetNav::set_navToken("Accueil", "/") . SetNav::set_navToken("Contact", BASE_URL . '/contact') . SetNav::set_navToken("Profil", "/connexion/profil") . SetNav::set_navToken("Galerie", "/galerie");
}
else
{
    //set the nav with the connection page
    $html = SetNav::set_navToken("Accueil", "/") . SetNav::set_navToken("Contact", BASE_URL . '/contact') . SetNav::set_navToken("Connexion", "/connexion") . SetNav::set_navToken("Galerie", "/galerie");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/public/assets/css/styles.css">
    <title><?=$title?></title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <?=$html?>
            </ul>
        </nav>
    </header>
    <main>
