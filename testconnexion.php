<?php
// Inclure la classe de configuration
require_once 'config.php';

// Utiliser la connexion PDO
$pdo = config::getConnexion();

// Exemple d'exécution d'une requête
try {
    $query = $pdo->query("SELECT * FROM avis");  // Modifier selon vos tables
    while ($row = $query->fetch()) {
        echo "Avis ID: " . $row['avis_id'] . " - Message: " . $row['message'] . "<br>";
    }
} catch (Exception $e) {
    echo "Erreur lors de l'exécution de la requête: " . $e->getMessage();
}
?>
