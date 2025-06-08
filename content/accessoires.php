<?php
require_once(__DIR__.'/../admin/src/php/db/db_pg_connect.php');
require_once(__DIR__.'/../admin/src/php/classes/ProduitsDAO.class.php');

$pdo = connectDB();
$produitsDAO = new ProduitsDAO($pdo);

$accessoires = $produitsDAO->getProduitsParCategorie('accessoire');
?>

<div class="container">
    <h1 class="text-center my-5">Nos accessoires 🪴</h1>

    <div class="row">
        <?php if (empty($accessoires)): ?>
            <p class="text-center">Aucun accessoire trouvée.</p>
        <?php else: ?>
            <?php foreach ($accessoires as $accessoire): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="./admin/assets/images/<?= htmlspecialchars($accessoire['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($accessoire['nom']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($accessoire['nom']) ?></h5>
                            <p class="card-text"><?= number_format($accessoire['prix'], 2, ',', ' ') ?> €</p>
                            <a href="index_.php?page=detail_produit_public.php&id=<?= $accessoire['id'] ?>" class="btn btn-success w-100">Voir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>