<?php
require_once('admin/src/php/db/db_pg_connect.php');
require_once('admin/src/php/classes/CommandeDAO.class.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}


$commandeDAO = new CommandeDAO($cnx);
$clientId = (int)$_SESSION['user']['id'];
$panier = $_SESSION['panier'] ?? [];

if (empty($panier)) {
    die("Le panier est vide.");
}

// Créer la commande
$commandeId = $commandeDAO->createCommande($clientId);

if ($commandeId === 0) {
    die("Erreur lors de la création de la commande.");
}

// Ajouter les produits + mise à jour stock
$success = $commandeDAO->addProduitsToCommande($commandeId, $panier);

if ($success) {
    // Vider le panier
    $_SESSION['panier'] = [];
    header("Location: /TI2/projet_juin/index_.php?page=mon_compte.php&success=1");
    exit;

} else {
    echo "Erreur lors de la validation de la commande.";
}
