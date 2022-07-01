<?php

namespace blog\controller;

use blog\model\UserManager;

class Users extends UserManager
{




    /************************************  __ INSCRIPTION __ ***********************************
     * 
     */


    public function inscription()
    { // Si le bouton existe alors
        if (isset($_POST['envoi'])) {
            // Tableau contenant les erreur et les success
            $formError = [];
            $formSuccess = [];
            // Si les champs sont rempli et verifier le types de données envoyer
            if (!empty($_POST['pseudo']) && !empty($_POST['mdp']) && !empty($_POST['email'])) {
                $pseudo = htmlspecialchars($_POST['pseudo']); // protéger des xss
                $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // proteger mdp et xss
                $mail = htmlspecialchars($_POST['email']);
                echo $formSuccess['success'] = '<div class="alert alert-success">Votre compte a été crée!</div>';
            } else {
                echo $formError['error'] = '<div class="alert alert-warning"> Veuillez remplir tout les champs!</div>';
            }
            // Si il ya pas d'erreur envoyer les donnes
            if (empty($formError)) {
                $pseu = $this->pseudo = $pseudo;
                $md = $this->mdp = $mdp;
                $ma = $this->mail = $mail;
                $this->insertUser($pseu, $ma, $md); // InsertUsers relié a modelUsers (quand elle a ete cree)
                header('location:index.php?connexion');
            }
        }
    }

    /******************************************  __ CONNEXION __ ************************************
     * 
     */

    public function connexion()
    {
        // si le subCo existe verifier sa
        if (isset($_POST['subCo'])) {
            // si il ya erreur
            $formError = []; // creation $ pour les erreur
            // si les champs ne sont pas vide
            if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) {
                $pseudo = htmlspecialchars($_POST['pseudo']);
                $this->pseudo = $pseudo;
                $mdp = htmlspecialchars($_POST['mdp']);
            } else {

                echo $formError['erreur'] = "veuillez completer tous les champs";
            }
            if (empty($formError)) {
                $p = $this->session();
                // si  La sesion est un objet
                if (is_object($p)) {
                    // Si les donnes sont stricetement les memes
                    if (($pseudo === $p->pseudo)  && password_verify($mdp, $p->mdp)) {
                        // Alors dans la session , il y aura les infos de l'utilisateur
                        $_SESSION['role'] = $p->nom;
                        $_SESSION['id'] = $p->id;
                        $_SESSION['pseudo'] = $p->pseudo;
                        $_SESSION['mail'] = $p->mail;
                        header('location: index.php?home');
                    }
                } else {
                    echo '<div class="alert alert-danger">mot de passe ou pseudo incorrect</div>';
                }
            }
        }
    }


    /******************************************  __ FIND list USERS __ ********************************
     * 
     */

    public function listUsers()
    {
        return $this->getUser();
    }



    /************************************  __ SEARCH USER __ ***********************************
     * 
     */


    public function searchUser()
    {
        if (isset($_POST["submitrechercheUserList"]) and $_POST["submitrechercheUserList"] == "submitrechercheUser") {
            $_POST["rechercheUser"] = htmlspecialchars($_POST["rechercheUser"]);  //pour sécuriser le formulaire contre les failles html            
            $recherchelist = $_POST["rechercheUser"];
            $recherchelist = trim($recherchelist); //pour supprimer les espaces dans la requête de l'internaute
            $recherchelist = strip_tags($recherchelist);  //pour supprimer les balises html dans la requête`              
            return $this->searchUserModel($recherchelist);
        }
    }




    /************************************  __ MON PROFIL __ ***********************************
     * 
     */

    public function getProfil()
    {
        $up = null;
        if (isset($_SESSION['id'])) {
            $this->id = $_SESSION['id'];
            $up =   $this->getUserById();
        }
        return $up;
    }

    /************************************  __ MODIF PROFIL __ ***********************************
     * 
     */

    public function modifProfil()
    { // Si le bouton est cliqué et que toute les conditons ne sont pas vide et son verifier alors modifie
        if (isset($_POST['updateEdit'])) {
            if (!empty($_POST['up_pseudo']) && !empty($_POST['up_mail']) || (!empty($_POST['avatar']) && !empty($_POST['avatar']['name']))) {
                $tailleMax = 2097125;
                $extensionValides = array('jpeg', 'png', 'jpg', 'gif');
                if ($_FILES['avatar']['size'] <= $tailleMax) {

                    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                    if (in_array($extensionUpload, $extensionValides)) {

                        $chemin = "./assets/avatars/" . $_SESSION['id'] . "." . $extensionUpload;
                        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                        // envoie des donnes dans la db
                        if ($resultat) {
                            $this->id = $_POST['updateEdit'];
                            $this->pseudo = $_POST['up_pseudo'];
                            $this->mail = $_POST['up_mail'];
                            $this->avatar = $_SESSION['id'] . "." . $extensionUpload;
                            $this->updateProfil();
                            header('location: index.php?profilUser');
                            echo " res ok";
                            // Sinon afficher les erreurs
                        } else {
                            echo  '<div class="alert alert-warning">Erreur lors de l\'envoi de l\'image.</div>';
                        }
                    } else {
                        echo  '<div class="alert alert-warning">Votre image doit être au format: jpeg, png.</div>';
                    }
                } else {
                    echo  '<div class="alert alert-warning">Veuillez respecter la taille de l\'image qui est de 2Mo.</div>';
                }
            } else if (!isset($_SESSION['id'])) {

                header("location: index.php?connexion");
            } else {
                echo  '<div class="alert alert-warning">Veuillez remplir tout les champs.</div>';
            }
        }
    }

    /***********************************************  __ GIVE ROLE __ *************************************
     * 
     */

    public function giveRole()
    { // Donner le role admin a un utilisateur via sont id et l'id du role
        if (isset($_POST['submitRole'])) {
            $this->id = $_POST['idAdmins'];
            $this->id_Roles = 2;
            $this->updateRole();
            header('location:index.php?listUsers');
        }
    }

    /***********************************************  __ DELETE __ *************************************
     * 
     */

    public function deleteUsersId()
    {

        if (isset($_POST['submitDelet'])) {
            $this->id = $_POST['submitDelet'];
            $this->deleteUsers();
            if ($_SESSION['role'] === 'admin') {
                header('location: index.php?listUsers');
                echo  '<div class="alert alert-success">Compte supprimer!</div>';
            } else {
                header('location: index.php?home');
            }
        }
    }






    /***********************************************  RDV  *************************************
     * 
     */
}
