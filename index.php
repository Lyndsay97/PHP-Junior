<?php
// restaure lees header 
ob_start();
// ouvrir une session 
session_start();

include "model/Config.php";
include "model/Database.php";
include "model/UserManager.php";
include "model/ArticleManager.php";
include "model/CommentManager.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/styleblog.css">
    <link rel="stylesheet" href="./assets/stylenav.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!--------------------- NAV BAR--------------------------->
    <div id="myNav" class="overlay">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="overlay-content">
            <a class="nav-a" href="index.php?home">Acceuil</a>
            <!------------------- Session utilisateur -------------------------->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'utilisateur') { ?>
                <a href="index.php?mesArticles&id_utilisateurs=<?= $_SESSION['id'] ?>" name="mesarticle">
                    Mes Articles </a>
                <a href="index.php?profilUser&idUser=<?= $_SESSION['id'] ?>">Mon Profil</a>
                <a class="nav-link text-danger" href="index.php?DeconnexionUser" name="deco">deconnexion</a>
            <?php } elseif (isset($_SESSION['role'])  && $_SESSION['role'] === 'admin') { ?>
                <!------------------- Session Admin -------------------------->
                <a href="index.php?listUsers">liste des membres</a>
                <a href="index.php?mesArticles&id_utilisateurs=<?= $_SESSION['id'] ?>" name="mesarticle">
                    Mes Articles </a>
                <a href="index.php?profilUser&idUser=<?= $_SESSION['id'] ?>">Mon Profil</a>
                <a class="nav-link text-danger" href="index.php?DeconnexionUser" name="deco">deconnexion</a>
            <?php } else { ?>
                <a href="index.php?connexion">connexion</a>
            <?php } ?>
        </div>
    </div>
    <span><a onclick="openNav()">&equiv;</a></span>


    <!------------------ PAGE PHP ------------------------>
    <?php // permet d'afficher les pages via un get 
    if (isset($_GET['home'])) {
        include 'controller/Articles.php';
        include 'controller/Users.php';
        include 'view/home.php';
    } // INSCRIPTION
    else if (isset($_GET['inscription'])) {
        include 'controller/Users.php';
        include 'view/inscription.php';
    } // DECONNEXION
    else if (isset($_GET['DeconnexionUser'])) {
        include 'controller/DeconnexionUser.php';
    } // CONNEXION
    else if (isset($_GET['connexion'])) {
        include 'controller/Users.php';
        include 'view/connexion.php';
    } // PROFIL USER
    else if (isset($_GET['profilUser'])) {
        include 'controller/Users.php';
        include 'view/profilUser.php';
    } // LIST USERS
    else if (isset($_GET['listUsers'])) {
        include 'controller/Users.php';
        include 'view/listUsers.php';
    } // CREATE_ARTICLE
    else if (isset($_GET['createArticle'])) {
        include 'controller/Articles.php';
        include 'view/createArticle.php';
    } // ARTICLES USER
    else if (isset($_GET['mesArticles'])) {
        include 'controller/Articles.php';
        include 'view/mesArticles.php';
    } // UN ARTICLE
    else if (isset($_GET['articleById'])) {
        include 'controller/Articles.php';
        include 'controller/Comments.php';
        include 'view/articleById.php';
    }
    // MODIFY_ARTICLE
    else if (isset($_GET['modifArticle'])) {
        include 'controller/Articles.php';
        include 'view/modifArticle.php';
    } // HOME
    else {
        include 'controller/Articles.php';
        include 'controller/Users.php';
        include 'view/home.php';
    }
    ?>


    <footer>
        <div class="foo-div">
            <a href="#"> Mention légales</a>
            <a href="#"><i class="fa-brands fa-linkedin"></i> </a>
            <a href="#"><i class="fa-brands fa-github"></i></a>
            <a href="#"><i class="fa-brands fa-codepen"></i></a>
        </div>
    </footer>

    <script src="./assets/styleblog.js"></script>
    <script src="https://kit.fontawesome.com/f5f769d234.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>