<?php
include_once('../../config.php');
include_once('../../model/Users.php');
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class UsersController {
    private $db;

    public function __construct() {
        $this->db = config::getConnexion();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? '';
        if ($action == 'register') $this->registerUser();
        if ($action == 'login') $this->loginUser();
        if ($action == 'reset_request') $this->requestReset();
        if ($action == 'reset_password') $this->resetPassword();
    }

     public function registerUser($data) {
        try {
            $sql = "INSERT INTO users (name, email, phone, password, sexe, role, isVerified)
                    VALUES (:name, :email, :phone, :password, :sexe, :role, 0)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'name' => htmlspecialchars($data['name']),
                'email' => htmlspecialchars($data['email']),
                'phone' => htmlspecialchars($data['phone']),
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'sexe' => $data['sexe'],
                'role' => $data['role']
            ]);
            $this->sendVerificationEmail($data['email']);
            return "✅ Registration successful. Check your email.";
        } catch (Exception $e) {
            return "❌ Error: " . $e->getMessage();
        }
    }

public function loginUser($data) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $data['email']]);
    $user = $stmt->fetch();

    if (!$user) {
        return "❌ No account found with this email.";
    }

    if (!password_verify($data['password'], $user['password'])) {
        return "❌ Incorrect password.";
    }

    if (!$user['isVerified']) {
        return "⚠️ Your account is not verified. Please check your email to activate it.";
    }

    // Tout est OK : connexion
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    header("Location: home.php");

}
    private function requestReset() {
        $token = bin2hex(random_bytes(16));
        $stmt = $this->db->prepare("UPDATE users SET reset_password_token = :token WHERE email = :email");
        $stmt->execute(['token' => $token, 'email' => $_POST['email']]);
        $this->sendResetEmail($_POST['email'], $token);
    }

    private function resetPassword() {
        $stmt = $this->db->prepare("UPDATE users SET password = :password, reset_password_token = NULL WHERE reset_password_token = :token");
        $stmt->execute([
            'password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT),
            'token' => $_POST['token']
        ]);
        echo "✅ Password reset successful.";
    }

   private function sendVerificationEmail($email) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'amaltr21@gmail.com';
        $mail->Password = 'gtye laay yhrb sxzp'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('amaltr21@gmail.com', 'Your App');
        $mail->addAddress($email);
        $mail->Subject = 'Activate your account';

        // ➤ Lien simple avec l'email en GET
        $link = "http://localhost/vfcanada/payment/view/Frontoffice/verify.php?email=" . urlencode($email);
        $mail->Body = "Click here to activate your account: $link";

        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}


    private function sendResetEmail($email, $token) {
        $link = "http://localhost/reset_password.php?token=$token";
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'amaltr21@gmail.com';
                              $mail->Password   = 'gtye laay yhrb sxzp'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('amaltr21@gmail.com', 'Your App');
            $mail->addAddress($email);
            $mail->Subject = 'Reset Your Password';
            $mail->Body = "Click this link to reset your password: $link";

            $mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }



public function getUsers($search = '', $role = '') {
    $sql = "SELECT * FROM users WHERE 1";
    $params = [];

    if (!empty($search)) {
        $sql .= " AND (name LIKE :search OR email LIKE :search)";
        $params['search'] = "%$search%";
    }
    if (!empty($role)) {
        $sql .= " AND role = :role";
        $params['role'] = $role;
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

public function addUser($data) {
    $stmt = $this->db->prepare("INSERT INTO users (name, email, phone, role, password, isVerified) VALUES (:name, :email, :phone, :role, :password, 1)");
    $stmt->execute([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'role' => $data['role'],
        'password' => password_hash('default123', PASSWORD_DEFAULT)  // Mot de passe par défaut
    ]);
    return "✅ User added.";
}

public function updateUser($data) {
    $stmt = $this->db->prepare("UPDATE users SET name=:name, email=:email, phone=:phone, role=:role WHERE id=:id");
    $stmt->execute([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'role' => $data['role'],
        'id'   => $data['id']
    ]);
    return "✅ User updated.";
}

public function deleteUser($id) {
    $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return "🗑️ User deleted.";
}

}
$controller = new UsersController();
$controller->handleRequest();

?>
