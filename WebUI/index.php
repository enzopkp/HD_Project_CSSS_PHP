<?php
session_start();
require_once __DIR__ . '/../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../Infrastructure/Repositories/PractitionerRepository.php';
require_once __DIR__ . '/../Infrastructure/Data/DatabaseManager.php';

$databaseManager = new DatabaseManager();
$patientRepository = new PatientRepository($databaseManager);
$practitionerRepository = new PractitionerRepository($databaseManager);

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$email = $user['email']; // Define email from user session

$isPractitioner = null; // Initialize isPractitioner as null
$patient = $patientRepository->getPatientByEmail($email);
$practitioner = $practitionerRepository->getPractitionerByEmail($email);

$isPractitioner = $practitioner ? true : false; // Set isPractitioner to true if practitioner exists, false otherwise
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:400,500,700">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $isPractitioner ? 'Admin' : 'User'; ?> Dashboard</h1>

        <p class="welcome-message">Welcome, <?php echo htmlspecialchars($user['name']); ?></p>

        <div class="action-links">
            <?php 
                if ($isPractitioner) {
                    echo '<a href="admin/create.php">Create User</a>
                    <a href="admin/view_users.php">View Users</a>
                    <a href="admin/update_user.php">Update User</a>
                    <a href="admin/delete_user.php">Delete User</a>';
                } else {
                    echo '<a href="user/view.php">View My Information</a>
                    <a href="user/edit.php">Edit My Information</a>';
                }
            ?>
        </div>

        <div class="action-links">
            <a href="appointment/add_appointment.php">Create Appointment</a>
            <a href="appointment/calendar.php">View Calendar</a>
            <a href="appointment/edit_appointment.php">Update Appointment</a>
            <a href="appointment/delete_appointment.php">Delete Appointment</a>
        </div>

        <a class="logout-link" href="logout.php">Logout</a>
    </div>
</body>
</html>