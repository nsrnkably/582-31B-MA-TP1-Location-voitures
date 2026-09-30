<?php
require_once('CRUD.php');

/**
 * Classe Location
 * Hérite de CRUD (qui hérite de PDO) : PDO -> CRUD -> Location
 * Gère la table location : table de liaison de la relation N-N entre client et voiture (un client loue plusieurs voitures, une voiture est louée par plusieurs clients).
 */
class Location extends CRUD {

    // Nom de la table dans la base de données
    private string $table = 'location';

    // Tout est privé ici, on passe par setProp/getProp pour y accéder.
    private int $id;
    private int $clientId;
    private int $voitureId;
    private string $dateDebut;
    private string $dateFin;

    // Constructeur : ouvre la connexion (constructeur de CRUD), puis remplit les infos de la location si on les donne.
    public function __construct(int $id = 0, int $clientId = 0, int $voitureId = 0, string $dateDebut = "", string $dateFin = "")
    {
        parent::__construct();
        $this->setProp($id, $clientId, $voitureId, $dateDebut, $dateFin);
    }

    // Pour remplir les infos de la location.
    public function setProp(int $id, int $clientId, int $voitureId, string $dateDebut, string $dateFin) {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->voitureId = $voitureId;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    // Pour afficher les infos de la location sur la page.
    public function getProp(): string {
        return "Du {$this->dateDebut} au {$this->dateFin}<br>" . "Durée : {$this->calculerJours()} jour(s)";
    }

    // Calcule le nombre de jours entre la date de début et la date de fin.
    public function calculerJours(): int {
        $debut = new DateTime($this->dateDebut);
        $fin = new DateTime($this->dateFin);
        return $debut->diff($fin)->days;
    }

    // Retourne toutes les locations avec le nom du client et la voiture louée.
    public function selectAvecDetails(): array {
        $sql = "SELECT location.*,
                       client.prenom, client.nom,
                       voiture.marque, voiture.modele
                FROM $this->table
                INNER JOIN client ON location.client_id = client.id
                INNER JOIN voiture ON location.voiture_id = voiture.id
                ORDER BY location.date_debut DESC";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
}