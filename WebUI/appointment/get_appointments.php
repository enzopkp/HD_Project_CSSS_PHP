<?php
session_start();

require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/AppointmentRepository.php';

$databaseManager = new DatabaseManager();
$appointmentRepository = new AppointmentRepository($databaseManager);

$user = $_SESSION['user'];
$user_id = $user['id'];

if (!isset($_GET['start']) || !isset($_GET['end']) || !isset($_GET['userType'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Start and end dates and userType are required']);
    exit;
}

$start = new DateTime($_GET['start']);
$end = new DateTime($_GET['end']);
$userType = $_GET['userType'];

$appointments = $appointmentRepository->getAppointmentByUserType($user_id, $start, $end, $userType);

header('Content-Type: application/json');
echo json_encode($appointments);
?>
