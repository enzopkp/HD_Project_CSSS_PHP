
<?php
class AppointmentDTO {
    public $id;
    public $time;
    public $date;
    public $room;
    public $description;
    public $practitioner;
    public $patient;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->time = $data['time'];
        $this->date = $data['date'];
        $this->room = $data['room'];
        $this->description = $data['description'];
        $this->practitioner = $data['practitioner'];
        $this->patient = $data['patient'];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getRoom() {
        return $this->room;
    }

    public function setRoom($room) {
        $this->room = $room;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPractitioner() {
        return $this->practitioner;
    }

    public function setPractitioner($practitioner) {
        $this->practitioner = $practitioner;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function setPatient($patient) {
        $this->patient = $patient;
    }
}
?>
