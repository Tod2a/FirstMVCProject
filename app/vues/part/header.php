<?php

require_once 'functions/set_nav.php';

$html = set_nav("Accueil", "/index.php") . set_nav("Contact", "/contact.php") . set_nav("Connexion", "/connection.php");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/assets/CSS/styles.css">
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