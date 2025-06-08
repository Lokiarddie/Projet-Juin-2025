
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand" href="index_.php?page=accueil.php">🌿 GreenShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">

            <li class="nav-item"><a class="nav-link" href="index_.php?page=plantes.php">Nos Plantes</a></li>
            <li class="nav-item"><a class="nav-link" href="index_.php?page=accessoires.php">Nos Accessoires</a></li>
            <li class="nav-item"><a class="nav-link" href="index_.php?page=panier.php">🛒 Panier</a></li>
            <?php if (isset($_SESSION['user']) && is_array($_SESSION['user'])): ?>
                <li class="nav-item">
                    <a  class="nav-link" href="admin/index_.php?page=disconnect.php">Déconnexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index_.php?page=mon_compte.php" title="Mon compte">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                </li>



            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="index_.php?page=login.php">Connexion</a>
                </li>
            <?php endif; ?>


        </ul>
    </div>
</nav>