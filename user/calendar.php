<?php
require_once '../db.php';

$pdo = (new DatabaseConnection())->getPdo();

// Fetch user's appointments
$stmt = $pdo->prepare("SELECT * FROM Appointments WHERE practitioner = :practitioner ORDER BY date, time");
$stmt->execute([
  ':practitioner' => "10", // Replace with the current user's ID
]);
$appointments = $stmt->fetchAll();

// if (count($appointments) > 0) {
//   foreach ($appointments as $appointment) {
//     echo '<div class="card">';
//     echo '<h2>Date: ' . $appointment['date'] . '</h2>';
//     echo '<p>Time: ' . $appointment['time'] . '</p>';
//     echo '<p>Room: ' . $appointment['room'] . '</p>';
//     echo '<p>Description: ' . $appointment['description'] . '</p>';
//     echo '</div>';
//   }
// } else {
//   echo '<p>No appointments found.</p>';
// }
?>


<!DOCTYPE html>
<html>
<head>
  <title>Calendar</title>
  <link href="https://fullcalendar.io/releases/main/base.css" rel="stylesheet" />
  <link href="https://fullcalendar.io/releases/main/daygrid/main.css" rel="stylesheet" />
  <script src="https://fullcalendar.io/releases/main/main.min.js"></script>
  <script src="https://fullcalendar.io/releases/main/interaction/main.min.js"></script>
  <script src="https://fullcalendar.io/releases/main/daygrid/main.min.js"></script>
  <script src="../scripts/hamburger.js"></script>
  <!-- Add CSS styles for modern web design elements -->
  <style>
  body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(45deg, #f3ec78, #af4261);
    color: #333;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 10px 20px -10px rgba(0, 0, 0, 0.75);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
  }

  .card {
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

  .card:not(:last-child) {
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
  .calendar td {
    width: 14%;
    height: 100px;
    vertical-align: top;
    border: 1px solid #ccc;
    position: relative;
  }

  .calendar .appointment {
    position: relative;
    margin: 1px;
    padding: 1px;
    background-color: #f9f9f9;
    cursor: pointer;
  }

  .calendar .appointment:hover {
    background-color: #eee;
  }

  /* CSS for the overlay */
  #overlay {
    display: none;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 1000;
  }

  #overlay-content {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    width: 50%;
    max-width: 800px;
    z-index: 1001;
  }
  </style>
</head>
<body>
  <div class="container">
    <h1>My Appointments</h1> </br>

    <table class="calendar">
      <?php
      require_once '../db.php';
      $pdo = (new DatabaseConnection())->getPdo();

      // Fetch user's appointments
      $stmt = $pdo->prepare("SELECT * FROM Appointments WHERE practitioner = :practitioner ORDER BY date, time");
      $stmt->execute([
        ':practitioner' => "10", // Replace with the current user's ID
      ]);
      $appointments = $stmt->fetchAll();

      $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      echo '<tr>';
      foreach ($days as $day) {
        echo "<th>$day</th>";
      }
      echo '</tr>';

      for ($i = 0; $i < 5; $i++) {
        echo '<tr>';
        foreach ($days as $day) {
          echo '<td>';
          foreach ($appointments as $appointment) {
            if (date('l', strtotime($appointment['date'])) == $day) {
              echo "<div class='appointment' data-description='{$appointment['description']}'>";
              echo '<h2>' . $appointment['date'] . '</h2>';
              echo '<p>' . $appointment['time'] . '</p>';
              echo '</div>';
            }
          }
          echo '</td>';
        }
        echo '</tr>';
      }
      ?>
    </table>

    <!-- The overlay and its content -->
    <div id="overlay">
      <div id="overlay-content">
        <h2 id="overlay-title"></h2>
        <p id="overlay-description"></p>
        <button onclick="hideOverlay()">Close</button>
      </div>
    </div>
  </div>

  <script>
  document.querySelectorAll('.appointment').forEach(function(appointment) {
    appointment.addEventListener('click', function() {
      document.getElementById('overlay-title').innerText = appointment.querySelector('h2').innerText;
      document.getElementById('overlay-description').innerText = appointment.dataset.description;
      document.getElementById('overlay').style.display = 'block';
    });
  });

  function hideOverlay() {
    document.getElementById('overlay').style.display = 'none';
  }
  </script>
</body>
</html>
