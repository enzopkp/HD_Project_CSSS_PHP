<?php
class PractitionerDTO {
    public $id;
    public $name;
    public $email;
    public $password;
    public $personalInfo;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->personalInfo = $data['personalInfo'];
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPersonalInfo() {
        return $this->personalInfo;
    }

    public function setPersonalInfo($personalInfo) {
        $this->personalInfo = $personalInfo;
    }
}
?>
