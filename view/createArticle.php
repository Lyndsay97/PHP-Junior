<?php

use blog\controller\Articles;

$post = new Articles;
$post->postArticle();


?>
<!---------------------------------- CREATE ARTICLE-->
<div class="post">
    <h2 class="h1post">Poster un article</h2>
    <div class="post1">
        <form class="formpost" method="POST" enctype="multipart/form-data">
            <label for="titre"><b>Titre:</b></label>
            <input class="input-post1" type="text" name="titre">
            <label for="img"><b>Image:</b></label>
            <input type="file" name="img" accept="image/png, image/jpeg, image/jpg">
            <label for="img"><b>Texte:</b></label>
            <textarea class="textpost" name="msg"></textarea>
            <button class="btnpost" type="submit" name="btnCreate">Poster l'article</button>
        </form>
    </div>
</div>