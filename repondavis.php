<?php
class RepondAvis {
    private $avis_id;
    private $reponse;
    private $db; // Propriété pour la connexion à la base de données

    // Constructeur pour initialiser les propriétés et la connexion
    public function __construct($db, $avis_id = null, $reponse = null) {
        $this->db = $db; // Initialisation de la connexion
        $this->avis_id = $avis_id;
        $this->reponse = $reponse;
    }

    // Getter pour l'ID de l'avis
    public function getAvisId() {
        return $this->avis_id;
    }

    // Setter pour l'ID de l'avis
    public function setAvisId($avis_id) {
        $this->avis_id = $avis_id;
    }

    // Getter pour la réponse
    public function getMessage() {
        return $this->reponse;
    }

    // Setter pour la réponse
    public function setMessage($reponse) {
        $this->reponse = $reponse;
    }

    // Méthode pour enregistrer la réponse dans la base de données
    public function save() {
        if (empty($this->avis_id) || empty($this->reponse)) {
            throw new Exception("L'ID de l'avis et la réponse ne peuvent pas être vides.");
        }

        // Insérer la réponse dans la table repond_avis
        $stmt = $this->db->prepare("INSERT INTO repond_avis (avis_id, reponse) VALUES (?, ?)");
        $stmt->execute([$this->avis_id, $this->reponse]);
    }
}
?>