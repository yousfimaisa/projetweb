<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../model/repondavis.php';

class RepondAvisController {

    // Méthode pour ajouter une réponse
    public function addReponse($reponseAvis) {
        try {
            $pdo = config::getConnexion();
            $sqlCheckAvis = "SELECT COUNT(*) FROM avis WHERE id = :avis_id";
            $stmtCheckAvis = $pdo->prepare($sqlCheckAvis);
            $avis_id = $reponseAvis->getAvisId();
            $stmtCheckAvis->bindParam(':avis_id', $avis_id);
            $stmtCheckAvis->execute();

            $avisExists = $stmtCheckAvis->fetchColumn();
            if ($avisExists == 0) {
                return "L'ID de l'avis spécifié n'existe pas.";
            }

            $sql = "INSERT INTO repond_avis (avis_id, reponse) VALUES (:avis_id, :reponse)";
            $stmt = $pdo->prepare($sql);
            $reponse = $reponseAvis->getMessage();
            $stmt->bindParam(':avis_id', $avis_id);
            $stmt->bindParam(':reponse', $reponse);
            $stmt->execute();

            return "Réponse ajoutée avec succès.";
        } catch (PDOException $e) {
            return "Erreur de connexion à la base de données : " . $e->getMessage();
        } catch (Exception $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    // Méthode pour lister les réponses
    public function getAllReponses() {
        try {
            $pdo = config::getConnexion();
            $sql = "SELECT * FROM repond_avis";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Méthode pour supprimer une réponse
    public function deleteReponseById($id) {
        try {
            $pdo = config::getConnexion();
            $sql = "DELETE FROM repond_avis WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Méthode pour mettre à jour une réponse
    public function updateReponse($id, $newReponse) {
        try {
            $pdo = config::getConnexion();
            $sql = "UPDATE repond_avis SET reponse = :reponse WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':reponse', $newReponse);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    
}
