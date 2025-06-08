<?php
function connectDB() {
    $dsn = "pgsql:host=localhost;dbname=expo;port=5432";
    $user = "postgres";
    $password = "postgres";

    try {
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Gestion des erreurs en exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC  // Résultats en tableaux associatifs
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>
