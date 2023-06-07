<?php
require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PractitionerRepository.php';
require_once __DIR__ . '/../../Application/DTO/PatientDTO.php';
require_once __DIR__ . '/../../Application/DTO/PractitionerDTO.php';

$databaseManager = new DatabaseManager();
$patientRepository = new PatientRepository($databaseManager);
$practitionerRepository = new PractitionerRepository($databaseManager);
$result;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $id = $_POST['id'];

    $patient = $patientRepository->getPatientByEmail($email);
    $practitioner = $practitionerRepository->getPractitionerByEmail($email);
    if ($patient) {
        $patientDto = new PatientDTO($_POST);
        $result = $patientRepository->updatePatient($patientDto);
    } else if ($practitioner) {
        $practitionerDto = new PractitionerDTO($_POST);
        $result = $practitionerRepository->updatePractitioner($practitionerDto);
        
    }
}
echo "result + " . $result;
header('Location: ../../WebUI/admin/edit.php?result=' . $result);
exit();
?>
