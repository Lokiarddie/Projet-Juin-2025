<?php

class ProduitsDAO {

    private $_bd;
    private $_array = array();

    public function __construct($cnx)
    {
        $this->_bd = $cnx;
    }

    public function getProduitsAleatoires(int $limit = 4): array {
        $query = "SELECT * FROM produits ORDER BY RANDOM() LIMIT :limit";
        try {
            $stmt = $this->_bd->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Echec de la requête : " . $e->getMessage();
            return [];
        }
    }


    public function getProduitsParCategorie(string $type): array {
        $sql = "SELECT * FROM produits WHERE LOWER(type) = LOWER(:type)";
        try {
            $stmt = $this->_bd->prepare($sql);
            $stmt->bindValue(':type', $type, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Échec de la requête : " . $e->getMessage();
            return [];
        }
    }

    public function addProduit($type, $nom, $description, $prix, $image, $categorie, $quantite_stock = 0)
    {
        $query = "INSERT INTO produits (type, nom, description, prix, image, categorie, quantite_stock)
              VALUES (:type, :nom, :description, :prix, :image, :categorie, :quantite_stock)";
        try {
            $stmt = $this->_bd->prepare($query);
            $stmt->bindValue(':type', $type);
            $stmt->bindValue(':nom', $nom);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':prix', $prix);
            $stmt->bindValue(':image', $image);
            $stmt->bindValue(':categorie', $categorie);
            $stmt->bindValue(':quantite_stock', $quantite_stock, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {

            return false;
        }
    }

    public function getCategories()
    {
        $query = "SELECT DISTINCT categorie FROM produits WHERE categorie IS NOT NULL AND categorie <> '' ORDER BY categorie";
        try {
            $stmt = $this->_bd->query($query);
            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $categories; // tableau de catégories (strings)
        } catch (PDOException $e) {

            return [];
        }
    }

    public function getAllProduits()
    {
        $query = "SELECT * FROM produits ORDER BY nom";
        try {
            $stmt = $this->_bd->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getProduitById($id)
    {
        $query = "SELECT * FROM produits WHERE id = :id";
        try {
            $stmt = $this->_bd->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteProduit($id) {
        $sql = "DELETE FROM produits WHERE id = :id";
        try {
            $stmt = $this->_bd->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update_ajax_produit($id, $champ, $valeur) {
        $query = "SELECT update_produit_champ(:id, :champ, :valeur) AS success";
        try {
            $this->_bd->beginTransaction();
            $stmt = $this->_bd->prepare($query);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':champ', $champ, PDO::PARAM_STR);

            // Déterminer le type pour PDO
            if (in_array($champ, ['prix', 'quantite_stock'])) {
                $stmt->bindValue(':valeur', $valeur, PDO::PARAM_STR); // numeric et integer en string pour la fonction PLpgSQL
            } else {
                $stmt->bindValue(':valeur', $valeur, PDO::PARAM_STR);
            }

            $stmt->execute();
            $this->_bd->commit();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return isset($row['success']) && ($row['success'] === 't' || $row['success'] === true);
        } catch (PDOException $e) {
            $this->_bd->rollBack();
            return $e->getMessage();
        }
    }







}

