<?php use Core\ManageForm ?>
<h2>Votre profil</h2>
<p class="profil">
Votre pseudo: <?=$args['uti_pseudo'] ?? '' ?><br>
Votre email: <?=$args['uti_email'] ?? '' ?><br>
</p>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?=ManageForm::set_CSRFToken()?>">
    <input type="submit" value="déconnexion">
</form>