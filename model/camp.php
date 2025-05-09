<?php
class Camp {
    private $id;
    private $nom_camp;
    private $description;
    private $promotion_id;
    private $statut;

    public function __construct($nom_camp, $description, $promotion_id, $statut = 'actif', $id = null) {
        $this->id = $id;
        $this->nom_camp = $nom_camp;
        $this->description = $description;
        $this->promotion_id = $promotion_id;
        $this->statut = $statut;
    }

    // Récupérer toutes les campagnes (y compris la promotion liée)
    public static function getAll() {
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
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les campagnes sous forme de tableau avec le code_promotion
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNomCamp() {
        return $this->nom_camp;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPromotionId() {
        return $this->promotion_id;
    }

    public function getStatut() {
        return $this->statut;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNomCamp($nom_camp) {
        $this->nom_camp = $nom_camp;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPromotionId($promotion_id) {
        $this->promotion_id = $promotion_id;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }
}
?>
