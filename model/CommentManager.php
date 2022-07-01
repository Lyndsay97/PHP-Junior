<?php

namespace blog\model;

class CommentManager extends Database
{

    protected $id;
    protected $commentaire = " ";
    protected $id_utilisateurs;
    protected $id_Articles;


    /****************  __CONSTRUCTOR__ ********************************
     * 
     */
    public function __construct()
    {
        // on fait appel au construct de db
        parent::__construct();
    }




    /****************  POSTER COMMENT ********************************
     * 
     */
    public function createComment()
    {
        $req = 'INSERT INTO `commentaires`(`commentaire`, `id_utilisateurs`, `id_Articles`) VALUES (:commentaire, :id_utilisateurs, :id_Articles)';
        $insertCom = $this->db->prepare($req);
        $insertCom->bindValue(':commentaire', $this->commentaire, \PDO::PARAM_STR);
        $insertCom->bindValue(':id_Articles', $this->id_Articles, \PDO::PARAM_INT);
        $insertCom->bindValue(':id_utilisateurs', $this->id_utilisateurs, \PDO::PARAM_INT);
        return $insertCom->execute();
    }




    /****************  FIND COMMENT BY ID_ARTICLES  ********************************
     * 
     */


    public function getAllComByArticle()
    {
        $query = 'SELECT msg, utilisateurs.pseudo, id_Articles, commentaire , utilisateurs.id, commentaires.id as id_com
        FROM commentaires 
        JOIN articles 
        ON commentaires.id_Articles = articles.id
        JOIN utilisateurs
        ON commentaires.id_utilisateurs = utilisateurs.id
        WHERE id_Articles = :id_Articles';
        $article = $this->db->prepare($query);
        $article->bindValue(':id_Articles', $this->id_Articles, \PDO::PARAM_INT);
        $article->execute();
        return $article->fetchAll(\PDO::FETCH_OBJ);
    }

    /****************  NUMBER COMMENTS FOR ARTICLE  ********************************
     * 
     */
    public function numberComment()
    {
        $req = 'SELECT COUNT(*) as total_comments FROM commentaires WHERE id_Articles = :id_Articles';
        $comment = $this->db->prepare($req);
        $comment->bindValue(':id_Articles', $this->id_Articles, \PDO::PARAM_INT);
        if ($comment->execute()) {
            return $comment->fetch(\PDO::FETCH_OBJ);
        }
    }

    /****************  NUMBER COMMENTS FOR ARTICLE  ********************************
     * 
     */

    public function deleteComment()
    {
        $req = 'DELETE FROM `commentaires` WHERE id=:id';
        $supcomm = $this->db->prepare($req);
        $supcomm->bindValue(':id', $this->id, \PDO::PARAM_INT);
        return $supcomm->execute();
    }
}
