<?php
session_start();

require_once __DIR__ . '/../../Infrastructure/Data/DatabaseManager.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/PatientRepository.php';
require_once __DIR__ . '/../../Infrastructure/Repositories/AppointmentRepository.php';

$databaseManager = new DatabaseManager();
$patientRepository = new PatientRepository($databaseManager);
$appointmentRepository = new AppointmentRepository($databaseManager);

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}

$user = $_SESSION['user'];
$user_id = $user['id'];

$userPulledFromDb = $patientRepository->getPatientById($user_id);

// Get upcoming appointments for the next week
$oneWeekLater = date('Y-m-d', strtotime('+1 week'));
$appointments = $appointmentRepository->getUpcomingAppointments($user_id, $oneWeekLater);
?>




<!DOCTYPE html>
<html>
<head>
  <title>User Profile</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <style>


  .profile-card, .appointments {
    background: #ffffff;
    border-radius: 5px;
    box-shadow: 0px 10px 20px -10px rgba(0, 0, 0, 0.075);
    padding: 20px;
    margin: 10px;
    width: calc(50% - 20px);
  }

  h2 {
    font-size: 1.5rem;
    color: #af4261;
    margin-bottom: 20px;
  }

  p {
    font-size: 1rem;
    line-height: 1.5;
    color: #333;
    margin-bottom: 10px;
  }

  .appointment:not(:last-child) {
    margin-bottom: 20px;
  }

  .appointments {
    margin-top: 20px;
    padding: 20px;
    border-radius: 5px;
    background-color: #f9f9f9;
  }

  .appointments h2 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
  }

  .appointments .appointment {
    margin-bottom: 10px;
  }

  .appointments .appointment h3 {
    font-size: 20px;
    color: #333;
  }

  .appointments .appointment p {
    font-size: 16px;
    color: #666;
  }

  .calendar-link {
    display: block;
    text-align: center;
    margin-top: 20px;
    font-size: 16px;
    color: #af4261;
    text-decoration: none;
  }
  </style>

  <script src="../scripts/hamburger.js"></script>
</head>
<body>
<?php include 'menu.php'; ?>
  <div class="container">
    <div class="profile-card">
      <h2>Patient Profile</h2>
      <p><strong>Name:</strong> <?php echo $userPulledFromDb['name']; ?></p>
      <p><strong>Email:</strong> <?php echo $userPulledFromDb['email']; ?></p>
      <p><strong>Contact Info:</strong> <?php echo $userPulledFromDb['contactInfo']; ?></p>
      <p><strong>Personal Details:</strong> <?php echo $userPulledFromDb['personalDetails']; ?></p>
    </div>

    <div class="appointments">
    <h2>Upcoming Appointments</h2>

    <?php foreach ($appointments as $appointment): ?>
    <div class="appointment">
        <h3><?php echo date('l, F j', strtotime($appointment->getDate())); ?></h3>
        <p><?php echo $appointment->getDescription(); ?></p>
    </div>
<?php endforeach; ?>

    <a href="calendar.php" class="calendar-link">View Full Calendar</a>
</div>
  </div>
</body>
</html>
