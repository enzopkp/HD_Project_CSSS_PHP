<?php
require_once '../db.php';

$pdo = (new DatabaseConnection())->getPdo();

// Validate the input
if (!isset($_GET['start']) || !isset($_GET['end'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Start and end dates are required']);
    exit;
}

$start = new DateTime($_GET['start']);
$end = new DateTime($_GET['end']);

// Fetch user's appointments
$stmt = $pdo->prepare("SELECT Appointments.id, Appointments.time, Appointments.date, Appointments.room, Appointments.description, Patients.name as patient_name, GeneralPractitioners.name as practitioner_name
FROM Appointments
JOIN Patients ON Appointments.patient = Patients.id
JOIN GeneralPractitioners ON Appointments.practitioner = GeneralPractitioners.id
WHERE Appointments.practitioner = :practitioner AND Appointments.date BETWEEN :start AND :end
ORDER BY Appointments.date, Appointments.time");
$stmt->execute([
    ':practitioner' => "10", // Replace with the current user's ID
    ':start' => $start->format('Y-m-d'),
    ':end' => $end->format('Y-m-d'),
]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the appointments as JSON
header('Content-Type: application/json');
echo json_encode($appointments);

?>
