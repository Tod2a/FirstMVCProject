<?php

require_once 'set_nav.php';

$html = set_nav("Accueil", "/") . set_nav("Contact", BASE_URL . '/contact') . set_nav("Connexion", "/connexion");

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