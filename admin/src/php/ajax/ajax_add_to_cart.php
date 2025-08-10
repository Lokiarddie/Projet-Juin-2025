<?php
session_start();
require_once('../db/db_pg_connect.php');
require '../classes/Connection.class.php';
require '../classes/Produits.class.php';
require_once('../classes/ProduitsDAO.class.php');
$cnx = Connection::getInstance($dsn, $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produit = isset($_POST['id_produit']) ? (int)$_POST['id_produit'] : 0;
    $quantite = isset($_POST['quantite']) ? (int)$_POST['quantite'] : 1;

    if ($id_produit > 0 && $quantite > 0) {

        $dao = new ProduitsDAO($cnx);
        $produit = $dao->getProduitById($id_produit);

        if (!$produit) {
            echo "Produit introuvable";
            exit;
        }

        $stock_disponible = (int)$produit['quantite_stock'];
        $quantite_dans_panier = isset($_SESSION['panier'][$id_produit]) ? $_SESSION['panier'][$id_produit] : 0;

        // Vérification
        if ($quantite + $quantite_dans_panier > $stock_disponible) {
            echo "Stock insuffisant. Stock dispo : $stock_disponible, déjà dans panier : $quantite_dans_panier";
            exit;
        }

        // Ajout dans le panier
        $_SESSION['panier'][$id_produit] = $quantite_dans_panier + $quantite;

        echo "success";
    } else {
        echo "Données invalides";
    }
} else {
    echo "Méthode invalide";
}
