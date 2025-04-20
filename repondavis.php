<?php
class RepondAvis {

    private $avis_id;
    private $reponse;

    // Constructeur pour initialiser les propriétés
    public function __construct($avis_id = null, $reponse = null) {
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
}
?>
