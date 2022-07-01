<?php

use blog\controller\Articles;
use blog\controller\Comments;
// CONTROLLER ARTICLES
$p = new Articles;
$art = $p->findArticleIdPseudo();
// CONTROLLER COMMENTS
$comment = new Comments();
$yu = $comment->findComments();
$comment->postComment();
$comment->delComment();
?>

<div class="div-artid">
    <!-----------------------------------------  AFFICHER L'ARTICLE -------------------------------------->
    <div class="article-look">
        <h3><b><?= mb_strtoupper($art->pseudo) ?> </b></h3><br>
        <h5><b><?= ucfirst($art->titre) ?> </b></h5><br>
        <div class="article-look-img">
            <img class="card-img-top" src="assets/articles/<?= $art->img ?>" alt="">
        </div>
        <hr>
        <p><?= $art->msg ?> </p><br><br>
        <p><?= $art->dateArticles ?> </p>
    </div>
    <!-------------------------------- AFFICHER LES COMMENTAIRE LIEE A L'ARTICLE -------------------------->
    <div class="article-com">
        <?php if (empty($yu)) { ?>
            <h4>Aucun commentaire disponible!</h4>
            <?php } elseif (!empty($yu)) {
            foreach ($yu as $com) {  ?>
                <h5><b><?= ucfirst($com->pseudo); ?></b></h5>
                <p><?= $com->commentaire; ?></p>
                <?php if (isset($_SESSION['id'])) {
                    if (($_SESSION['pseudo'] === $com->pseudo) || ($_SESSION['role'] === 'admin')) { ?>
                        <form action="" method="post">
                            <button class="btn-supcom" id="idDel" type="submit" name="supcom" value="<?= $com->id_com ?>">supprimer</button>
                        </form>
                <?php }
                } ?>
                <hr style="width: 220px; margin: auto;">
                <br>
        <?php }
        } ?>
    </div>

    <br>
    <?php
    if (isset($formSucces['succes'])) {
        echo  $formSucces['succes'];
    }
    ?>
    <!---------------------------------------- COMMENTEZ !! --------------------------------------------->
    <div class=" article-pst-com">
        <form action="" method="POST">
            <div class="form-group">
                <?php if (isset($_SESSION['pseudo'])) { ?>
                    <h6 class=" text-center">Entrez votre commentaire <?= $_SESSION['pseudo'] ?> :</h6><br>
                <?php } else { ?>
                    <h6 class=" text-center">Connectez vous pour commenter!</h6><br>
                <?php } ?>
                <?php
                $articlecom = intval($art->id);
                ?>
                <input class="" type="hidden" name="up_id" value="<?= $articlecom ?>">
                <textarea class="text-commentaire" id="exampleFormControlTextarea1" name="up_com"></textarea>
                <a href="index.php?modifArticle&idArticle=<?= $art->id ?>"><button class="btn-artbyid" name="editCom"> Envoyer</button></a>

            </div>
        </form>
    </div>
</div>