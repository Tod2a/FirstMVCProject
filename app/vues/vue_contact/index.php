<h2>Contact</h2>

<form method="post">
<input type="hidden" name="csrf_token" value="<?=generer_jetonCSRF()?>">

<label for="fname">First Name:</label><br>
<input type="text" id="fname" name="fname" value="<?=htmlentities($f_values['fname'] ?? "")?>" <?=$f_access['fname'] ?? ""?> required><br>
<div id="fname-error" class="error"><?=$f_errors['fname'] ?? ''; ?></div><br>

<label for="lname">Last Name:</label><br>
<input type="text" id="lname" name="lname" value="<?=htmlentities($f_values['lname'] ?? "")?>" <?=$f_access['lname'] ?? ""?> maxlength="255" minlength="2"><br>
<div id="lname-error" class="error"><?=$f_errors['lname'] ?? ''; ?></div><br>

<label for="mail">Email:</label><br>
<input type="text" id="email" name="email" value="<?=htmlentities($f_values['email'] ?? "")?>" <?=$f_access['email'] ?? ""?> required><br>
<div id="email-error" class="error"><?=$f_errors['email'] ?? ''; ?></div><br>

<label for="message">Message:</label><br>
<textarea id="message" name="message" <?=$f_access['message'] ?? ""?> maxlength="3000" minlength="10" required><?=htmlentities($f_values['message'] ?? "")?></textarea><br>
<div id="message-error" class="error"><?=$f_errors['message'] ?? ''; ?></div>

<input type="submit" value="Envoyer">
<?= $finalMessage ?? ""?>

</form>