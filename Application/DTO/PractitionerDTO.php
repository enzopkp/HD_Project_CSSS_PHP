<?php
class GeneralPractitionerDTO {
    public $id;
    public $name;
    public $email;
    public $password;
    public $personalInfo;

    public function __construct($id, $name, $email, $password, $personalInfo) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->personalInfo = $personalInfo;
    }
}
?>
