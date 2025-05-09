<?php
class Users {
    private $id;
    private $name;
    private $email;
    private $phone;
    private $password;
    private $sexe;
    private $role;
    private $isVerified;
    private $reset_password_token;

    // --- Getters & Setters ---
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPhone() { return $this->phone; }
    public function setPhone($phone) { $this->phone = $phone; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function getSexe() { return $this->sexe; }
    public function setSexe($sexe) { $this->sexe = $sexe; }

    public function getRole() { return $this->role; }
    public function setRole($role) { $this->role = $role; }

    public function getIsVerified() { return $this->isVerified; }
    public function setIsVerified($isVerified) { $this->isVerified = $isVerified; }

    public function getResetPasswordToken() { return $this->reset_password_token; }
    public function setResetPasswordToken($token) { $this->reset_password_token = $token; }
}
?>
