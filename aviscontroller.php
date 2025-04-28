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

    // Méthode pour récupérer tous les avis
    public function listAvis() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM avis";
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
            throw new Exception("L'ID de l'avis est invalide.");
        }

        try {
            $db = config::getConnexion();
            $sql = "DELETE FROM avis WHERE id = :id";
            $req = $db->prepare($sql);
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();

            if ($req->rowCount() == 0) {
                throw new Exception("❌ Aucun avis trouvé avec cet ID.");
            }

            return true; // Suppression réussie
        } catch (PDOException $e) {
            throw new Exception("Erreur BDD lors de la suppression de l'avis : " . $e->getMessage());
        }
    }
    public function getAllAvis() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM avis";
            $req = $db->prepare($sql);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des avis : " . $e->getMessage());
        }
    }
    public function getAllReponses() {
        try {
            // Connexion à la base de données
            $pdo = config::getConnexion();
    
            // Requête pour récupérer toutes les réponses
            $sql = "SELECT * FROM repond_avis";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
    
            // Retourner les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur spécifique
            echo "Erreur de connexion ou de récupération des données : " . $e->getMessage();
            return [];
        }
    }
    
}
?>