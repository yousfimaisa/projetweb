<?php
class Facture {
    private $id;
    private $payment_id;
    private $amount;
    private $description;
    private $date_created;

    public function __construct($id = null, $payment_id, $amount, $description, $date_created) {
        $this->id = $id;
        $this->payment_id = $payment_id;
        $this->amount = $amount;
        $this->description = $description;
        $this->date_created = $date_created;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getPaymentId() { return $this->payment_id; }
    public function getAmount() { return $this->amount; }
    public function getDescription() { return $this->description; }
    public function getDateCreated() { return $this->date_created; }

    // Setters si besoin
}
?>
