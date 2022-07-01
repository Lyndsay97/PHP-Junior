<?php

namespace blog\model;

// use PDO;

class Database
{
    protected $db;

    /******************************  Heritage (instance)  de chaque Sous class
     *  La connexion est dans uen focntion constructor qui peut etre herité par les enfant de la classe merer (database)
     */
    public function __construct()
    {
        // avec la condition try catch qui permet de se connecter a la base de donnes
        try {
            $this->db = new \PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=utf8', LOGIN, PASSWORD); // on utilise les const pour proteger la db
        } catch (\Exception $ex) { // si il ya erreeur afficher le message
            $ex->getMessage();
        }
    }
}
