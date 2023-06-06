
<?php
class AppointmentDTO {
    public $id;
    public $time;
    public $date;
    public $room;
    public $description;
    public $practitioner;
    public $patient;

    public function __construct($id, $time, $date, $room, $description, $practitioner, $patient) {
        $this->id = $id;
        $this->time = $time;
        $this->date = $date;
        $this->room = $room;
        $this->description = $description;
        $this->practitioner = $practitioner;
        $this->patient = $patient;
    }
}
?>
