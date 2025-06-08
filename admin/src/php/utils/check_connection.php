<?php
// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si l'utilisateur admin est connecté
if (!isset($_SESSION['admin'])) {
    // Récupérer la page actuelle demandée
    $currentPage = $_GET['page'] ?? '';

    // Si on n'est pas déjà sur la page d'accueil, on redirige vers l'accueil
    if ($currentPage !== 'accueil.php') {
        header("Location: ./index_.php?page=accueil.php");
        exit; // Toujours arrêter le script après une redirection
    }
}
