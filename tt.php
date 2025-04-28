<?php
require_once __DIR__ . '/../../controller/config.php';

try {
    $pdo = Config::getConnexion();
    echo "✅ Connexion réussie à la base de données !";
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>
