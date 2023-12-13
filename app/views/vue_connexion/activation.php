<h2>Activation du compte</h2>
<form method="post">
<input type="hidden" value="activationCompte" id="formNom" name="formNom">
<input type="hidden" name="csrf_token" value="<?=set_CSRFToken()?>">
<input type="hidden" value="<?=$_SESSION['id'] ?? '' ?>" id="activation_utilisateurId" name="activation_utilisateurId">
    
<label for="activation_code">Entrez votre code d'activation<label><br>
<input type="text" id="activation_code" name="activation_code" <?=$args['access']['activation_code'] ?? ""?> maxlength="5" minlength="5" required ><br>
<div id="activation_code-error" class="error"><?=$args['errors']['activation_code'] ?? ''; ?></div><br>
    
<input type="submit" value="Valider">
<?= $args['finalMessage'] ?? ""?>
<form>