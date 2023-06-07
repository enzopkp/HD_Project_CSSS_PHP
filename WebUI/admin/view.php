<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PractitionerRepository.php';
require_once __DIR__ . '/../../Application/DTO/PatientDTO.php';
require_once __DIR__ . '/../../Application/DTO/PractitionerDTO.php';

$databaseManager = new DatabaseManager();
$patientRepository = new PatientRepository($databaseManager);
$practitionerRepository = new PractitionerRepository($databaseManager);

$patients = $patientRepository->getAllPatients();
$practitioners = $practitionerRepository->getAllPractitioners();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin User Lookup</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../scripts/hamburger.js"></script>
    <script src="../scripts/view.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="container">
        <h1>Admin User Lookup</h1>
        <div id="userDetails"></div>
        <h2>Patients</h2>
        <ul>
            <?php foreach ($patients as $patient) { ?>
                <li><a href="#" onclick="fetchUserDetails('patient', <?php echo $patient->id; ?>)"><?php echo $patient->name; ?></a></li>
            <?php } ?>
        </ul>

        <h2>Practitioners</h2>
        <ul>
            <?php foreach ($practitioners as $practitioner) { ?>
                <li><a href="#" onclick="fetchUserDetails('practitioner', <?php echo $practitioner->id; ?>)"><?php echo $practitioner->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
