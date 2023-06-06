<?php
session_start();

require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/AppointmentRepository.php';
require_once __DIR__ . '/../../Application/DTO/AppointmentDTO.php';

$databaseManager = new DatabaseManager();
$appointmentRepository = new AppointmentRepository($databaseManager);

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user = $_SESSION['user'];
$patientId = $user['id']; // Define patientId from user session


if ($_POST && !empty($_POST['appointment'])) {
    $appointmentRepository->deleteAppointment($_POST['appointment']);
}
$appointments = $appointmentRepository->getAppointmentByPatient($patientId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Appointment</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <script src="../scripts/hamburger.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <!-- Add your styles here -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Pre-fill the dropdown with user's appointments
            const appointments = <?php echo json_encode($appointments); ?>;
            const appointmentDropdown = document.getElementById('appointment');
            appointments.forEach(appointment => {
                const option = document.createElement('option');
                option.value = appointment.id;
                option.textContent = `${appointment.date} ${appointment.time} - ${appointment.description}`;
                appointmentDropdown.appendChild(option);
            });
        });
    </script>
</head>
<body>
<?php 
$userType = require 'getUserType.php';
if($userType=="Patient"){
  include '../user/menu.php';
} else{
  include '../admin/menu.php';
} ?>
    <div class="container">
        <h1>Delete Appointment</h1>
        <?php if ($_POST && !empty($_POST['appointment'])) { ?>
            <div class="alert">
                Appointment deleted successfully!
            </div>
        <?php } ?>
        <form method="POST" id="delete-appointment-form" class="delete-form">
        <label for="appointment">Appointment:</label>
        <select id="appointment" name="appointment"></select>
        <input class="delete-appointment" type="submit" value="Delete Appointment">
        </form>
        <a class="logout-link" href="../logout.php">Logout</a>
    </div>
</body>
</html>
