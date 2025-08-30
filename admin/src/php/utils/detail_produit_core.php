<?php
require_once __DIR__ . '/../db/db_pg_connect.php';
require_once __DIR__ . '/../classes/ProduitsDAO.class.php';
ini_set('display_errors', 0);
error_reporting(E_ALL);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="container mt-5"><div class="alert alert-danger">ID produit invalide.</div></div>';
    exit;
}

$produitsDAO = new ProduitsDAO($cnx);

$id = (int) $_GET['id'];
$produit = $produitsDAO->getProduitById($id);

if (!$produit) {
    echo '<div class="container mt-5"><div class="alert alert-warning">Produit non trouvé.</div></div>';
    exit;
}

$isAdmin = isset($_SESSION['admin']) && is_array($_SESSION['admin']);

?>


<div class="container mt-5">
    <h1 class="mb-4">
        <?php if ($isAdmin): ?>
            <span class="editable"
                  data-champ="nom"
                  data-id="<?= $produit['id_produit'] ?>">
                <?= htmlspecialchars($produit['nom']) ?>
            </span>
        <?php else: ?>
            <?= htmlspecialchars($produit['nom']) ?>
        <?php endif; ?>
    </h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="/TI2/projet_juin/admin/assets/images/<?= htmlspecialchars($produit['image']) ?>"
                 class="img-fluid rounded shadow-sm"
                 alt="<?= htmlspecialchars($produit['nom']) ?>">
        </div>

        <div class="col-md-6">
            <h5 class="text-muted mb-3">Catégorie :
                <?php if ($isAdmin): ?>
                    <span class="editable"
                          data-champ="categorie"
                          data-id="<?= $produit['id_produit'] ?>">
                        <?= htmlspecialchars($produit['categorie']) ?>
                    </span>
                <?php else: ?>
                    <span class="fw-normal"><?= htmlspecialchars($produit['categorie']) ?></span>
                <?php endif; ?>
            </h5>

            <h5 class="text-muted mb-3">Type :
                <?php if ($isAdmin): ?>
                    <span class="editable"
                          data-champ="type"
                          data-id="<?= $produit['id_produit'] ?>">
                        <?= htmlspecialchars($produit['type']) ?>
                    </span>
                <?php else: ?>
                    <span class="fw-normal"><?= htmlspecialchars($produit['type']) ?></span>
                <?php endif; ?>
            </h5>

            <h4 class="text-primary mb-3">
                <?php if ($isAdmin): ?>
                    <span class="editable"
                          data-champ="prix"
                          data-id="<?= $produit['id_produit'] ?>">
                        <?= number_format($produit['prix'], 2, ',', ' ') ?>
                    </span> €
                <?php else: ?>
                    <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                <?php endif; ?>
            </h4>

            <p class="mb-4">
                <?php if ($isAdmin): ?>
                    <span class="editable"
                          data-champ="description"
                          data-id="<?= $produit['id_produit'] ?>">
                        <?= nl2br(htmlspecialchars($produit['description'])) ?>
                    </span>
                <?php else: ?>
                    <?= nl2br(htmlspecialchars($produit['description'])) ?>
                <?php endif; ?>
            </p>

            <p><strong>Stock disponible :</strong>
                <?php if ($isAdmin): ?>
                    <span class="editable"
                          data-champ="quantite_stock"
                          data-id="<?= $produit['id_produit'] ?>">
                        <?= (int)$produit['quantite_stock'] ?>
                    </span>
                <?php else: ?>
                    <?= (int)$produit['quantite_stock'] ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>
