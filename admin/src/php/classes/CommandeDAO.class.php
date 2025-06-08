<?php

class CommandeDAO
{
    private $_bd;
    private $_array = array();

    public function __construct($cnx)
    {
        $this->_bd = $cnx;
    }

    // Crée une commande et retourne son ID
    public function createCommande(int $clientId): int {
        $sql = "INSERT INTO commandes (client_id, statut) VALUES (:client_id, 'en attente') RETURNING id";
        $stmt = $this->_bd->prepare($sql);
        $stmt->execute(['client_id' => $clientId]);
        return (int) $stmt->fetchColumn();
    }

    // Ajout des produits liés à une commande + mise à jour stock dans une transaction
    public function addProduitsToCommande(int $commandeId, array $produits): bool {
        try {
            $this->_bd->beginTransaction();

            $insertStmt = $this->_bd->prepare("
                INSERT INTO commandes_produits (commande_id, produit_id, quantite)
                VALUES (:commande_id, :produit_id, :quantite)
            ");

            $updateStockStmt = $this->_bd->prepare("
                UPDATE produits SET quantite_stock = quantite_stock - :quantite WHERE id = :produit_id
            ");

            foreach ($produits as $produitId => $quantite) {
                // Insertion produit-commandé
                $insertStmt->execute([
                    ':commande_id' => $commandeId,
                    ':produit_id' => $produitId,
                    ':quantite' => $quantite
                ]);

                // Mise à jour stock
                $updateStockStmt->execute([
                    ':quantite' => $quantite,
                    ':produit_id' => $produitId
                ]);
            }

            $this->_bd->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    // Récupérer les commandes d’un client avec produits
    public function getCommandesByClientId(int $clientId): array {
        $sql = "SELECT id, date_commande, statut FROM commandes WHERE client_id = :clientId ORDER BY date_commande DESC";
        $stmt = $this->_bd->prepare($sql);
        $stmt->execute(['clientId' => $clientId]);
        $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($commandes as &$commande) {
            $sqlProduits = "
                SELECT p.nom, p.prix, cp.quantite 
                FROM commandes_produits cp
                JOIN produits p ON cp.produit_id = p.id
                WHERE cp.commande_id = :commandeId
            ";
            $stmtProduits = $this->_bd->prepare($sqlProduits);
            $stmtProduits->execute(['commandeId' => $commande['id']]);
            $commande['produits'] = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);
        }
        return $commandes;
    }


}