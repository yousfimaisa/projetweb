<?php
class Promotion {
    private $id;
    private $code_promotion;
    private $date_debut;
    private $date_fin;
    private $valeur;

    public function __construct($code_promotion, $date_debut, $date_fin, $valeur, $id = null) {
        $this->id = $id;
        $this->code_promotion = $code_promotion;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->valeur = $valeur;
    }
    public static function getAll() {
        $sql = "SELECT * FROM promotions"; // Remplace "promotions" par le nom de ta table si nécessaire
        $db = config::getConnexion(); // Assure-toi que tu as une classe `config` pour la connexion DB
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les promotions sous forme de tableau
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    
    public function save() {
        if ($this->id) {
            // Mise à jour
            $sql = "UPDATE promotions SET code_promotion = :code, date_debut = :date_debut, date_fin = :date_fin, valeur = :valeur WHERE id = :id";
        } else {
            // Insertion
            $sql = "INSERT INTO promotions (code_promotion, date_debut, date_fin, valeur) VALUES (:code, :date_debut, :date_fin, :valeur)";
        }

        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':code', $this->getCodePromotion(), PDO::PARAM_STR);
            $stmt->bindValue(':date_debut', $this->getDateDebut(), PDO::PARAM_STR);
            $stmt->bindValue(':date_fin', $this->getDateFin(), PDO::PARAM_STR);
            $stmt->bindValue(':valeur', $this->getValeur(), PDO::PARAM_STR);

            if ($this->id) {
                $stmt->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            }

            $stmt->execute();

            if (!$this->id) {
                $this->setId($db->lastInsertId());
            }

            return true;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la sauvegarde de la promotion : " . $e->getMessage());
        }
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getCodePromotion() {
        return $this->code_promotion;
    }

    public function getDateDebut() {
        return $this->date_debut;
    }

    public function getDateFin() {
        return $this->date_fin;
    }

    public function getValeur() {
        return $this->valeur;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setCodePromotion($code_promotion) {
        $this->code_promotion = $code_promotion;
    }

    public function setDateDebut($date_debut) {
        $this->date_debut = $date_debut;
    }

    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }

    public function setValeur($valeur) {
        $this->valeur = $valeur;
    }
}
?>
