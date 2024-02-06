<?php use Core\ManageForm ?>
<h2>Connexion</h2>

<form method="post">
<input type="hidden" name="csrf_token" value="<?=ManageForm::set_CSRFToken()?>">

<label for="connexion_pseudo">Pseudo:</label><br>
<input type="text" id="connexion_pseudo" value="<?=htmlentities($args['values']['connexion_pseudo'] ?? "") ?>" <?=$args['access']['connextion_pseudo'] ?? ""?> name="connexion_pseudo"  required><br>
<div id="connexion_pseudo-error" class="error"><?=$args['errors']['connexion_pseudo'] ?? '' ?></div><br>

<label for="connexion_motDePasse">Mot de passe:</label><br>
<input type="text" id="connexion_motDePasse" name="connexion_motDePasse" maxlength="72" minlength="8" <?=$args['access']['connexion_motDePasse'] ?? ""?> required><br>
<div id="connexion_motDePasse-error" class="error"><?=$args['errors']['connexion_motDePasse'] ?? ''; ?></div><br>

<input type="submit" value="Se connecter">
<?= $args['finalMessage'] ?? ""?>
<form>

<div><a href='connexion/inscription' class="internal_link">inscription</a></div>