<?php
session_start();
require_once('../connexion/connexion.php');
require_once('../models/controllers/ArtisteController.php');

$controller = new ArtisteController($connexion);
$artistes = $controller->getAll();
?>

<?php require_once('style.php'); ?>
<?php require_once('aside.php'); ?>

<main id="main" class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Artistes</h4>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addArtisteModal">
            Ajouter un artiste
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
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Genre</th>
                    <th>Pays</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($artistes as $artiste): ?>
                    <tr>
                        <th><?= $i++ ?></th>
                        <td><?= htmlspecialchars($artiste['nom']) ?></td>
                        <td><?= htmlspecialchars($artiste['prenom']) ?></td>
                        <td><?= htmlspecialchars($artiste['genre']) ?></td>
                        <td><?= htmlspecialchars($artiste['pays']) ?></td>
                        <td>
                            <a href="#" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editArtisteModal<?= $artiste['id'] ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="../models/public/supprimer-artiste.php?id=<?= $artiste['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet artiste ?')">
                                <i class="bi bi-trash3-fill"></i>
                            </a>
                        </td>
                    </tr>
                       <?php endforeach; ?>
                     </tbody>
                </table>
            </div>

                    <!-- Modal Modifier Artiste -->
                    <div class="modal fade" id="editArtisteModal<?= $artiste['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="../models/public/modifier-artiste.php" class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier Artiste</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $artiste['id'] ?>">

                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" value="<?= htmlspecialchars($artiste['nom']) ?>" class="form-control" required>

                                    <label class="form-label mt-2">Prénom</label>
                                    <input type="text" name="prenom" value="<?= htmlspecialchars($artiste['prenom']) ?>" class="form-control" required>

                                    <label class="form-label mt-2">Genre</label>
                                    <select name="genre" class="form-control" required>
                                        <option value="Masculin" <?= $artiste['genre'] == 'Masculin' ? 'selected' : '' ?>>Masculin</option>
                                        <option value="Féminin" <?= $artiste['genre'] == 'Féminin' ? 'selected' : '' ?>>Féminin</option>
                                    </select>

                                    <label class="form-label mt-2">Pays</label>
                                    <input type="text" name="pays" value="<?= htmlspecialchars($artiste['pays']) ?>" class="form-control" required>

                                    <label class="form-label mt-2">Biographie</label>
                                    <textarea name="biographie" class="form-control" rows="3" required><?= htmlspecialchars($artiste['biographie']) ?></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-dark">Modifier</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </tbody>
        </table>
    </div>

    <!-- Modal ajout -->
    <div class="modal fade" id="addArtisteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="../models/public/ajout-artiste.php" method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvel artiste</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" required>

                    <label class="form-label mt-2">Prénom</label>
                    <input type="text" name="prenom" class="form-control" required>

                    <label class="form-label mt-2">Genre</label>
                    <select name="genre" class="form-control" required>
                        <option value="Masculin">Masculin</option>
                        <option value="Féminin">Féminin</option>
                    </select>

                    <label class="form-label mt-2">Pays</label>
                    <input type="text" name="pays" class="form-control" required>

                    <label class="form-label mt-2">Biographie</label>
                    <textarea name="biographie" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once('script.php'); ?>
