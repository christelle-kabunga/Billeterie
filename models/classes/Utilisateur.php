<?php
class Utilisateur {
    private $id;
    private $noms;
    private $email;
    private $password;
    private $role;

    public function __construct($noms, $email, $password, $role, $id = null) {
        $this->id = $id;
        $this->noms = $noms;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId() {
        return $this->id;
    }

    public function getNoms() {
        return $this->noms;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNoms($noms) {
        $this->noms = $noms;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setRole($role) {
        $this->role = $role;
    }
}
