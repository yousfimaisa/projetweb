<?php
include_once('../../config.php');
include_once('../../model/Facture.php');

class FactureController {

    private $pdo;

    public function __construct() {
        $this->pdo = config::getConnexion();
    }

    // Ajouter une facture (version simplifiée sans objet)
    public function addFacture($amount, $date_created, $payment_id) {
        $sql = "INSERT INTO factures (amount, date_created, payment_id)
                VALUES (:amount, :date_created, :payment_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'amount' => $amount,
            'date_created' => $date_created,
            'payment_id' => $payment_id
        ]);
    }

    // Modifier une facture
    public function updateFacture($id, $amount, $date_created, $payment_id) {
        $sql = "UPDATE factures 
                SET amount = :amount, date_created = :date_created, payment_id = :payment_id
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'amount' => $amount,
            'date_created' => $date_created,
            'payment_id' => $payment_id,
            'id' => $id
        ]);
    }

    // Supprimer une facture
    public function deleteFacture($id) {
        $sql = "DELETE FROM factures WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    // Récupérer une facture par ID
    public function showFacture($id) {
        $sql = "SELECT * FROM factures WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Liste paginée avec recherche
    public function listFacturesPaginated($search = '', $limit = 5, $offset = 0) {
        if (!empty($search)) {
            $sql = "SELECT * FROM factures WHERE amount LIKE :search LIMIT :limit OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        } else {
            $sql = "SELECT * FROM factures LIMIT :limit OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compter les factures (pour pagination)
    public function countFactures($search = '') {
        if (!empty($search)) {
            $sql = "SELECT COUNT(*) FROM factures WHERE amount LIKE :search";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['search' => "%$search%"]);
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM factures");
        }
        return $stmt->fetchColumn();
    }

    // Méthodes avancées existantes (filtrage par utilisateur)
    public function getFacturesByUser($userId) {
        $sql = "SELECT f.*, p.typec 
                FROM factures f 
                JOIN pays p ON f.payment_id = p.id 
                WHERE p.user_id = :user_id 
                ORDER BY f.date_created DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFacturesByUserWithFilters($userId, $typeCarte, $order, $limit, $offset) {
        $sql = "SELECT f.*, p.typec 
                FROM factures f 
                JOIN pays p ON f.payment_id = p.id 
                WHERE p.user_id = :user_id";

        if (!empty($typeCarte)) {
            $sql .= " AND p.typec = :typec";
        }

        $allowedOrders = ['date_created DESC', 'date_created ASC', 'amount DESC', 'amount ASC'];
        if (!in_array($order, $allowedOrders)) {
            $order = 'date_created DESC';
        }

        $sql .= " ORDER BY $order LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        if (!empty($typeCarte)) {
            $stmt->bindValue(':typec', $typeCarte);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFacturesByUser($userId, $typeCarte) {
        $sql = "SELECT COUNT(*) 
                FROM factures f 
                JOIN pays p ON f.payment_id = p.id 
                WHERE p.user_id = :user_id";

        if (!empty($typeCarte)) {
            $sql .= " AND p.typec = :typec";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        if (!empty($typeCarte)) {
            $stmt->bindValue(':typec', $typeCarte);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
	public function getAllFactures() {
    try {
        $sql = "SELECT * FROM factures ORDER BY date_created DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des factures : " . $e->getMessage();
        return [];
    }
}

}
?>
