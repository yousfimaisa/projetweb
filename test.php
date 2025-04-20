<php
try {
    $pdo = Config::getConnexion();
    echo "Connexion réussie à la base de données!";
} catch (Exception $e) {
    echo "Erreur de connexion: " . $e->getMessage();
}
?>