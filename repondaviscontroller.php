<?php
require_once 'C:/final/htdocs/CRUD/config.php';

class RepondAvisController
{
    private $db;

    public function __construct()
    {
        $this->db = config::getConnexion();
    }

    // Vérifier si un avis existe
    public function avisExists(int $avis_id): bool
    {
        try {
            $stmt = $this->db->prepare("SELECT 1 FROM avis WHERE id = :avis_id LIMIT 1");
            $stmt->bindParam(':avis_id', $avis_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch() !== false;
        } catch (PDOException $e) {
            error_log("Erreur SQL (avisExists) : " . $e->getMessage());
            return false;
        }
    }

    // Ajouter une réponse à un avis existant
    public function addReponse($reponseAvis): string
    {
        if (!is_object($reponseAvis)) {
            return "L'objet de réponse est invalide.";
        }

        $avis_id = $reponseAvis->getAvisId();

        if (!$this->avisExists($avis_id)) {
            return "L'ID de l'avis spécifié n'existe pas.";
        }

        try {
            $sql = "INSERT INTO repond_avis (avis_id, reponse) VALUES (:avis_id, :reponse)";
            $stmt = $this->db->prepare($sql);
            $reponse = $reponseAvis->getReponse();
            
            // Afficher les valeurs avant l'exécution de la requête
            echo "Avis ID: " . $avis_id . ", Réponse: " . $reponse;

            $stmt->bindParam(':avis_id', $avis_id, PDO::PARAM_INT);
            $stmt->bindParam(':reponse', $reponse, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Réponse ajoutée avec succès.";
            } else {
                return "Aucune réponse ajoutée.";
            }
        } catch (PDOException $e) {
            // Afficher l'erreur SQL
            return "Erreur lors de l'ajout de la réponse : " . $e->getMessage();
        }
    }

    // Récupérer toutes les réponses
    public function getAllReponses(): array
    {
        try {
            $sql = "SELECT * FROM repond_avis";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur SQL (getAllReponses) : " . $e->getMessage());
            return [];
        }
    }

    // Supprimer une réponse par son ID
    public function deleteReponseById(int $id): bool
    {
        try {
            $sql = "DELETE FROM repond_avis WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur SQL (deleteReponseById) : " . $e->getMessage());
            return false;
        }
    }

    // Mettre à jour une réponse existante
    public function updateReponse(int $id, string $newReponse): bool
    {
        try {
            $sql = "UPDATE repond_avis SET reponse = :reponse WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':reponse', $newReponse, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur SQL (updateReponse) : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer tous les avis
    public function getAllAvis(): array
    {
        try {
            $sql = "SELECT * FROM avis";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur SQL (getAllAvis) : " . $e->getMessage());
            return [];
        }
    }
}
?>
