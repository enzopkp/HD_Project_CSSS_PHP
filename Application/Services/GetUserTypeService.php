<?php
require_once __DIR__ . '/../../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PractitionerRepository.php';
require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';

$databaseManager = new DatabaseManager();
$patientRepository = new PatientRepository($databaseManager);
$practitionerRepository = new PractitionerRepository($databaseManager);

if (!isset($_SESSION['user'])) {
  header("Location: ../login.php");
}

$user = $_SESSION['user'];
$email = $user['email']; // Define email from user session

$patient = $patientRepository->getPatientByEmail($email);
$practitioner = $practitionerRepository->getPractitionerByEmail($email);

$userType = $practitioner ? "Practitioner" : "Patient"; // Set isPractitioner to true if practitioner exists, false otherwise

return $userType;
?>