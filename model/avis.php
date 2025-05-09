<?php
class Avis {
    private $id;
    private $message;
    private $note;
    private $date; // Ajout du champ date

    public function __construct($id, $message, $note, $date = null) {
        $this->id = $id;
        $this->setMessage($message);
        $this->setNote($note);
        $this->setDate($date ?: date('Y-m-d H:i:s')); // Définit la date actuelle si aucune date n'est fournie
    }

    // Getters et Setters
    public function getId() {
        return $this->id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        if (empty($message)) {
            throw new Exception("Le message ne peut pas être vide.");
        }
        $this->message = $message;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        if ($note < 1 || $note > 5) {
            throw new Exception("La note doit être comprise entre 1 et 5.");
        }
        $this->note = $note;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        // Vous pouvez ajouter des validations sur la date si nécessaire
        $this->date = $date;
    }
}
?>