<?php
require_once 'C:/xampp/htdocs/dele3a/CRUD/config.php'; // Chemin vers config.php
require_once 'C:/xampp/htdocs/dele3a/CRUD/config.php';

class RepondAvisController
{
    // Propriété pour la connexion à la base de données
    private $db;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct()
    {
        $this->db = config::getConnexion();
    }

    // Vérifier si l'avis existe dans la base de données
    public function avisExists($avis_id)
    {
        // Sécuriser en forçant à un entier
        $avis_id = (int)$avis_id;

        // Debug : afficher l'ID de l'avis pour vérifier
        echo "ID de l'avis vérifié : " . htmlspecialchars($avis_id) . "<br>";

        // Préparer la requête
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM avis WHERE id = :avis_id");
        $stmt->bindParam(':avis_id', $avis_id, PDO::PARAM_INT);
        $stmt->execute();

        // Retourner true si trouvé
        return $stmt->fetchColumn() > 0;
    }

    // Méthode pour ajouter une réponse
    public function addReponse($reponseAvis)
    {
        $avis_id = $reponseAvis->getAvisId();

        // Vérifier si l'avis existe
        if (!$this->avisExists($avis_id)) {
            return "L'ID de l'avis spécifié n'existe pas.";
        }

        try {
            // Si l'avis existe, ajouter la réponse
            $sql = "INSERT INTO repond_avis (avis_id, reponse) VALUES (:avis_id, :reponse)";
            $stmt = $this->db->prepare($sql);
            $reponse = $reponseAvis->getReponse(); // attention ici, pas getMessage() !
            $stmt->bindParam(':avis_id', $avis_id, PDO::PARAM_INT);
            $stmt->bindParam(':reponse', $reponse, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Réponse ajoutée avec succès.";
            } else {
                return "Échec de l'ajout de la réponse.";
            }
        } catch (PDOException $e) {
            return "Erreur lors de l'ajout de la réponse : " . $e->getMessage();
        }
    }

    // Méthode pour lister toutes les réponses
    public function getAllReponses()
    {
        try {
            $sql = "SELECT * FROM repond_avis";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Méthode pour supprimer une réponse par son ID
    public function deleteReponseById($id)
    {
        try {
            $sql = "DELETE FROM repond_avis WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Méthode pour mettre à jour une réponse
    public function updateReponse($id, $newReponse)
    {
        try {
            $sql = "UPDATE repond_avis SET reponse = :reponse WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':reponse', $newReponse, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Méthode pour récupérer tous les avis
    public function getAllAvis()
    {
        try {
            $sql = "SELECT * FROM avis";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>
