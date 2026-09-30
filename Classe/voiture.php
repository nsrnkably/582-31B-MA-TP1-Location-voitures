<?php
require_once('CRUD.php');

/**
 * Classe Voiture
 * Hérite de CRUD (qui hérite de PDO) : PDO -> CRUD -> Voiture
 * Gère la table voiture et sa relation avec la table categorie (clé étrangère categorie_id).
 */
class Voiture extends CRUD {

    // Nom de la table dans la base de données
    private string $table = 'voiture';

    // Tout est privé ici, on passe par setProp/getProp pour y accéder.
    private int $id;
    private string $marque;
    private string $modele;
    private int $annee;
    private float $prixJour;
    private int $categorieId;
    private string $categorie;   

    // Constructeur : ouvre la connexion (constructeur de CRUD), puis remplit les infos de la voiture si on les donne.
    public function __construct(int $id = 0, string $marque = "", string $modele = "", int $annee = 0, float $prixJour = 0, int $categorieId = 0, string $categorie = "")
    {
        parent::__construct();
        $this->setProp($id, $marque, $modele, $annee, $prixJour, $categorieId, $categorie);
    }

    // Pour remplir les infos de la voiture.
    public function setProp(int $id, string $marque, string $modele, int $annee, float $prixJour, int $categorieId, string $categorie) {
        $this->id = $id;
        $this->marque = $marque;
        $this->modele = $modele;
        $this->annee = $annee;
        $this->prixJour = $prixJour;
        $this->categorieId = $categorieId;
        $this->categorie = $categorie;
    }

    // Pour afficher les infos de la voiture sur la page.
    public function getProp(): string {
        return "Marque : {$this->marque}<br>" . "Modèle : {$this->modele}<br>" . "Année : {$this->annee}<br>" . "Prix par jour : {$this->prixJour} $<br>" . "Catégorie : {$this->categorie}";
    }

    // Retourne l'id de la voiture (utile pour les liens Modifier / Supprimer).
    public function getId(): int {
        return $this->id;
    }

    // Charge une voiture de la base de données dans l'objet.
    // Retourne true si la voiture existe, false sinon.
    public function charger(int|string $id): bool {
        $data = $this->selectIdAvecCategorie($id);
        if($data == false){
            return false;
        }
        $this->setProp($data['id'], $data['marque'], $data['modele'], $data['annee'], $data['prix_jour'], $data['categorie_id'], $data['categorie']);
        return true;
    }

    // Calcule le prix d'une location selon le nombre de jours.
    public function calculerPrix(int $jours): float {
        return $this->prixJour * $jours;
    }

    // Retourne toutes les voitures avec le nom de leur catégorie.
    public function selectAvecCategorie(): array {
        $sql = "SELECT voiture.*, categorie.nom AS categorie
                FROM $this->table
                INNER JOIN categorie ON voiture.categorie_id = categorie.id
                ORDER BY voiture.marque, voiture.modele";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    // Retourne une voiture avec le nom de sa catégorie, ou false si elle n'existe pas.
    public function selectIdAvecCategorie(int|string $id): bool|array {
        $sql = "SELECT voiture.*, categorie.nom AS categorie
                FROM $this->table
                INNER JOIN categorie ON voiture.categorie_id = categorie.id
                WHERE voiture.id = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        }
    }

    // Vérifie si une voiture a des locations. Retourne true si elle en a au moins une.
    public function aDesLocations(int|string $id): bool {
        $sql = "SELECT COUNT(*) FROM location WHERE voiture_id = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Supprime une voiture seulement si elle n'a pas de locations.
    // Retourne true si la voiture a été supprimée, false sinon.
    public function supprimer(int|string $id): bool {
        if($this->aDesLocations($id)){
            return false;
        }
        return $this->delete($this->table, $id);
    }
}