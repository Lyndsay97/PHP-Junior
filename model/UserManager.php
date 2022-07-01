<?php

namespace blog\model;

class UserManager extends Database
{
    protected $pseudo;
    protected $mdp;
    protected $mail;
    protected $id;
    protected $id_Roles;
    protected $avatar;

    /****************  __CONSTRUCTOR__ ********************************
     * 
     */
    public function __construct()
    {
        // on fait appel au construct de db
        parent::__construct();
    }

    /****************  __INSCRIPTION__ ********************************
     * 
     */

    public function insertUser($pseudo, $mail, $mdp)
    {

        $requete = 'INSERT INTO `utilisateurs`(`pseudo`, `email`, `MotDepasse`) VALUES (:pseudo , :email , :MotDepasse)';
        $insert = $this->db->prepare($requete);
        $insert->bindValue(':pseudo', $this->pseudo, \PDO::PARAM_STR);  // string(mot/phrase)
        $insert->bindValue(':MotDepasse', $this->mdp, \PDO::PARAM_STR);
        
        $insert->bindValue(':email', $this->mail, \PDO::PARAM_STR);      //entier (number)
        return $insert->execute();
    }

   

    /****************  __GET USER__ ********************************
     * 
     */

    public function getUser()
    {
        $role = 'SELECT utilisateurs.`id`, `email`, `MotDepasse`, `pseudo`, `nom`, `id_Roles` FROM `utilisateurs` INNER JOIN roles ON utilisateurs.id_Roles = roles.id';
        $selectUsers = $this->db->query($role);
        $selectUsers->execute();
        return $selectUsers->fetchAll(\PDO::FETCH_OBJ);
    }


    /****************  __SESSION__ ********************************
     * 
     */
    public function session()
    {
        $garderSession = 'SELECT utilisateurs.id  , email as mail, pseudo, MotDepasse as mdp, nom FROM `utilisateurs` INNER JOIN roles ON utilisateurs.id_Roles = roles.id WHERE `pseudo` = :pseudo';
        $selectUsers = $this->db->prepare($garderSession);
        $selectUsers->bindValue(':pseudo', $this->pseudo, \PDO::PARAM_STR);
        $selectUsers->execute();
        return $selectUsers->fetch(\PDO::FETCH_OBJ);
    }


    /****************  __USER BY ID__ ********************************
     * 
     */



    public function getUserById()
    {
        $result = array();
        $query = 'SELECT * FROM `utilisateurs` WHERE id= :id';
        $find = $this->db->prepare($query);
        $find->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $find->execute();
        $result = $find->fetch(\PDO::FETCH_OBJ);
        return $result;
    }


/****************************************  __ SEARCH USER IN LIST__ ********************************
     * 
     */

    public function searchUserModel($recherche){

        $rechercheUser = "SELECT utilisateurs.id, email, pseudo, id_Roles, nom FROM `utilisateurs` INNER JOIN roles ON id_Roles= roles.id WHERE nom LIKE '%". $recherche . "%' || pseudo LIKE '%". $recherche . "%' GROUP BY utilisateurs.id";
        $user= $this->db->prepare($rechercheUser);
        $user->execute();
        return $user->fetchAll(\PDO::FETCH_OBJ);
    }



  /****************  __UPDATE ROLE _ ********************************
     * 
     */


    public function updateRole()
    {
        $req = 'UPDATE utilisateurs  INNER JOIN roles ON roles.id = id_Roles SET id_Roles = :id_Roles  WHERE utilisateurs.id= :id';
        $userup = $this->db->prepare($req);
        $userup->bindValue(':id_Roles', $this->id_Roles, \PDO::PARAM_INT);
        $userup->bindValue(':id', $this->id, \PDO::PARAM_INT);
        return $userup->execute();
    }






    /****************  __ UPDATE  PROFIL__ ********************************
     * 
     */

    public function updateProfil()
    {
        $req = 'UPDATE utilisateurs SET pseudo = :pseudo, email = :email, avatar = :avatar  WHERE id= :id';
        $userup = $this->db->prepare($req);
        $userup->bindValue(':pseudo', $this->pseudo, \PDO::PARAM_STR);
        $userup->bindValue(':email', $this->mail, \PDO::PARAM_STR);
        $userup->bindValue(':avatar', $this->avatar, \PDO::PARAM_STR);
        $userup->bindValue(':id', $this->id, \PDO::PARAM_INT);
        return $userup->execute();
    }


    /****************  __ DELETE__ ********************************
     * 
     */

    public function deleteUsers()
    {
        $query = 'DELETE FROM `utilisateurs` WHERE `id`= :id ';
        $users = $this->db->prepare($query);
        $users->bindValue(':id', $this->id, \PDO::PARAM_INT);
        return $users->execute();
    }
}