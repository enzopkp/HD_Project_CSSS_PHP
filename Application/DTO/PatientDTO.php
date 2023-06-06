
<?php
class PatientDTO {
    public $id;
    public $name;
    public $email;
    public $password;
    public $contactInfo;
    public $personalDetails;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->contactInfo = $data['contactInfo'];
        $this->personalDetails = $data['personalDetails'];
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

    public function getContactInfo() {
        return $this->contactInfo;
    }

    public function setContactInfo($contactInfo) {
        $this->contactInfo = $contactInfo;
    }

    public function getPersonalDetails() {
        return $this->personalDetails;
    }

    public function setPersonalDetails($personalDetails) {
        $this->personalDetails = $personalDetails;
    }
}

?>
