<h2>Contact</h2>

<form method="post">
<!--<input type="hidden" name="csrf_token" value="//generer_jetonCSRF()?>">-->

<label for="fname">First Name:</label><br>
<input type="text" id="fname" name="fname" value="<?=htmlentities($args['values']['fname'] ?? "")?>" <?=$args['access']['fname'] ?? ""?> required><br>
<div id="fname-error" class="error"><?=$args['errors']['fname'] ?? ''; ?></div><br>

<label for="lname">Last Name:</label><br>
<input type="text" id="lname" name="lname" value="<?=htmlentities($args['values']['lname'] ?? "")?>" <?=$args['access']['lname'] ?? ""?> maxlength="255" minlength="2"><br>
<div id="lname-error" class="error"><?=$args['errors']['lname'] ?? ''; ?></div><br>

<label for="mail">Email:</label><br>
<input type="text" id="email" name="email" value="<?=htmlentities($args['values']['email'] ?? "")?>" <?=$args['access']['email'] ?? ""?> required><br>
<div id="email-error" class="error"><?=$args['errors']['email'] ?? ''; ?></div><br>

<label for="message">Message:</label><br>
<textarea id="message" name="message" <?=$args['access']['message'] ?? ""?> maxlength="3000" minlength="10" required><?=htmlentities($args['values']['message'] ?? "")?></textarea><br>
<div id="message-error" class="error"><?=$args['errors']['message'] ?? ''; ?></div>

<input type="submit" value="Envoyer">
<?= $args['finalMessage'] ?? ""?>

</form>