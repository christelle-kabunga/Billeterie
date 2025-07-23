<?php
require_once(__DIR__ . '/../../connexion/connexion.php');
require_once(__DIR__ . '/../classes/Activite.php');

class ActiviteController {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAll() {
        $stmt = $this->connexion->query("SELECT * FROM activite ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function ajouter(Activite $a) {
    $sql = "INSERT INTO activite (titre, type, date, lieu, photo, prix) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->connexion->prepare($sql);
    return $stmt->execute([$a->titre, $a->type, $a->date, $a->lieu, $a->photo, $a->prix]);
}

public function modifier(Activite $a) {
    $sql = "UPDATE activite SET titre = ?, type = ?, date = ?, lieu = ?, photo = ?, prix=? WHERE id = ?";
    $stmt = $this->connexion->prepare($sql);
    return $stmt->execute([$a->titre, $a->type, $a->date, $a->lieu, $a->photo,$a->prix, $a->id]);
}
    public function getById($id) {
        $stmt = $this->connexion->prepare("SELECT * FROM activite WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function supprimer($id) {
        $stmt = $this->connexion->prepare("DELETE FROM activite WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
