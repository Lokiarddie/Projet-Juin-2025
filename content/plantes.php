<?php
require_once(__DIR__.'/../admin/src/php/db/db_pg_connect.php');
require_once(__DIR__.'/../admin/src/php/classes/ProduitsDAO.class.php');

$pdo = connectDB();
$produitsDAO = new ProduitsDAO($pdo);

$plantes = $produitsDAO->getProduitsParCategorie('plante');
?>

<div class="container">
    <h1 class="text-center my-5">Nos plantes 🌱</h1>

    <div class="row">
        <?php if (empty($plantes)): ?>
            <p class="text-center">Aucune plante trouvée.</p>
        <?php else: ?>
            <?php foreach ($plantes as $plante): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="./admin/assets/images/<?= htmlspecialchars($plante['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($plante['nom']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($plante['nom']) ?></h5>
                            <p class="card-text"><?= number_format($plante['prix'], 2, ',', ' ') ?> €</p>
                            <a href="index_.php?page=detail_produit_public.php&id=<?= $plante['id'] ?>" class="btn btn-success w-100">Voir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


