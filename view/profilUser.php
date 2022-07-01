<?php

use blog\controller\Users;

$profilUser = new Users();
$p = $profilUser->getProfil();
$profilUser->modifProfil();
$profilUser->deleteUsersId();
?>


<div class="pp-profil">
    <!------------------------------------------------  FIND PROFIL ---------------------------------- -->
    <h2 class="h2-profil">Votre profil</h2>
    <h6 class="h6-profil">
        <a class="" href="index.php?mesArticles&id_utilisateurs=<?= $_SESSION['id'] ?>" name="mesarticle"> Mes
            Articles
        </a>
    </h6>
    <div class="profil-user">
        <div class="divProfilGet">
            <?php if (isset($_SESSION['role'])) {
                // afficher une icone selon le role de l'utilisateur (admin ou utilisateur)
                if ($p->id_Roles == 1) { ?>
                    <h6><i class="fa-solid fa-user"></i> Utilisateurs </h6>
                <?php } elseif ($p->id_Roles == 2) { ?>
                    <h6><i class="fa-solid fa-crown"></i> Admin </h6>
            <?php }
            } ?>
            <div class="divProfil-img">
                <?php if (isset($p->avatar)) { ?>
                    <img class="card-img-top" src="assets/avatars/<?= $p->avatar ?>">
                <?php } else {  // afficher un avatar si il n'ya pas une photo sinon afficher l'avatar envoyer par l'utilisateur 
                ?>
                    <img class="card-img-top" src="assets/avatars/NullAvatar.jpg">
                <?php } ?>
            </div>
            <div class="p-profil">
                <p> Votre identifiant : <?= $p->id ?></p>
                <p>Votre pseudo: <?= $p->pseudo ?></p>
                <p>Votre mail: <?= $p->email ?></p>
                <!------------------------------------------------ DELETE PROFIL ---------------------------------- -->
                <form method="POST">
                    <button type="submit" name="submitDelet" class="btnprofil-sup" value="<?= $p->id ?>">supprimer mon compte</button>
                </form>
            </div>
        </div>
        <!------------------------------------------------  UPDATE PROFIL ---------------------------------- -->
        <div class="profil-modif">
            <h4>Modifier profil</h4>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="up_avatar"> Avatar: </label>
                <input type="file" name="avatar" accept="image/png, image/jpeg, image/jpg, image/gif" value="<?= $p->avatar ?>">
                <label for="up_pseudo"> Pseudo: </label>
                <input class="input-modif-1" type="text" name="up_pseudo" value="<?= $p->pseudo; ?>">
                <label for="up_mail">Mail</label>
                <input class="input-modif-2" type="text" name="up_mail" value="<?= $p->email; ?>">
                <button type="submit" class="btn-modf-profil" name="updateEdit" value="<?= $p->id; ?>">
                    Modifier
                </button>
            </form>
        </div>
    </div>
</div>