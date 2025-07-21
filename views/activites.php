<?php
session_start();
require_once('../connexion/connexion.php');
require_once('../models/classes/Activite.php');
require_once('../models/controllers/ActiviteController.php');

$controller = new ActiviteController($connexion);
$activites = $controller->getAll();
?>

<?php require_once('style.php'); ?>
<?php require_once('aside.php'); ?>

<main id="main" class="main">
  
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Activités</h4>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addActiviteModal">
            Ajouter une activité
        </button>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['type'] ?> alert-dismissible fade show text-center" role="alert">
            <?= $_SESSION['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
        <?php unset($_SESSION['msg'], $_SESSION['type']); ?>
    <?php endif; ?>

    <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
        <table class="table table-borderless datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($activites as $a): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($a['titre']) ?></td>
                        <td><?= htmlspecialchars($a['type']) ?></td>
                        <td><?= htmlspecialchars($a['date']) ?></td>
                        <td><?= htmlspecialchars($a['lieu']) ?></td>
                        <td><img src="../uploads/activites/<?= $a['photo'] ?>" alt="Photo activité" width="80"></td>

                        <td>
                            <a href="#" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editActiviteModal<?= $a['id'] ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="../models/supprimer-activite.php?id=<?= $a['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette activité ?')">
                                <i class="bi bi-trash3-fill"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

            <!-- Modal modification -->
        <?php foreach ($activites as $a): ?>
    <div class="modal fade" id="editActiviteModal<?= $a['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="../models/public/modifier-activite.php" method="post" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier activité</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">

                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($a['titre']) ?>" required>

                    <label class="form-label mt-2">Type</label>
                    <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($a['type']) ?>" required>

                    <label class="form-label mt-2">Date</label>
                    <input type="date" name="date" class="form-control" value="<?= $a['date'] ?>" required>

                    <label class="form-label mt-2">Lieu</label>
                    <input type="text" name="lieu" class="form-control" value="<?= htmlspecialchars($a['lieu']) ?>" required>

                    <label class="form-label mt-2">Photo</label>
                    <input type="file" name="photo" class="form-control">
                    <input type="hidden" name="photo_actuelle" value="<?= $a['photo'] ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Modifier</button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach ?>

    <!-- Modal ajout -->
    <div class="modal fade" id="addActiviteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="../models/public/ajout-activite.php" method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle activité</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" class="form-control" required>

                    <label class="form-label mt-2">Type</label>
                    <input type="text" name="type" class="form-control" required>

                    <label class="form-label mt-2">Date</label>
                    <input type="date" name="date" class="form-control" required>

                    <label class="form-label mt-2">Lieu</label>
                    <input type="text" name="lieu" class="form-control" required>
                    <label>Photo :</label>
                    <input type="file" name="photo" accept="image/*">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once('script.php'); ?>