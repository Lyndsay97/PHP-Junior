<?php

namespace blog\model;

class ArticleManager extends Database
{
    // Les attributs de la tables article de la db
    protected $msg = "msg";
    protected $titre = " ";
    protected $id_utilisateurs;
    protected $id;
    protected $img = " ";

    /****************************************************  __CONSTRUCTOR__ ********************************
     *  Permets d'hériter a la connexion de la db via le construct de la classe mere (database)
     */

    public function __construct()
    {
        parent::__construct();
    }


    /***************************************************  __CREER ARTICLE__ ********************************
     *  Requete sql permetnant d'inserer des valeurs a la table articles via l'id de l'user
     */
    public function createArticle()
    {
        $req = 'INSERT INTO `articles`(`msg`, `id_utilisateurs`, `titre`, `img`) VALUES (:msg, :id_utilisateurs, :titre, :img)';
        $insertArticle = $this->db->prepare($req); // fait la requetes
        $insertArticle->bindValue(':msg', $this->msg, \PDO::PARAM_STR); // permets de d'envoie des valeurs en securisant via PDO// PARAM_STR=> type characteres
        $insertArticle->bindValue(':titre', $this->titre, \PDO::PARAM_STR);
        $insertArticle->bindValue(':img', $this->img, \PDO::PARAM_STR);
        $insertArticle->bindValue(':id_utilisateurs', $this->id_utilisateurs, \PDO::PARAM_INT);
        return $insertArticle->execute(); // executer la requetes en ajoutant les ajouts de valeurs
    }



    /*******************************************************  __LISTE ARTICLES BY USER__ ********************************
     *  Selectionner les valeurs dans une tables pour les afficher en joinnant plusieurs tables via une requetes sql
     */

    public function getAllArticleByUser()
    {
        $query = 'SELECT pseudo, articles.id, img, titre, utilisateurs.id as id_auteur, msg, dateArticles  FROM `articles` INNER JOIN `utilisateurs` ON utilisateurs.id = articles.id_utilisateurs WHERE articles.id_utilisateurs = :id ORDER BY dateArticles DESC';
        $article = $this->db->prepare($query);
        $article->bindValue(':id', $this->id_utilisateurs, \PDO::PARAM_INT);
        $article->execute();
        return $article->fetchAll(\PDO::FETCH_OBJ); // afficher la reqeute en forme d'objet permettant de l'afficher en boucle si plusieurs articles
    }

    /*************************************************  __ALL ARTICLES / PAGINATION__ *******************************
     * 
     */

    // ********************************** P1

    public function getAllArticle($offset = 0) // offset permet d'assigner une position donner pour la pagination
    {       // selectionner les valeurs d'une table et une autre via une jointure , mettre dans l'ordre de sortie par date la plus recente
        $query = 'SELECT articles.id, pseudo, img, titre, msg, dateArticles, id_Roles, utilisateurs.id as id_auteur FROM utilisateurs INNER JOIN articles ON utilisateurs.id = articles.id_utilisateurs ORDER BY dateArticles DESC
          LIMIT 3 OFFSET :offset ';
        $article = $this->db->prepare($query);
        $article->bindValue(':offset', $offset, \PDO::PARAM_INT) .
            $article->execute();
        return $article->fetchAll(\PDO::FETCH_OBJ);
    }
    // ********************************** P2
    public function numberPages()
    {  // permet de diviser par 4 les articles a afficher
        $req = 'SELECT COUNT(id)/4 AS numberPage FROM articles;';
        $article = $this->db->prepare($req);
        if ($article->execute()) {
            return $article->fetch(\PDO::FETCH_OBJ);
        }
    }

    /*******************************************  __ARTICLE PAR ID__ ********************************
     *  Selctionner les valeurs de l'article via son id
     */
    public function getArticleById()
    {
        $query = 'SELECT * FROM `articles` WHERE `id`=:id ;';
        $find = $this->db->prepare($query);
        $find->bindValue(':id', $this->id, \PDO::PARAM_INT);
        if ($find->execute()) {
            return $find->fetch(\PDO::FETCH_OBJ);
        }
    }
    // *****************************AVEC PSEUDO 
    public function getArticleByIdPseudo()
    {
        $query = 'SELECT articles.id, utilisateurs.pseudo, msg, img, titre, dateArticles 
        FROM articles 
        JOIN utilisateurs 
        ON utilisateurs.id = id_utilisateurs
        WHERE articles.id = :id ';
        $find = $this->db->prepare($query);
        $find->bindValue(':id', $this->id, \PDO::PARAM_INT);
        if ($find->execute()) {
            return $find->fetch(\PDO::FETCH_OBJ);
        }
    }

    /****************************************  __ SEARCH ARTICLES HOME__ ********************************
     *  Rechercher  un article via un mot clé (titre ou msg)
     */

    public function searchArticleModel($recherche)
    {

        $rechercheArticle = "SELECT articles.id, msg, titre, dateArticles, pseudo, nom , img, utilisateurs.id AS id_auteur  FROM articles INNER JOIN utilisateurs ON articles.id_utilisateurs = utilisateurs.id INNER JOIN roles ON roles.id = utilisateurs.id_Roles  WHERE titre  LIKE '%" . $recherche . "%' || msg LIKE '%" . $recherche . "%' || pseudo LIKE '%" . $recherche . "%' GROUP BY articles.id";
        $article = $this->db->prepare($rechercheArticle);
        $article->execute();
        return $article->fetchAll(\PDO::FETCH_OBJ);
    }




    /****************************************  __MODIFIER ARTICLE__ ********************************
     * 
     */
    public function updateArticle()
    {
        $req = 'UPDATE `articles` SET `msg`=:msg, `img`=:img, `titre`=:titre WHERE id=:id';
        $article = $this->db->prepare($req);
        $article->bindValue(':img', $this->img, \PDO::PARAM_STR); // securiser la requetes sql 
        $article->bindValue(':titre', $this->titre, \PDO::PARAM_STR);
        $article->bindValue(':msg', $this->msg, \PDO::PARAM_STR);
        $article->bindValue(':id', $this->id, \PDO::PARAM_INT);
        return $article->execute();
    }



    /************************************************  __DELETE__ ********************************
     * Permet de supprimier via l'id de l'article
     */

    public function deleteArticle()
    {
        $query = 'DELETE FROM `articles` WHERE `id`=:id;';
        $article = $this->db->prepare($query);
        $article->bindValue(':id', $this->id, \PDO::PARAM_INT);
        return $article->execute();
    }
}
