<?php
require_once __DIR__ . '/../Data/DatabaseManager.php';
require_once __DIR__ . '/../../Application/DTO/AppointmentDTO.php';

class AppointmentRepository
{
    private $databaseManager;
    private $connection;
  
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
        $this->connection = $databaseManager->getPdo();
    }

    public function getUpcomingAppointments($patientId, $date)
    {
        $stmt = $this->connection->prepare('SELECT * FROM Appointments WHERE patient = ? AND date <= ? ORDER BY date, time');
        $stmt->execute([$patientId, $date]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $appointments = [];

        foreach ($results as $row) {
            $appointments[] = new AppointmentDTO($row);
        }

        return $appointments;
    }

    public function createAppointment(AppointmentDTO $appointment)
    {
        $stmt = $this->connection->prepare('INSERT INTO Appointments (time, date, room, description, practitioner, patient) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$appointment->getTime(), $appointment->getDate(), $appointment->getRoom(), $appointment->getDescription(), $appointment->getPractitioner(), $appointment->getPatient()]);
        
        return $this->connection->lastInsertId();
    }

    public function getAppointmentById($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM Appointments WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            return new AppointmentDTO($result);
        }
        
        return null;
    }

    public function getAppointmentByPatient($patientId)
    {
        $stmt = $this->connection->prepare('SELECT * FROM Appointments WHERE patient = ? ORDER BY date ASC');
        $stmt->execute([$patientId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $appointments = [];

        foreach ($results as $row) {
            $appointments[] = new AppointmentDTO($row);
        }

        return $appointments;
    }

    public function getAppointmentByPractitioner($practitionerId)
    {
        $stmt = $this->connection->prepare('SELECT * FROM Appointments WHERE practitioner = ? ORDER BY date ASC');
        $stmt->execute([$practitionerId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $appointments = [];

        foreach ($results as $row) {
            $appointments[] = new AppointmentDTO($row);
        }

        return $appointments;
    }

    public function getAppointmentByUserType($user_id, $start, $end, $userType)
    {
        if ($userType == "Patient") {
            return $this->getAppointmentsByPatientAndDateRange($user_id, $start, $end);
        } else if ($userType == "Practitioner") {
            return $this->getAppointmentsByPractitionerAndDateRange($user_id, $start, $end);
        } else {
            throw new Exception("Invalid user type");
        }
    }

    public function getAppointmentsByPatientAndDateRange($patientId, $start, $end)
    {
        $stmt = $this->connection->prepare('SELECT * FROM Appointments WHERE patient = ? AND date >= ? AND date <= ? ORDER BY date, time');
        $stmt->execute([$patientId, $start->format('Y-m-d'), $end->format('Y-m-d')]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $appointments = [];

        foreach ($results as $row) {
            $appointments[] = new AppointmentDTO($row);
        }

        return $appointments;
    }

    public function getAppointmentsByPractitionerAndDateRange($practitionerId, $start, $end)
    {
        $stmt = $this->connection->prepare('SELECT * FROM Appointments WHERE practitioner = ? AND date >= ? AND date <= ? ORDER BY date, time');
        $stmt->execute([$practitionerId, $start->format('Y-m-d'), $end->format('Y-m-d')]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $appointments = [];

        foreach ($results as $row) {
            $appointments[] = new AppointmentDTO($row);
        }

        return $appointments;
    }

    public function updateAppointment(AppointmentDTO $appointment)
    {
        $stmt = $this->connection->prepare('UPDATE Appointments SET time = ?, date = ?, room = ?, description = ?, practitioner = ?, patient = ? WHERE id = ?');
        $stmt->execute([$appointment->getTime(), $appointment->getDate(), $appointment->getRoom(), $appointment->getDescription(), $appointment->getPractitioner(), $appointment->getPatient(), $appointment->getId()]);
    }

    public function deleteAppointment($id)
    {
        $stmt = $this->connection->prepare('DELETE FROM Appointments WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function hasAppointment($patientId, $date, $time)
    {
        $stmt = $this->connection->prepare('SELECT * FROM Appointments WHERE patient = ? AND date = ? AND time = ?');
        $stmt->execute([$patientId, $date, $time]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result != false;
    }
}
?>
