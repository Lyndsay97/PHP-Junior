<?php

namespace blog\controller;

use blog\model\CommentManager;

class Comments extends CommentManager
{
    /****************************************  __ CREER COMMENTAIRE__ ********************************
     * 
     */

    public function postComment()
    {
        // on creer un taleau pour contenir les erreurs
        $formSucces = [];
        $formError = [];
        // si le bouton existe 
        if (isset($_POST['editCom'])) {
            // si l'envoie est rempli et qu'il existe une session
            if (!empty($_POST['up_com']) && isset($_SESSION['id'])) {
                $commentaire = nl2br(htmlspecialchars($_POST['up_com']));
                // si il n'ya pas d'erreurs envoie:
                if (empty($formError)) {
                    $this->commentaire = $commentaire;
                    $p = $this->id_utilisateurs = $_SESSION['id'];
                    $o = $this->id_Articles = $_POST['up_id'];
                    $this->createComment($commentaire, $o, $p);
                    $formSucces['succes'] = '<div class="alert alert-success">Commentaire posté!</div>';
                    header("location:index.php?articleById&idArticle=" . $this->id_Articles . "");
                }
                // Si ya pas de session
            } else if (!isset($_SESSION['id']) && !empty($_POST['up_com']) && !empty($_POST['up_id'])) {

                header("location: index.php?connexion");
            } else {
                echo $formError['error'] = '<div class="alert alert-warning"> Veuillez remplir tout les champs!</div>';
            }
        }
    }

    /****************************************  __ FIND COMMENT BY ARTICLE__ ********************************
     * 
     */

    public function findComments()
    {   // Afficher commentaire
        if (isset($_GET['idArticle'])) {
            $p = $this->id_Articles = intval($_GET['idArticle']);
            return $this->getAllComByArticle($p);
        }
    }


    /****************************************  __DELETE COMMENT__ ********************************
     * 
     */

    public function delComment()
    {   // Conditions pour supprimer le commentaire
        if (isset($_POST['supcom'])) {
            $this->id = $_POST['supcom'];
            $this->deleteComment();
            header("location:index.php?articleById&idArticle=" . $this->id_Articles . "");
            echo "<div class='alert alert-success' role='alert'> Commentaire supprimé! </div>";
        }
    }
}
