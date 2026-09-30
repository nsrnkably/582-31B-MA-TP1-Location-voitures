<?php
require_once('CRUD.php');

/**
 * Classe Client
 * Hérite de CRUD (qui hérite de PDO) : PDO -> CRUD -> Client
 * Gère la table client.
 */
class Client extends CRUD {

    // Nom de la table dans la base de données
    private string $table = 'client';
 
    // Tout est privé ici, on passe par setProp/getProp pour y accéder.
    private int $id;
    private string $nom;
    private string $prenom;
    private string $courriel;
    private string $telephone;

    // Constructeur : ouvre la connexion (constructeur de CRUD), puis remplit les infos du client si on les donne.
    public function __construct(int $id = 0, string $nom = "", string $prenom = "", string $courriel = "", string $telephone = "")
    {
        parent::__construct();
        $this->setProp($id, $nom, $prenom, $courriel, $telephone);
    }

    // Pour remplir les infos du client.
    public function setProp(int $id, string $nom, string $prenom, string $courriel, string $telephone) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->courriel = $courriel;
        $this->telephone = $telephone;
    }

    // Pour afficher les infos du client sur la page.
    public function getProp(): string {
        return "Nom : {$this->prenom} {$this->nom}<br>" . "Courriel : {$this->courriel}<br>" . "Téléphone : {$this->telephone}";
    }

    // Retourne tous les clients triés par nom de famille.
    public function selectParNom(): array {
        return $this->select($this->table, 'nom');
    }

    // Vérifie si un courriel est déjà utilisé par un autre client (courriel unique).
    // $idExclu : l'id du client qu'on modifie, pour ne pas le compter lui-même.
    public function courrielExiste(string $courriel, int|string $idExclu = 0): bool {
        $sql = "SELECT COUNT(*) FROM $this->table WHERE courriel = :courriel AND id != :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":courriel", $courriel);
        $stmt->bindValue(":id", $idExclu);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Vérifie si un client a des locations. Retourne true s'il en a au moins une.
    public function aDesLocations(int|string $id): bool {
        $sql = "SELECT COUNT(*) FROM location WHERE client_id = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Supprime un client seulement s'il n'a pas de locations.
    // Retourne true si le client a été supprimé, false sinon.
    public function supprimer(int|string $id): bool {
        if($this->aDesLocations($id)){
            return false;
        }
        return $this->delete($this->table, $id);
    }
}