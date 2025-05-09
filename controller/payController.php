<?php
include_once('../../config.php');
include('../../model/Pay.php');
include_once 'FactureController.php';

class PayController
{
    public function listPay()
    {
        $sql = "SELECT * FROM pays";
        $db = config::getConnexion();
        try {
            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
	
public function addPay(Pay $pay)
{
    $sql = "INSERT INTO pays (typec, cdnumber, drcode, bkcode, securitycode, datee, user_id) 
            VALUES (:typec, :cdnumber, :drcode, :bkcode, :securitycode, :datee, :user_id)";
    
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute([
            'typec' => $pay->getTypec(),
            'cdnumber' => $pay->getCdnumber(),
            'drcode' => $pay->getDrcode(),
            'bkcode' => $pay->getBkcode(),
            'securitycode' => $pay->getSecuritycode(),
            'datee' => $pay->getDatee()->format('Y-m-d'),
            'user_id' => $pay->getUserId()
        ]);

        return $db->lastInsertId(); 
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


    public function deletePay($id)
    {
        $sql = "DELETE FROM pays WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

   

    public function updatePay($id, $typec, $cdnumber, $bkcode, $drcode)
    {
        try {
            $sql = "UPDATE pays SET typec = :typec, cdnumber = :cdnumber, drcode = :drcode, bkcode = :bkcode WHERE id = :id";
            $db = config::getConnexion();
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'typec' => $typec,
                'cdnumber' => $cdnumber,
                'drcode' => $drcode,
                'bkcode' => $bkcode,
                'id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
            return false;
        }
    }

    public function showPay($id)
    {
        $sql = "SELECT * FROM pays WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function listPays($search_title = null)
    {
        $query = "SELECT * FROM pays";
        $db = config::getConnexion();
        
        if ($search_title) {
            $query .= " WHERE typec LIKE :search_title";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':search_title', '%' . $search_title . '%');
        } else {
            $stmt = $db->prepare($query);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	public function listPaysPaginated($search = '', $limit = 5, $offset = 0) {
    $db = config::getConnexion();
    if (!empty($search)) {
        $stmt = $db->prepare("SELECT * FROM pays WHERE typec LIKE :search LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $db->prepare("SELECT * FROM pays LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countPays($search = '') {
    $db = config::getConnexion();
    if (!empty($search)) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM pays WHERE typec LIKE :search");
        $stmt->execute(['search' => "%$search%"]);
    } else {
        $stmt = $db->query("SELECT COUNT(*) FROM pays");
    }
    return $stmt->fetchColumn();
}
}
?>
