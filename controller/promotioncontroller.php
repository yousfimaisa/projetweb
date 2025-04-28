<?php
require_once __DIR__ . '/../config.php'; // Connexion à la DB
require_once __DIR__ . '/../model/promotion.php'; // Modèle

class PromotionController {

    public function listPromotion() {
        $sql = "SELECT * FROM Promotions";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            throw new Exception('Erreur : ' . $e->getMessage());
        }
    }

    public function addPromotion($code_promotion, $date_debut, $date_fin, $valeur) {
        $sql = "INSERT INTO Promotions (code_promotion, date_debut, date_fin, valeur) 
                VALUES (:code_promotion, :date_debut, :date_fin, :valeur)";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':code_promotion', $code_promotion);
            $stmt->bindParam(':date_debut', $date_debut);
            $stmt->bindParam(':date_fin', $date_fin);
            $stmt->bindParam(':valeur', $valeur);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('Erreur : ' . $e->getMessage());
        }
    }

    public function deletePromotion($id) {
        $sql = "DELETE FROM Promotions WHERE id = :id";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('Erreur : ' . $e->getMessage());
        }
    }

    public function updatePromotion(Promotion $promotion) {
        $sql = "UPDATE promotions SET code_promotion = :code, date_debut = :date_debut, date_fin = :date_fin, valeur = :valeur WHERE id = :id";
        $db = config::getConnexion();
        
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $promotion->getId(), PDO::PARAM_INT);
            $query->bindValue(':code', $promotion->getCodePromotion(), PDO::PARAM_STR);
            $query->bindValue(':date_debut', $promotion->getDateDebut(), PDO::PARAM_STR);
            $query->bindValue(':date_fin', $promotion->getDateFin(), PDO::PARAM_STR);
            $query->bindValue(':valeur', $promotion->getValeur(), PDO::PARAM_STR);
            $query->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de la promotion : " . $e->getMessage());
        }
    }

    public function getPromotionById($id) {
        $sql = "SELECT * FROM Promotions WHERE id = :id";
        $db = config::getConnexion();

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $promotion = $stmt->fetch(PDO::FETCH_ASSOC);
            return $promotion;
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
    public function getAllPromotions() {
        $sql = "SELECT code_promotion FROM promotions";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    


}
?>
