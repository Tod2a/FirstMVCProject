<?php
use App\Views\Part\SetNav;

use Core\ManageConnection;

if (ManageConnection::is_connected())
{
    $html = SetNav::set_navToken("Accueil", "/") . SetNav::set_navToken("Contact", BASE_URL . '/contact') . SetNav::set_navToken("Profil", "/connexion/profil");
}
else
{
    $html = SetNav::set_navToken("Accueil", "/") . SetNav::set_navToken("Contact", BASE_URL . '/contact') . SetNav::set_navToken("Connexion", "/connexion");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/public/ressources/css/styles.css">
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

    <!-- <pre> <?php print_r($_SERVER); ?> </pre> -->