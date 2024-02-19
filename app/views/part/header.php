<?php
use App\Views\Part\SetNav;

$nav = SetNav::set_navi();

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
                <?=$nav?>
            </ul>
        </nav>
    </header>
    <main>
