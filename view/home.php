<?php

use blog\controller\Articles;


// CONTROLLER ARTICLES
$listArticles = new Articles();
$curentPage = 1;
$listArticles->curentPage = $curentPage;
$po = $listArticles->listeArticle();
$listArticles->supArticleId();
$search = $listArticles->searchArticleHome();

$nbpag = $listArticles->getPagination();

// *******************************************************
if (isset($_GET['page']) && $listArticles->curentPage > $nbpag) {
    header('location:index.php?home');
} else { ?>

    <div class="div-principale-home">
        <!--------------------------------------     HOME HTML   ------------------------------------------>
        <h1 class="h1-home">Articles</h1>
        <div class="home-search">
            <!---------------------------------- FORM   RECHERCHE ARTICLES --------------------------------->
            <form class="form-home" action="" method="GET">
                <input type="search" name="rechercheArticle" placeholder=" mots clés" />
                <button type="submit" name="btnrechercheArticleHome" value="btnrechercheArticle">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <!----------------------------------- CREER ARTICLE --------------------------------------------->
            <a class="a-home" href="index.php?createArticle">
                <button type="button" class="btnhome"><i class="fa-solid fa-pen-nib"></i> Postez!
                </button>
            </a>
        </div>
        <!-------------------------------------------------------       LISTE RECHERCHE         ---------------------------------------------------------------------------->
        <div class="container-flex">
            <?php if (isset($search) && !empty($search)) { ?>

                <?php // afficher les articles recherches dans une boucle
                foreach ($search as $searchuser) { ?>
                    <div class="sous-container-flex">
                        <div class="element-h">
                            <h4><b><?php if ($searchuser->nom === 'utilisateur') {
                                        echo '<i class="fa-solid fa-user"></i>';
                                    } else if ($searchuser->nom === 'admin') {
                                        echo '<i class="fa-solid fa-crown"></i>';
                                    } ?> <?= $searchuser->pseudo ?> </b>
                            </h4>
                            <h5><b> Titre: <?= $searchuser->titre ?></b></h5>
                        </div>

                        <div class="element-img">
                            <img src="assets/articles/<?= $searchuser->img ?>" class="card-img-top" alt="...">
                        </div>
                        <p> <?= substr($searchuser->msg, 0, 80) . "..."; ?> </p>
                        <p> <?= $searchuser->dateArticles ?></p>

                        <div class="element-btn">
                            <a href="index.php?articleById&idArticle=<?= $searchuser->id ?>">
                                <button type="button"><i class="fa-solid fa-comment-dots"></i></button>
                            </a>
                            <?php // permet d'afficher des boutons commetner, modifier, supprimer celon la sesion de l'utilisateur et son role
                            if (isset($_SESSION['id'])) { ?>
                                <?php if (($_SESSION['id'] === $searchuser->id_auteur) || ($_SESSION['role']) === 'admin') { ?>

                                    <form action="" method="post">
                                        <a href="index.php?modifArticle&idArticle=<?= $searchuser->id ?>">
                                            <button name="modif" type="button">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </a>
                                        <button id="idDel" type="submit" name="submitDelet" value="<?= $searchuser->id ?>"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>

                            <?php }
                            } ?>
                        </div>
                    </div>
                <?php } ?>

            <?php  } ?>
            <!------------------------------------------------------- (meme fonctionnement de la recherche)       LISTE ARTICLES         ------------------------------------------------------>
            <?php if (empty($po)) { ?>
                <h4>Aucun article disponible!</h4>
            <?php } elseif (!empty($po) && empty($search)) { ?>
                <?php foreach ($po as $articles) { ?>
                    <div class="sous-container-flex">
                        <div class="element-h">
                            <h4><b><?php if ($articles->id_Roles === '1') {
                                        echo '<i class="fa-solid fa-user"></i>';
                                    } else if ($articles->id_Roles === '2') {
                                        echo '<i class="fa-solid fa-crown"></i>';
                                    } ?> <?= $articles->pseudo ?> </b>
                            </h4>
                            <h5><b> Titre: <?= $articles->titre ?></b></h5>
                        </div>
                        <div class="element-img">
                            <img src="assets/articles/<?= $articles->img ?>" class="card-img-top" alt="...">
                        </div>
                        <p> <?= substr($articles->msg, 0, 80) . "..."; ?> </p>
                        <p> <?= $articles->dateArticles ?></p>
                        <div class="element-btn">
                            <a href="index.php?articleById&idArticle=<?= $articles->id ?>">
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
                <?php } ?>
            <?php  }
            ?>
        </div>
        <!-------------------------------------- HTML (pagination) ------------------------ -->
        <!----------------Page  Precedent  les pages sont disposé au nb de 3  ----- -->
        <div class="pagination">
            <nav class="nav-pagination">
                <ul class="">
                    <?php
                    //********  Si $listArticles->curentPage est sup a 1 alors
                    if (empty($search)) {
                        if ($listArticles->curentPage > 1) { ?>
                            <!-- la fleche directionnelle gauche enleve une page donc page precedente-->
                            <li class="li-pag">
                                <a class="a-pag" aria-label="Previous" href="index.php?home&page=<?= $listArticles->curentPage - 1 ?>">
                                    << </a>
                            </li>
                            <?php  }
                        //*************  Alors on fait une boucle pour les pages precedente
                        for ($page = 2; $page >= 1; $page--) {
                            // Si la valeur de ($$listArticles->curentPage - $page) est >= 1 alors
                            if ($listArticles->curentPage - $page >= 1) { // afficher afficher ça => $listArticles->curentPage - $page
                            ?>
                                <li class="li-pag">
                                    <a class="a-pag" href="index.php?home&page=<?= $listArticles->curentPage - $page ?>"><?= $listArticles->curentPage - $page ?>
                                    </a>
                                </li>
                        <?php }
                        } ?>
                        <a href="index.php?home&page=<?= $listArticles->curentPage ?>"><?= $listArticles->curentPage ?></a>
                        <?php
                        //*************  Alors on fait une boucle pour les pages suivantes
                        for ($pageplus = 1; $pageplus <= 2; $pageplus++) {
                            if ($listArticles->curentPage + $pageplus <= $nbpag) { ?>
                                <li class="pli-pag">
                                    <a class="a-pag" href="index.php?home&page=<?= $listArticles->curentPage + $pageplus ?>"><?= $listArticles->curentPage + $pageplus ?></a>
                                </li>
                        <?php }
                        } ?>
                        <!----------------Page  Suivante -------- -->
                        <?php if ($listArticles->curentPage < $nbpag) { ?>
                            <li class="li-pag">
                                <a class="a-pag" aria-label="Next" href="index.php?home&page=<?= $listArticles->curentPage + 1 ?>">>></a>
                            </li>
                        <?php } ?>
                </ul>
            </nav>
        </div>
<?php
                    }
                } ?>
    </div>