
<?php
class PatientDTO {
    public $id;
    public $name;
    public $email;
    public $password;
    public $contactInfo;
    public $personalDetails;

    public function __construct($id, $name, $email, $password, $contactInfo, $personalDetails) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->contactInfo = $contactInfo;
        $this->personalDetails = $personalDetails;
    }
}
?>
