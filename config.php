<?php
class config {
    public static function getConnexion() {
        $host = 'localhost';
        $dbname = 'covoiturage';
        $username = 'root';
        $password = '';
        
        try {
            $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            exit();
        }
    }
}
?>



