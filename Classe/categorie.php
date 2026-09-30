<?php
require_once('CRUD.php');
 
/**
 * Classe Categorie
 * Hérite de CRUD (qui hérite de PDO) : PDO -> CRUD -> Categorie
 * Gère la table categorie (Économique, VUS, Luxe...).
 */
class Categorie extends CRUD {
 
    // Nom de la table dans la base de données
    private string $table = 'categorie';
 
    // Tout est privé ici, on passe par setProp/getProp pour y accéder.
    private int $id;
    private string $nom;
    private string $description;
 
    // Constructeur : ouvre la connexion (constructeur de CRUD), puis remplit les infos de la catégorie si on les donne.
    public function __construct(int $id = 0, string $nom = "", string $description = "")
    {
        parent::__construct();
        $this->setProp($id, $nom, $description);
    }
 
    // Pour remplir les infos de la catégorie.
    public function setProp(int $id, string $nom, string $description) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
    }
 
    // Pour afficher les infos de la catégorie sur la page.
    public function getProp(): string {
        return "Catégorie : {$this->nom}<br>" . "Description : {$this->description}";
    }
 
    // Retourne toutes les catégories triées par nom.
    // Utilisée pour le menu déroulant des formulaires de voiture.
    public function selectParNom(): array {
        return $this->select($this->table, 'nom');
    }
}
 