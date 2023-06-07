<?php
session_start();

require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PractitionerRepository.php';
require_once __DIR__ . '/../../Application/DTO/PatientDTO.php';
require_once __DIR__ . '/../../Application/DTO/PractitionerDTO.php';
require_once __DIR__ . '/../../Application/Services/ValidationService.php';

$errors = [];
$databaseManager = new DatabaseManager();
$validationService = new ValidationService();
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

    $errors[] = $validationService->validateEmail($_POST['email']);
    $errors[] = $validationService->validatePassword($_POST['password']);
    $errors = array_filter($errors);  // remove empty error messages

    $errors = array_filter($errors);
    if (empty($errors)) {
        if ($_POST['type'] == 'patient') {
            $data['contactInfo'] = $_POST['contactInfo'];
            $data['personalDetails'] = $_POST['personalDetails'];
            $patient = new PatientDTO($data);
            $errors[] = $patientRepository->createPatient($patient);
        } elseif ($_POST['type'] == 'practitioner') {
            $data['personalInfo'] = $_POST['personalInfo'];
            $practitioner = new PractitionerDTO($data);
            $errors[] =  $practitionerRepository->createPractitioner($practitioner);
        }
    } else {
        $errors[] = "There was a problem creating the user. Make sure the information is unique.";
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
    <script src="../scripts/create.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="container">
        <h1>Create User</h1>
        <?php
        // Display PHP validation errors
        if (!empty($errors)) {
            echo '<div class="error-message">';
            foreach ($errors as $error) {
                // escape the error message
                echo '<p>' . htmlspecialchars($error, ENT_QUOTES) . '</p>';
            }
            echo '</div>';
        }
        ?>
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
