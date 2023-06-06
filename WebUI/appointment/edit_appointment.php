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
$today = date("Y-m-d");


if ($_POST) {
    $data = [
        'id' => $_POST['id'],
        'time' => $_POST['time'],
        'date' => $_POST['date'],
        'room' => $_POST['room'],
        'description' => $_POST['description'],
        'practitioner' => $_POST['practitioner'],
        'patient' => $patientId
    ];

    $appointment = new AppointmentDTO($data);
    $appointmentRepository->updateAppointment($appointment);
}
$appointments = $appointmentRepository->getAppointmentByPatient($patientId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Appointment</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <script src="../scripts/hamburger.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Pre-fill the form with appointment's details
            const appointments = <?php echo json_encode($appointments); ?>;
            const appointmentSelect = document.getElementById('appointment-select');

            appointmentSelect.addEventListener('change', function() {
                const selectedAppointment = appointments.find(appointment => appointment.id == appointmentSelect.value);
                
                document.getElementById('time').value = selectedAppointment.time;
                document.getElementById('date').value = selectedAppointment.date;
                document.getElementById('room').value = selectedAppointment.room;
                document.getElementById('description').value = selectedAppointment.description;
                document.getElementById('practitioner').value = selectedAppointment.practitioner;
            });
        });
    </script>
    <!-- Add your styles here -->
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
        <h1>Update Appointment</h1>
        <?php if ($_POST && !empty($_POST)) { ?>
            <div class="alert">
                Appointment details updated successfully!
            </div>
        <?php } ?>
        <form method="POST" id="update-appointment-form" class="edit-form">
        <label for="appointment-select">Select Appointment:</label>
        <select id="appointment-select" name="id">
        <?php foreach ($appointments as $appointment) { ?>
            <option value="<?php echo $appointment->getId(); ?>"><?php echo $appointment->getDate() . " " . $appointment->getTime(); ?></option>
        <?php } ?>
        </select>

        <label for="time">Time:</label>
        <input type="time" id="time" name="time">
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date">

        <label for="room">Room:</label>
        <input type="text" id="room" name="room">
        
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <label for="practitioner">Practitioner:</label>
        <input type="text" id="practitioner" name="practitioner">

        <input class="update-appointment" type="submit" value="Update Appointment">
        </form>
        <a class="logout-link" href="../logout.php">Logout</a>
    </div>
</body>
</html>
