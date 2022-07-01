<?php

use blog\controller\Articles;

$p = new Articles();
$art = $p->findArticleId();
$p->modifArticleId();
?>
<!------------------------------------- MODIFIER ARTICLES --------------------------------->
<div class="divup">
    <h2 class="h1up">Modifier votre article</h2>
    <form method="POST" class="formup text-center" enctype="multipart/form-data">
        <?php
        ?>
        <label for="up_img"><b>Image: </b></label>
        <input type="file" name="img" accept="image/png, image/jpeg, image/jpg" value="<?= $art->img ?>">
        <label for="up_titre"><b>Titre: </b></label>
        <input class="input-mod-art1" type="text" name="up_titre" value="<?= $art->titre ?>">
        <label for="up_msg"><b>Texte: </b></label>
        <textarea class="textup" name="up_msg"><?= $art->msg ?></textarea>
        <button type="submit" class="btnup" name="upArt" value="<?= $art->id ?>">modifier</button>
        <?php
        ?>
    </form>
</div>