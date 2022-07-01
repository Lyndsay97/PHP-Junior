<?php

use blog\controller\Users;

$connexion = new Users();
$connexion->connexion();
?>
<!-- ---------------------------------   CONNEXION  HTML    ------------------------------- -->

<div class="divco">
    <div class="divco-container">
        <h2 class="h2-co">Connexion</h2>
        <form action='' class="formco" method="POST">
            <div class="divco1 ">
                <label class="labelin1">pseudo</label>
                <input type="text" name="pseudo" class="inputco1" id="inputpseudo">
            </div>

            <div class="divco2">
                <label class="labelin3">mot de passe</label>
                <input type="password" name="mdp" class="inputco2">
            </div>
            <button type="submit" class="btnco" name="subCo">envoyer</button>

            <div class="divico3">
                <a href="index.php?inscription"> Inscription</a>
            </div>
        </form>
    </div>
</div>