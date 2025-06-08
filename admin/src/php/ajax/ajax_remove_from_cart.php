<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produit = isset($_POST['id_produit']) ? (int)$_POST['id_produit'] : 0;

    if ($id_produit > 0 && isset($_SESSION['panier'][$id_produit])) {
        unset($_SESSION['panier'][$id_produit]);
        echo 'success';
    } else {
        echo 'Produit non trouvé dans le panier';
    }
} else {
    echo 'Méthode invalide';
}
