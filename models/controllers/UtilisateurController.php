<?php
require_once(__DIR__ . '/../../connexion/connexion.php');
require_once(__DIR__ . '/../classes/Utilisateur.php');

class UtilisateurController {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllUtilisateurs(): array {
        $stmt = $this->connexion->prepare("SELECT * FROM utilisateur ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouter(Utilisateur $u): bool {
        $stmt = $this->connexion->prepare("INSERT INTO utilisateur (noms, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $u->getNoms(),
            $u->getEmail(),
            password_hash($u->getPassword(), PASSWORD_DEFAULT),
            $u->getRole()
        ]);
    }

    public function modifier(Utilisateur $u): bool {
        $stmt = $this->connexion->prepare("UPDATE utilisateur SET noms = ?, email = ?, role = ? WHERE id = ?");
        return $stmt->execute([
            $u->getNoms(),
            $u->getEmail(),
            $u->getRole(),
            $u->getId()
        ]);
    }

    public function supprimer(int $id): bool {
        $stmt = $this->connexion->prepare("SELECT COUNT(*) FROM log_produit WHERE user_id = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['error'] = "Impossible de supprimer : cet utilisateur a des actions enregistrées.";
            return false;
        }

        $stmt = $this->connexion->prepare("DELETE FROM utilisateur WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getById(int $id): ?array {
        $stmt = $this->connexion->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
