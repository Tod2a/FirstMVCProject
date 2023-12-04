<h2>Inscription</h2>

<form method="post">
<!--<input type="hidden" name="csrf_token" value="<generer_jetonCSRF()?>">-->

<label for="inscription_pseudo">Pseudo:</label><br>
<input type="text" id="inscription_pseudo" name="inscription_pseudo" maxlength="255" minlength="2" value="<?=htmlentities($f_values['inscription_pseudo'] ?? "")?>" <?=$f_access['inscription_pseudo'] ?? ""?> required><br>
<div id="inscription_pseudo-error" class="error"><?=$f_errors['inscription_pseudo'] ?? ''; ?></div><br>

<label for="inscription_email">Email:</label><br>
<input type="text" id="inscription_email" name="inscription_email" value="<?=htmlentities($f_values['inscription_email'] ?? "")?>" <?=$f_access['inscription_email'] ?? ""?> required><br>
<div id="inscription_email-error" class="error"><?=$f_errors['inscription_email'] ?? ''; ?></div><br>

<label for="inscription_motDePasse">Mot de passe:</label><br>
<input type="text" id="inscription_motDePasse" name="inscription_motDePasse" maxlength="72" minlength="8" value="<?=htmlentities($f_values['inscription_motDePasse'] ?? "")?>" <?=$f_access['inscription_motDePasse'] ?? ""?> required><br>
<div id="inscription_motDePasse-error" class="error"><?=$f_errors['inscription_motDePasse'] ?? ''; ?></div><br>

<label for="inscription_motDePasse_confirmation">Confirmation mot de passe:</label><br>
<input type="text" id="inscription_motDePasse_confirmation" name="inscription_motDePasse_confirmation" maxlength="72" minlength="8" value="<?=htmlentities($f_values['inscription_motDePasse_confirmation'] ?? "")?>" <?=$f_access['inscription_motDePasse_confirmation'] ?? ""?> required><br>
<div id="inscription_motDePasse_confirmation-error" class="error"><?=$f_errors['inscription_motDePasse_confirmation'] ?? ''; ?></div><br>

<input type="submit" value="Envoyer">
<?= $finalMessage ?? ""?>

</form>