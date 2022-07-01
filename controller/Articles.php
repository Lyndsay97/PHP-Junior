<?php

namespace blog\controller;

use blog\model\ArticleManager;

class Articles extends ArticleManager
{
    /****************************************  __ CREER ARTICLE__ ********************************
     * 
     */

    public function postArticle()
    {
        // Le bouton d'envoi de l'action
        if (isset($_POST['btnCreate'])) {

            // Si les champs suivant sont rempli avec des conditions
            if (isset($_SESSION['id']) && !empty($_POST['msg']) && !empty($_POST['titre']) && isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
                // Les conditions pour le contenue texte
                $msg = strip_tags(nl2br(htmlspecialchars($_POST['msg'])));
                $titre = strip_tags(htmlspecialchars($_POST['titre']));
                //condition pour l'image
                $tailleMax = 2097125;
                $extensionValides = array('jpeg', 'png', 'jpg');
                if ($_FILES['img']['size'] <= $tailleMax) {
                    $extensionUpload = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
                    if (in_array($extensionUpload, $extensionValides)) {
                        $chemin = "./assets/articles/" . $_SESSION['id'] . "_" . str_replace(" ", "", $titre) . "." . $extensionUpload;
                        $resultat = move_uploaded_file($_FILES['img']['tmp_name'], $chemin);
                        // Si toute les conditions precedentes sont bonnes , les valeurs a envoyés a la db via la requetes (models)
                        if ($resultat) {

                            $this->msg = $msg;
                            $this->titre = $titre;
                            $this->img = $_SESSION['id'] . "_" . str_replace(" ", "", $titre) . "." . $extensionUpload;
                            $this->id_utilisateurs = $_SESSION['id'];
                            $this->createArticle();
                            header("location: index.php?home");
                            // Si il ya des erreurs alors affiche les erreurs
                        } else {
                            echo " Erreur lors de l'envoi de l'image";
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Votre image doit être au format: jpeg, png!</div>';
                    }
                } else {
                    echo  "<div class='alert alert-danger'>Veuillez respecter la taille de l'image qui est de 2Mo</div>";
                }
                // Si la personnes n'est connecté a aucune session
            } else if (!isset($_SESSION['id']) && !empty($_POST['msg']) && !empty($_POST['titre'])) {

                header("location: index.php?connexion");
            } else {
                echo "<div  class='alert alert-danger'>veuillez completer tous les champs</div>";
            }
        }
    }

    /****************************************  __ LISTE ARTICLES__ ********************************
     * 
     */

    // ***************************** Pagination

    public function getPagination()
    {
        //creer le nombre de pages
        $nbrPage = $this->numberPages();
        return  $nbrPage = ceil($nbrPage->numberPage);
    }

    public function listeArticle()
    {
        // Afficher la liste d'articles par rapport aux nombre de pages
        if (isset($_GET['page'])) {
            $this->curentPage = htmlspecialchars((intval($_GET['page'])));
        } else {
            $this->curentPage = 1;
        }
        $offset = ($this->curentPage - 1) * 4;
        return $this->getAllArticle($offset);
    }

    /****************************************  __ ARTICLES DE L'USER__ ********************************
     * 
     */
    public function getArtByUser()
    {
        // Afficher les articles de l'user via sa session et son id
        if (isset($_SESSION['id']) && isset($_GET['id_utilisateurs'])) {
            $this->id_utilisateurs = $_GET['id_utilisateurs'];
            return  $this->getAllArticleByUser();
        }
    }

    /****************************************  __ SEARCH ARTICLES********************************
     * 
     */

    public function searchArticleHome()
    {
        if (isset($_GET["btnrechercheArticleHome"]) and $_GET["btnrechercheArticleHome"] == "btnrechercheArticle") {
            $_GET["rechercheArticle"] = htmlspecialchars($_GET["rechercheArticle"]);  //pour sécuriser le formulaire contre les failles html 
            $rechercheprofile = $_GET["rechercheArticle"];
            $rechercheprofile = trim($rechercheprofile); //pour supprimer les espaces dans la requête de l'internaute
            $rechercheprofile = strip_tags($rechercheprofile);  //pour supprimer les balises html dans la requête`
            return $this->searchArticleModel($rechercheprofile);
        }
    }

    /****************************************  __ FIND/ ARTICLE BY ID__ (1)********************************
     * 
     */
    public function findArticleIdArticle()
    {
        $id_Article = $this->id;
        return $this->getArticleById($id_Article);
    }

    /****************************************  __ FIND/MODIFIER ARTICLE BY ID__ (1)********************************
     * 
     */
    public function findArticleId()
    {
        if (isset($_GET['idArticle'])) {
            $this->id = $_GET['idArticle'];

            return $this->getArticleById();
        }
    }

    // ************************** AVEC PSEUDO

    public function findArticleIdPseudo()
    {
        if (isset($_GET['idArticle'])) {
            $this->id = $_GET['idArticle'];

            return $this->getArticleByIdPseudo();
        }
    }

    /****************************************  __ MODIFIER ARTICLE BY ID__2 ********************************
     * 
     */

    public function modifArticleId()
    {   // Si el bouton est cliqué alors 
        if (isset($_POST['upArt'])) {
            // Si les post ne sont pas vides alors
            if (!empty($_POST['up_titre']) && !empty($_POST['up_msg']) || (!empty($_POST['img']) && !empty($_POST['img']['name']))) {
                // Verification des éléments envoyés
                $msg = nl2br(htmlspecialchars($_POST['up_msg']));
                $titre = strip_tags(htmlspecialchars($_POST['up_titre']));
                // images
                $tailleMax = 2097125;
                $extensionValides = array('jpeg', 'png', 'jpg');
                if ($_FILES['img']['size'] <= $tailleMax) {
                    $extensionUpload = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
                    if (in_array($extensionUpload, $extensionValides)) {
                        $chemin = "./assets/articles/" . $_SESSION['id'] . "_" . str_replace(" ", "", $titre) . "." . $extensionUpload;
                        $resultat = move_uploaded_file($_FILES['img']['tmp_name'], $chemin);
                        // Si tout est ok alors envoie les donnees a la db
                        if ($resultat) {
                            $this->msg = $msg;
                            $this->titre =  $titre;
                            $this->img = $_SESSION['id'] . "_" . str_replace(" ", "", $titre) . "." . $extensionUpload;
                            $this->id = $_POST['upArt'];
                            $this->updateArticle();
                            echo "<div class='alert alert-success' role='alert'> L'article a été modifié! </div>";
                            header('location: index.php?home');
                            // Sinon affiche les erreurs
                        } else {
                            echo "<div class='alert alert-danger' role='alert'> Erreur lors de l'envoi de l'image </div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'> Votre image doit être au format: jpeg, png</div>";
                    }
                } else {
                    echo  "<div class='alert alert-danger' role='alert'> Veuillez respecter la taille de l'image qui est de 2Mo</div>";
                }
            } else if (!isset($_SESSION['id'])) {

                header("location: index.php?connexion");
            } else {
                echo "<div class='alert alert-danger' role='alert'>veuillez completer tous les champs</div>";
            }
        }
    }

    /****************************************  __ DELETE ARTICLE BY ID__ ********************************
     * 
     */

    public function supArticleId()
    {
        // si le bouton est cliqué
        if (isset($_POST['submitDelet'])) {
            // dans le bouton submit prendre la valeur donc l'id de l'article
            $this->id = $_POST['submitDelet'];
            $this->deleteArticle();
            if (isset($_GET['home'])) {
                header('location:index.php?home');
            }
        }
    }
}
