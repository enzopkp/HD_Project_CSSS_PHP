
<?php
require_once  '../db.php';
class Appointment {
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

    public function save() {
        $pdo = (new DatabaseConnection())->getPdo();

        // Check if appointment slot is available before trying to insert
        $stmt = $pdo->prepare("SELECT * FROM Appointments WHERE time = :time AND date = :date AND room = :room");
        $stmt->execute([
            ':time' => $this->time,
            ':date' => $this->date,
            ':room' => $this->room
        ]);
        $existingAppointment = $stmt->fetch();

        if (!$existingAppointment) {
            $sql = "INSERT INTO Appointments (time, date, room, description, practitioner, patient)
                    VALUES (:time, :date, :room, :description, :practitioner, :patient)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    ':time' => $this->time,
                    ':date' => $this->date,
                    ':room' => $this->room,
                    ':description' => $this->description,
                    ':practitioner' => $this->practitioner,
                    ':patient' => $this->patient
                ]);

                $this->id = $pdo->lastInsertId();
                echo "New appointment inserted successfully!";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "This appointment slot is already booked.";
        }
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
