<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PractitionerRepository.php';

$databaseManager = new DatabaseManager();
$patientRepository = new PatientRepository($databaseManager);
$practitionerRepository = new PractitionerRepository($databaseManager);

$type = isset($_GET['type']) ? $_GET['type'] : null;
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if($type && $id) {
    if($type == 'patient') {
        $userDetails = $patientRepository->getPatientById($id);
    } elseif ($type == 'practitioner') {
        $userDetails = $practitionerRepository->getPractitionerById($id);
    }

    if(isset($userDetails)) {
        echo json_encode($userDetails);
        return;
    }
}

// Return an empty JSON object if no details were found
echo json_encode(new stdClass());
?>
