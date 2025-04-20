<?php 
class Avis {
    private $numero;
    private $id;
    private $message;
    private $note;

    public function __construct($numero, $id, $message, $note) {
        $this->numero = $numero;
        $this->id = $id;
        $this->message = $message;
        $this->setNote($note); // Utilisation de setNote pour la validation
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getId() {
        return $this->id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getNote() {
        return $this->note;
    }

   public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setNote($note) {
        if ($note < 1 || $note > 5) {
            throw new InvalidArgumentException("La note doit être entre 1 et 5.");
        }
        $this->note = $note;
    }
}
?>