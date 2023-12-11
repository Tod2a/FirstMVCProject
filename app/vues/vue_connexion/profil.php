<h2>Votre profil</h2>

<p class="profil">
Votre pseudo: <?=$_SESSION['pseudo'] ?? '' ?><br>
Votre email: <?=$_SESSION['email'] ?? '' ?><br>
</p>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?=set_CSRFToken()?>">
    <input type="submit" value="déconnexion">
</form>