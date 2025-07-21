<?php
require_once(__DIR__ . '/../../connexion/connexion.php');
require_once(__DIR__ . '/../classes/Artiste.php');

class ArtisteController {
    private $db;

    public function __construct($connexion) {
        $this->db = $connexion;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM artiste ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouter(Artiste $artiste) {
        $stmt = $this->db->prepare("INSERT INTO artiste (nom, prenom, genre, pays, biographie) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$artiste->nom, $artiste->prenom, $artiste->genre, $artiste->pays, $artiste->biographie]);
    }

    public function modifier(Artiste $artiste) {
        $stmt = $this->db->prepare("UPDATE artiste SET nom = ?, prenom = ?, genre = ?, pays = ?, biographie = ? WHERE id = ?");
        return $stmt->execute([$artiste->nom, $artiste->prenom, $artiste->genre, $artiste->pays, $artiste->biographie, $artiste->id]);
    }

    public function supprimer($id) {
        $stmt = $this->db->prepare("DELETE FROM artiste WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM artiste WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
