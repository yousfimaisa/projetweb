

<?php
require_once __DIR__ . '/../config.php'; // Connexion à la DB
require_once __DIR__ . '/../model/camp.php'; // Modèle

class CampController {

    // Liste toutes les campagnes
    public function listCampagne() {
        $sql = "SELECT * FROM campagne_promotionnelle";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            throw new Exception('Erreur : ' . $e->getMessage());
        }
    }

    // Ajouter une campagne
    public function addCamp($nom_campagne, $description, $promotion_id, $statut = 'actif') {
        // Vérifier si la promotion existe
        $this->checkPromotionExist($promotion_id);
        // Appeler la méthode addCampagne pour insérer les données
        $this->addCampagne($nom_campagne, $description, $promotion_id, $statut);
    }

    // Supprimer une campagne
    public function deleteCampagne($id) {
        $sql = "DELETE FROM campagne_promotionnelle WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('Erreur : ' . $e->getMessage());
        }
    }

    // Mettre à jour une campagne
    public function updateCampagne(Campagne $campagne) {
        $sql = "UPDATE campagne_promotionnelle SET nom_campagne = :nom_campagne, description = :description, 
                promotion_id = :promotion_id, statut = :statut WHERE id = :id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $campagne->getId(), PDO::PARAM_INT);
            $query->bindValue(':nom_campagne', $campagne->getNomCampagne(), PDO::PARAM_STR);
            $query->bindValue(':description', $campagne->getDescription(), PDO::PARAM_STR);
            $query->bindValue(':promotion_id', $campagne->getPromotionId(), PDO::PARAM_INT);
            $query->bindValue(':statut', $campagne->getStatut(), PDO::PARAM_STR);
            $query->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de la campagne : " . $e->getMessage());
        }
    }

    // Récupérer une campagne par ID
    public function getCampagneById($id) {
        $db = Database::getConnection();
        $query = "SELECT * FROM campagne_promotionnelle WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer toutes les promotions pour la liste déroulante
    public function getAllPromotions() {
        $sql = "SELECT id, code_promotion FROM promotions";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Ajouter une campagne
    // Ajouter une campagne
// Ajouter une campagne sans promotion_idpublic 
function addCampagne($nom_campagne, $description, $cd_promotion, $statut = 'actif') {
    $sql = "INSERT INTO campagne_promotionnelle (nom_campagne, description, cd_promotion, statut) 
    VALUES (:nom_campagne, :description, :cd_promotion, :statut)";
$db = config::getConnexion();

try {
$stmt = $db->prepare($sql);
$stmt->bindParam(':nom_campagne', $nom_campagne);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':cd_promotion', $cd_promotion);
$stmt->bindParam(':statut', $statut);
$stmt->execute();
} catch (Exception $e) {
throw new Exception('Erreur lors de l\'ajout de la campagne : ' . $e->getMessage());
}
}



    // Vérifier si la promotion existe
    private function checkPromotionExist($promotion_id) {
        $sql = "SELECT COUNT(*) FROM promotions WHERE id = :promotion_id";
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':promotion_id', $promotion_id);
        $stmt->execute();
        $promotionExists = $stmt->fetchColumn() > 0;

        
    }

    // Liste des campagnes avec jointure
    public function listCampage() {
        $sql = "SELECT 
                    c.id,
                    c.nom_campagne,
                    c.description,
                    c.statut,
                    p.code_promotion AS promotion_code
                FROM 
                    campagne_promotionnelle c
                INNER JOIN 
                    promotions p ON c.promotion_id = p.id";

        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll(); // important : fetchAll() pour récupérer les données
        } catch (Exception $e) {
            throw new Exception('Erreur : ' . $e->getMessage());
        }
    }
}
?>






