<?php
session_start();
require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PractitionerRepository.php';

$databaseManager = new DatabaseManager();
$patientRepository = new PatientRepository($databaseManager);
$practitionerRepository = new PractitionerRepository($databaseManager);

$patients = $patientRepository->getAllPatients();
$practitioners = $practitionerRepository->getAllPractitioners();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    
    if($type && $id) {
        if($type == 'patient') {
            $patientRepository->deletePatient($id);
        } elseif ($type == 'practitioner') {
            $practitionerRepository->deletePractitioner($id);
        }
        header("Location: delete.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
    <link rel="stylesheet" href="your_stylesheet.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../scripts/hamburger.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
    <h1>Delete User</h1>

    <h2>Patients</h2>
    <ul id="patients-list">
        <?php foreach ($patients as $patient) { ?>
            <li><a href="#" onclick="confirmDelete('patient', <?php echo $patient->id; ?>)"><?php echo $patient->name; ?></a></li>
        <?php } ?>
    </ul>

    <h2>Practitioners</h2>
    <ul id="practitioners-list">
        <?php foreach ($practitioners as $practitioner) { ?>
            <li><a href="#" onclick="confirmDelete('practitioner', <?php echo $practitioner->id; ?>)"><?php echo $practitioner->name; ?></a></li>
        <?php } ?>
    </ul>

    <form id="deleteForm" method="post" style="display: none;">
        <input type="hidden" id="typeInput" name="type">
        <input type="hidden" id="idInput" name="id">
    </form>

    <script>
        function confirmDelete(type, id) {
            if(confirm('Are you sure you want to delete this user?')) {
                document.getElementById('typeInput').value = type;
                document.getElementById('idInput').value = id;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</div>
</body>
</html>
