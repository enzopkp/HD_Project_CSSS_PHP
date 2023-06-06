<?php
session_start();

require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PractitionerRepository.php';
require_once __DIR__ . '/../../Application/DTO/PatientDTO.php';
require_once __DIR__ . '/../../Application/DTO/PractitionerDTO.php';

$databaseManager = new DatabaseManager();
$patientRepository = new PatientRepository($databaseManager);
$practitionerRepository = new PractitionerRepository($databaseManager);

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

if ($_POST) {
    $data = [
        'id' => null,
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];

    if ($_POST['type'] == 'patient') {
        $data['contactInfo'] = $_POST['contactInfo'];
        $data['personalDetails'] = $_POST['personalDetails'];
        $patient = new PatientDTO($data);
        $result = $patientRepository->createPatient($patient);
    } elseif ($_POST['type'] == 'practitioner') {
        $data['personalInfo'] = $_POST['personalInfo'];
        $practitioner = new PractitionerDTO($data);
        $result = $practitionerRepository->createPractitioner($practitioner);
    }

    if ($result) {
        $_SESSION['message'] = "User created successfully!";
    } else {
        $_SESSION['message'] = "There was a problem creating the user. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../scripts/hamburger.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
    <!-- Add your styles here -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userTypeSelect = document.getElementById('userType');
            const patientFields = document.getElementById('patientFields');
            const practitionerFields = document.getElementById('practitionerFields');

            userTypeSelect.addEventListener('change', function() {
            var patientInputs = patientFields.querySelectorAll('input, textarea');
            var practitionerInputs = practitionerFields.querySelectorAll('input, textarea');
            commonFields.style.display = 'block';
            if (this.value == 'patient') {
                patientFields.style.display = 'block';
                practitionerFields.style.display = 'none';

                patientInputs.forEach(function(input) {
                    input.required = true;
                });

                practitionerInputs.forEach(function(input) {
                    input.required = false;
                });

            } else {
                patientFields.style.display = 'none';
                practitionerFields.style.display = 'block';

                patientInputs.forEach(function(input) {
                    input.required = false;
                });

                practitionerInputs.forEach(function(input) {
                    input.required = true;
                });
            }
        });
        });
    </script>
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="container">
        <h1>Create User</h1>
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert">
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php unset($_SESSION['message']); } ?>
        <form method="POST" id="create-user-form">
            <label for="userType">User Type:</label>
            <select id="userType" name="type">
                <option selected disabled>Select a user type</option>
                <option value="patient">Patient</option>
                <option value="practitioner">Practitioner</option>
            </select>
            <div id="commonFields" style="display: none;">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div id="patientFields" style="display: none;">
                <label for="contactInfo">Contact Information:</label>
                <input type="text" name="contactInfo">
                <label for="personalDetails">Personal Details:</label>
                <textarea name="personalDetails"></textarea>
            </div>
            <div id="practitionerFields" style="display: none;">
                <label for="personalInfo">Personal Information:</label>
                <textarea name="personalInfo"></textarea>
            </div>
            <input class="create-appointment" type="submit" value="Create User">
        </form>
    </div>
</body>
</html>
