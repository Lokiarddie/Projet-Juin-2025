<?php
require_once('src/php/db/db_pg_connect.php');
require_once('src/php/classes/ProduitsDAO.class.php');
require ('src/php/utils/check_connection.php'); // pour s'assurer que l'admin est connecté

$pdo = connectDB();
$produitsDAO = new ProduitsDAO($pdo);

// Récupérer tous les produits
$produits = $produitsDAO->getAllProduits();
?>

<h1 class="text-center mt-5">Liste complète des produits</h1>

<div class="row">
    <?php foreach ($produits as $prod): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="assets/images/<?= htmlspecialchars($prod['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($prod['nom']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($prod['nom']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($prod['categorie']) ?> - <?= number_format($prod['prix'], 2, ',', ' ') ?> €</p>
                    <a href="index_.php?page=detail_produit_admin.php&id=<?= $prod['id'] ?>" class="btn btn-success w-100">Voir</a>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

