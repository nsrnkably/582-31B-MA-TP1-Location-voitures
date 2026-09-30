<?php
/**
 * Classe CRUD
 * Classe parente de toutes les classes du projet.
 * Elle hérite de PDO : elle crée la connexion à la base de données
 * et contient les méthodes communes (select, selectId, insert, update, delete).
 */
class CRUD extends PDO {

    /**
     * Constructeur : ouvre la connexion avec le constructeur de PDO.
     * Paramètres : hôte, base, port, jeu de caractères, utilisateur, mot de passe.
     */
    public function __construct(){
        parent::__construct('mysql:host=localhost; dbname=location_voitures; port=3306; charset=utf8', 'root', 'admin');
    }

    /**
     * Retourne toutes les lignes d'une table, triées.
     */
    public function select(string $table, $field = "id", $order = "ASC"):array{
        $sql = "SELECT * FROM $table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Retourne une seule ligne selon sa valeur (par défaut l'id).
     * Retourne false si la ligne n'existe pas.
     */
    public function selectId(string $table, int|string $value, $field = 'id'):bool|array{
        $sql = "SELECT * FROM $table WHERE $field = :$field";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        }
    }

    /**
     * Ajoute une ligne.
     * Retourne l'id de la nouvelle ligne, ou false en cas d'erreur.
     */
    public function insert(string $table, array $data):bool|int{
        //insert into voiture (marque, modele, annee, prix_jour, categorie_id) values (:marque, :modele, :annee, :prix_jour, :categorie_id);
          $fieldName = implode(', ', array_keys($data));
          $fieldBindValue = ":".implode(', :', array_keys($data));
          $sql = "INSERT INTO $table ($fieldName) VALUES ($fieldBindValue);";
          $stmt = $this->prepare($sql);
 
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            return false;
        }
    }

    /**
     * Modifie une ligne. $data doit contenir l'id.
     * Retourne true si la requête a fonctionné, false sinon.
     */
    public function update(string $table, array $data, $field = 'id'):bool{
        // update voiture set marque = :marque, modele = :modele, ... where id = :id;
        $fieldName = null;
        foreach($data as $key=>$value){
            $fieldName .= "$key = :$key, ";
        }
        $fieldName = rtrim($fieldName, ', ');
        $sql = "UPDATE $table SET $fieldName WHERE $field = :$field;";
        $stmt = $this->prepare($sql);
 
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Supprime une ligne selon sa valeur (par défaut l'id).
     * Retourne true si la requête a fonctionné, false sinon.
     */
    public function delete(string $table, int|string $value, $field = 'id'):bool{
        //delete from table where id = :id;
        $sql = "DELETE FROM $table WHERE $field = :$field";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}