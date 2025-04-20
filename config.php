<?php
class Config {
    private static $pdo = null;
    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DBNAME = "covoiturage";

    public static function getConnexion() {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO("mysql:host=" . self::SERVERNAME . ";dbname=" . self::DBNAME,
                                     self::USERNAME,
                                     self::PASSWORD);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                throw new Exception("Erreur connexion DB: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

// Test de connexion (à désactiver en production)
try {
    $pdo = Config::getConnexion();
    echo "✅ Connexion réussie à la base de données !";
} catch (Exception $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
?>
