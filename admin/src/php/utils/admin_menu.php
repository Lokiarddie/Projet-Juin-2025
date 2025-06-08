
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand" href="index_.php?page=accueil_admin.php">🌿 GreenShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index_.php?page=produit.php">Produits</a></li>
            <li class="nav-item"><a class="nav-link" href="index_.php?page=add_produit.php">Ajouter des produits</a></li>

            <?php if (!empty($_SESSION['admin'])): ?>

                <li class="nav-item">
                    <span class="me-2">Admin : <?= htmlspecialchars($_SESSION['admin']['nom_admin']) ?></span>
                    <a href="index_.php?page=disconnect.php" class="nav-link">Déconnexion</a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</nav>
