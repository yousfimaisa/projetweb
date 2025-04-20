<?php
require_once 'config.php'; // Incluez le fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../model/avis.php'; // Chemin correct

class AvisController {
    public function addAvis($avis) {
        $conn = config::getConnexion();
        try {
            $stmt = $conn->prepare("INSERT INTO avis (numero, id, message, note) VALUES (?, ?, ?, ?)");
            $stmt->execute([$avis->getNumero(), $avis->getId(), $avis->getMessage(), $avis->getNote()]);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public function ajoutavis($avis) {
        $conn = config::getConnexion();
        try {
            $stmt = $conn->prepare("INSERT INTO avis (numero, id, message, note) VALUES (?, ?, ?, ?)");
            $stmt->execute([$avis->getNumero(), $avis->getId(), $avis->getMessage(), $avis->getNote()]);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function listAvis() {
        $conn = config::getConnexion();
        try {
            $stmt = $conn->query("SELECT * FROM avis");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function lireavis() {
        $conn = config::getConnexion();
        try {
            $stmt = $conn->query("SELECT * FROM avis");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public function getAvisById($id) {
        $conn = config::getConnexion();
        try {
            $stmt = $conn->prepare("SELECT * FROM avis WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                echo "Aucun résultat trouvé pour l'ID: " . htmlspecialchars($id);
            }

            return $result;
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function updateAvis($numero, $id, $messageContent, $note) {
        $avis = $this->getAvisById($id); // Récupérer l'avis par ID

        if ($avis) {
            // Préparer la requête de mise à jour
            $conn = config::getConnexion();
            try {
                $stmt = $conn->prepare("UPDATE avis SET message = ?, note = ? WHERE numero = ? AND id = ?");
                $stmt->execute([$messageContent, $note, $numero, $id]);
            } catch (PDOException $e) {
                die('Erreur : ' . $e->getMessage());
            }
        } else {
            throw new Exception("Avis non trouvé");
        }
    }
    public function upavis($numero, $id, $messageContent, $note) {
        $avis = $this->getAvisById($id); // Récupérer l'avis par ID

        if ($avis) {
            // Préparer la requête de mise à jour
            $conn = config::getConnexion();
            try {
                $stmt = $conn->prepare("UPDATE avis SET message = ?, note = ? WHERE numero = ? AND id = ?");
                $stmt->execute([$messageContent, $note, $numero, $id]);
            } catch (PDOException $e) {
                die('Erreur : ' . $e->getMessage());
            }
        } else {
            throw new Exception("Avis non trouvé");
        }
    }

    public function deleteAvis($numero, $id) {
        $conn = config::getConnexion();
        
        // Vérifier si l'avis existe d'abord
        $stmt = $conn->prepare("SELECT * FROM avis WHERE numero = :numero AND id = :id");
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // L'avis existe, on peut procéder à la suppression
            $query = "DELETE FROM avis WHERE numero = :numero AND id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':numero', $numero);
            $stmt->bindParam(':id', $id);
    
            return $stmt->execute(); // Retourne true si la suppression réussie
        } else {
            echo "Aucun avis trouvé à supprimer avec le numero: $numero et id: $id";
            return false; // Aucun avis trouvé
        }
    }
    
    public function suppavis($numero, $id) {
        $conn = config::getConnexion();
        $query = "DELETE FROM avis WHERE numero = :numero AND id = :id";
        $stmt = $conn->prepare($query);
    
        // Lier les paramètres
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':id', $id);
    
        // Exécuter la requête
        return $stmt->execute(); // Retourne true si la suppression a réussi
    }
}
?>