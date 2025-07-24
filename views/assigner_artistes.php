<?php
session_start();
require_once('../connexion/connexion.php');
require_once('../models/classes/Activite.php');
require_once('../models/controllers/ActiviteController.php');

$controller = new ActiviteController($connexion);
$activites = $controller->getAll();
$artistes = $connexion->query("SELECT id, nom, prenom FROM artiste ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

// Traitement de l'assignation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $activite_id = intval($_POST['activite_id']);
    $artistes_ids = $_POST['artistes'] ?? [];

    // Supprimer les anciennes associations
    $connexion->prepare("DELETE FROM activite_artiste WHERE activite = ?")->execute([$activite_id]);

    // Réinsérer les nouvelles associations
    $stmt = $connexion->prepare("INSERT INTO activite_artiste (activite, artiste) VALUES (?, ?)");
    foreach ($artistes_ids as $artiste_id) {
        $stmt->execute([$activite_id, intval($artiste_id)]);
    }

    $_SESSION['msg'] = "Artistes assignés avec succès.";
    $_SESSION['type'] = "success";
    header("Location: assigner_artistes.php");
    exit();
}
?>

<?php require_once('style.php'); ?>
<?php require_once('aside.php'); ?>

<main id="main" class="main">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Assigner des artistes à une activité</h4>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['type'] ?> alert-dismissible fade show text-center" role="alert">
            <?= $_SESSION['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
        <?php unset($_SESSION['msg'], $_SESSION['type']); ?>
    <?php endif; ?>

    <div class="card p-4 col-md-8 mx-auto">
        <form method="POST">
            <div class="mb-3">
                <label for="activite" class="form-label">Activité</label>
                <select name="activite_id" id="activite" class="form-select" required>
                    <option value="">-- Choisissez une activité --</option>
                    <?php foreach ($activites as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['titre']) ?> (<?= htmlspecialchars($a['date']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="artistes" class="form-label">Artistes</label>
                <select name="artistes[]" id="artistes" class="form-select" multiple size="8" required>
                    <?php foreach ($artistes as $art): ?>
                        <option value="<?= $art['id'] ?>">
                            <?= htmlspecialchars($art['nom'] . ' ' . $art['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs artistes.</div>
            </div>

            <div class="d-grid">
                <button class="btn btn-dark">Assigner</button>
            </div>
        </form>
    </div>
</main>

<?php require_once('script.php'); ?>
