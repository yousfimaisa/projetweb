<?php
require_once __DIR__ . '/../model/avis.php';
require_once __DIR__ . '/../config.php';

class AvisController {

    // Méthode pour ajouter un avis
    public function ajouterAvis($avis) {
        if (!($avis instanceof Avis)) {
            throw new Exception("❌ Objet invalide fourni à ajouterAvis.");
        }

        $message = $avis->getMessage();
        $note = $avis->getNote();

        try {
            $db = config::getConnexion();
            $sql = "INSERT INTO avis (message, note, date_avis) VALUES (:message, :note, NOW())";
            $req = $db->prepare($sql);
            $req->bindValue(':message', htmlspecialchars($message), PDO::PARAM_STR);
            $req->bindValue(':note', $note, PDO::PARAM_INT);
            $req->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Erreur BDD lors de l'ajout de l'avis : " . $e->getMessage());
        }
    }

    // Méthode pour mettre à jour un avis
    public function updateAvis($avis) {
        if (!($avis instanceof Avis)) {
            throw new Exception("❌ Objet invalide fourni à updateAvis.");
        }

        $message = $avis->getMessage();
        $note = $avis->getNote();

        try {
            $db = config::getConnexion();
            $sql = "UPDATE avis SET message = :message, note = :note WHERE id = :id";
            $req = $db->prepare($sql);
            $req->bindValue(':id', $avis->getId(), PDO::PARAM_INT);
            $req->bindValue(':message', htmlspecialchars($message), PDO::PARAM_STR);
            $req->bindValue(':note', $note, PDO::PARAM_INT);
            $req->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur BDD lors de la mise à jour de l'avis : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer un avis par ID
    public function getAvisById($id) {
        $id = (int) $id;
        if ($id <= 0) {
            throw new Exception("❌ L'ID de l'avis est invalide.");
        }

        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM avis WHERE id = :id";
            $req = $db->prepare($sql);
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur BDD lors de la récupération de l'avis : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer tous les avis avec classification
    public function listAvis() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT *, 
                    CASE 
                        WHEN note <= 2 THEN 'negative'
                        WHEN note >= 4 THEN 'positive'
                        ELSE 'neutral'
                    END as avis_style
                    FROM avis
                    ORDER BY date_avis DESC";
            $req = $db->prepare($sql);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur BDD lors de la récupération des avis : " . $e->getMessage());
        }
    }

    // Méthode pour supprimer un avis par ID
    public function deleteAvis($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("❌ L'ID de l'avis est invalide.");
        }
    
        try {
            $db = config::getConnexion();
            
            // Désactiver temporairement les contraintes de clé étrangère
            $db->exec("SET FOREIGN_KEY_CHECKS = 0");
            
            // Supprimer uniquement de la table avis
            $sql = "DELETE FROM avis WHERE id = :id";
            $req = $db->prepare($sql);
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            
            // Réactiver les contraintes
            $db->exec("SET FOREIGN_KEY_CHECKS = 1");
            
            if ($req->rowCount() == 0) {
                throw new Exception("❌ Aucun avis trouvé avec cet ID.");
            }
    
            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur BDD lors de la suppression de l'avis : " . $e->getMessage());
        }
    }

    // Méthode pour compter les avis négatifs
    public function countNegativeAvis() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT COUNT(*) as count FROM avis WHERE note <= 2";
            $req = $db->prepare($sql);
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC)['count'];
        } catch (PDOException $e) {
            throw new Exception("Erreur BDD lors du comptage des avis négatifs : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer tous les avis (compatibilité)
    public function getAllAvis() {
        return $this->listAvis();
    }

    // Méthode pour récupérer toutes les réponses
    public function getAllReponses() {
        try {
            $pdo = config::getConnexion();
            $sql = "SELECT * FROM repond_avis";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de connexion ou de récupération des données : " . $e->getMessage();
            return [];
        }
    }
}
?>