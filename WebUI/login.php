<?php
session_start();

require_once __DIR__ . '/../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../Application/Services/ValidationService.php';
require_once __DIR__ . '/../Application/Services/UserAuthenticationService.php';
require_once __DIR__ . '/../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../Infrastructure/Repositories/PractitionerRepository.php';

$errors = [];
$databaseManager = new DatabaseManager();
$validationService = new ValidationService();
$userAuthenticationService = new UserAuthenticationService($databaseManager->getPdo());
$patientRepository = new PatientRepository($databaseManager);
$practitionerRepository = new PractitionerRepository($databaseManager);

if ($_POST) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $errors[] = $validationService->validateEmail($email);
    $errors[] = $validationService->validatePassword($password);
    $errors = array_filter($errors);  // remove empty error messages

    if (empty($errors)) {
        $patient = $patientRepository->getPatientByEmail($email);
        $practitioner = $practitionerRepository->getPractitionerByEmail($email);

        if ($patient && $userAuthenticationService->authenticate($email, $password, "Patients")) {
            $_SESSION['user'] = $patient;
            header("Location: index.php");
            exit;
        } elseif ($practitioner && $userAuthenticationService->authenticate($email, $password, "GeneralPractitioners")) {
            $_SESSION['user'] = $practitioner;
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Invalid email or password. Try again";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Login</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:400,500,700">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="scripts/login.js"></script>
</head>
<body>
    <div class="container">
        <h1>Patient Login</h1>
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

        <div id="errorDiv" class="error-message"></div>

        <form id="loginForm" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
