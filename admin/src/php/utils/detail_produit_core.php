<?php
require_once __DIR__ . '/../db/db_pg_connect.php';
require_once __DIR__ . '/../classes/ProduitsDAO.class.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="container mt-5"><div class="alert alert-danger">ID produit invalide.</div></div>';
    exit;
}

$pdo = connectDB();
$produitsDAO = new ProduitsDAO($pdo);

$id = (int) $_GET['id'];
$produit = $produitsDAO->getProduitById($id);

if (!$produit) {
    echo '<div class="container mt-5"><div class="alert alert-warning">Produit non trouvé.</div></div>';
    exit;
}
?>

<div class="container mt-5">
    <h1 class="mb-4"><?= htmlspecialchars($produit['nom']) ?></h1>
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="/TI2/projet_juin/admin/assets/images/<?= htmlspecialchars($produit['image']) ?>"
                 class="img-fluid rounded shadow-sm"
                 alt="<?= htmlspecialchars($produit['nom']) ?>">
        </div>
        <div class="col-md-6">
            <h5 class="text-muted mb-3">Catégorie : <span class="fw-normal"><?= htmlspecialchars($produit['categorie']) ?></span></h5>
            <h5 class="text-muted mb-3">Type : <span class="fw-normal"><?= htmlspecialchars($produit['type']) ?></span></h5>
            <h4 class="text-primary mb-3"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</h4>
            <p class="mb-4"><?= nl2br(htmlspecialchars($produit['description'])) ?></p>
            <p><strong>Stock disponible :</strong> <?= (int)$produit['quantite_stock'] ?></p>

        </div>
    </div>
</div>

