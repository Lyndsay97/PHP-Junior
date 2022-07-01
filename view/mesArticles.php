<?php

use blog\controller\Articles;

$mesarticles = new Articles();
$p = $mesarticles->getArtByUser();
$mesarticles->supArticleId();
?>

<!-------------------------------------------------------     HTML  ------------------------------------>
<?php if (empty($p)) { ?>
    <h3>Aucun article disponible!</h3>
    <div class="div-principale-home">
    <?php } elseif (!empty($p)) { ?>
        <h2 class="h2-my">Vos articles</h2>
        <a class="a-home" href="index.php?createArticle">
            <button class="btn-mypost" type="button"><i class="fa-solid fa-pen-nib"></i> Postez!
            </button>
        </a>
        <div class="container-myflex">
            <?php foreach ($p as $articles) { ?>
                <div class="sous-container-myflex">
                    <div class="element-h2">
                        <h4><b> <?= $articles->pseudo ?> </b>
                        </h4>
                        <h5><b> Titre: <?= $articles->titre ?></b></h5>
                    </div>
                    <div class="element-img2">
                        <img src="assets/articles/<?= $articles->img ?>" class="card-img-top" alt="...">
                    </div>
                    <p> <?= substr($articles->msg, 0, 80) . "..."; ?> </p> <!-- dans l'affiche de l'article afficher que 80carateres -->
                    <p> <?= $articles->dateArticles ?></p>
                    <div class="element-btn2">
                        <a href="index.php?articleById&idArticle=<?= $articles->id ?>">
                            <!-- lien vers l'article-->
                            <button type="button"><i class="fa-solid fa-comment-dots"></i></button>
                        </a>
                        <?php if (isset($_SESSION['id'])) { ?>
                            <?php if (($_SESSION['id'] === $articles->id_auteur) || ($_SESSION['role']) === 'admin') { ?>
                                <form action="" method="post">
                                    <a href="index.php?modifArticle&idArticle=<?= $articles->id ?>">
                                        <button name="modif" type="button">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </a>
                                    <button id="idDel" type="submit" class="btnDel" name="submitDelet" value="<?= $articles->id ?>"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>

        <?php }
        } ?>



        </div>
    </div>