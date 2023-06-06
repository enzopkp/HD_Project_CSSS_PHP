<?php
session_start();
$userType = require 'getUserType.php';
?>


<!DOCTYPE html>
<html>
<head>
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
  <script src="../scripts/hamburger.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
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
  overflow-y: auto;
}

.container {
  max-width: 800px;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0px 10px 20px -10px rgba(0, 0, 0, 0.75);
  overflow-y: auto;
}

.calendar {
  width: 100%;
  border-collapse: collapse;
}

.calendar th {
  text-align: center;
  padding: 10px;
  background-color: #af4261;
  color: #ffffff;
}

.calendar td {
  height: 100px;
  border: 1px solid #ccc;
  vertical-align: top;
  padding: 10px;
  box-sizing: border-box;
  overflow: hidden;
}

.appointment {
  margin-bottom: 5px;
  padding: 5px;
  background-color: #f3ec78;
  border-radius: 3px;
}

/* CSS for the overlay */
#overlay {
  display: none;
  position: fixed;
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
  width: 60%;
  max-width: 800px;
  border-radius: 5px;
  box-shadow: 0px 10px 20px -10px rgba(0, 0, 0, 0.75);
  z-index: 1001;
}

#overlay-content h2, #overlay-content p {
  margin: 0;
}

#overlay-content button {
  display: block;
  margin-top: 20px;
  padding: 10px;
  background-color: #af4261;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.overlay-appointment {
  margin-bottom: 10px;
  cursor: pointer;
}
  </style>
</head>
<body>
<?php 
if($userType=="Patient"){
  include '../user/menu.php';
} else{
  include '../admin/menu.php';
} ?>

  <div class="container">
    <h1>My Appointments</h1> </br>
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <button class="prev-week" id="prev-week">&laquo; Previous week</button>
    <h2 id="date-range-display"></h2>
    <button class="next-week" id="next-week">Next week &raquo;</button>
</div>

    <table class="calendar">
<?php
  $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
  echo '<tr>';
  foreach ($days as $day) {
    echo "<th>$day</th>";
  }
  echo '</tr>';

  for ($i = 0; $i < 5; $i++) {
    echo '<tr>';
    foreach ($days as $day) {
      echo '<td class="'.$day.'">';
      echo '</td>';
    }
    echo '</tr>';
  }
?>
</table>

    <!-- The overlay and its content -->
    <div id="overlay">
      <div id="overlay-content">
        <div id="appointment-list"></div>
        <div id="appointment-details">
          <h2 id="overlay-title"></h2>
          <p id="overlay-description"></p>
        </div>
        <button onclick="hideOverlay()">Close</button>
      </div>
    </div>
  </div>

  <script>
    
 document.addEventListener("DOMContentLoaded", function() {
  var userType = '<?php echo $userType; ?>';
  var currentDate = new Date();
  displayWeek(currentDate);

  // Button event listeners
  document.getElementById("prev-week").addEventListener("click", function() {
    currentDate.setDate(currentDate.getDate() - 7);
    displayWeek(currentDate);
  });

  document.getElementById("next-week").addEventListener("click", function() {
    currentDate.setDate(currentDate.getDate() + 7);
    displayWeek(currentDate);
  });

  // Display the week based on the given date
  function displayWeek(date) {
    fetchAppointments(date);
  }

  // Fetch appointments for the specified date from the server
  function fetchAppointments(date) {
    fetch('get_appointments.php?start=' + formatDate(getStartOfWeek(date)) + '&end=' + formatDate(getEndOfWeek(date)) + '&userType=' + userType)
    .then(function(response) {
      if (!response.ok) {
        throw new Error('HTTP error ' + response.status);
      }
      updateDateRangeDisplay(formatDate(getStartOfWeek(date)), formatDate(getEndOfWeek(date)));
      return response.json();
    })
    .then(function(appointments) {
      renderAppointments(appointments);
    })
    .catch(function(error) {
      console.log('Fetch failed: ', error);
    });
  }

  // Get the start of the week for a given date
  function getStartOfWeek(date) {
    var startOfWeek = new Date(date);
    var dayOfWeek = startOfWeek.getDay();
    var diff = startOfWeek.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1);
    return new Date(startOfWeek.setDate(diff));
  }

  function getEndOfWeek(date) {
    var endOfWeek = new Date(getStartOfWeek(date));
    endOfWeek.setDate(endOfWeek.getDate() + 6);
    return endOfWeek;
  }

  function formatDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (day < 10) {
      day = '0' + day;
    }
    if (month < 10) {
      month = '0' + month;
    }

    return `${year}-${month}-${day}`;
  }

  function updateDateRangeDisplay(startDate, endDate) {
    const dateRangeDisplay = document.getElementById('date-range-display');
    dateRangeDisplay.textContent = `${startDate} - ${endDate}`;
  }

  function renderAppointments(appointments) {
    var calendarCells = document.querySelectorAll('.calendar td');

    calendarCells.forEach(function(cell) {
      cell.innerHTML = '';
    });

    appointments.forEach(function(appointment) {
      var appointmentDate = new Date(appointment.date);
      var dayOfWeek = appointmentDate.getDay();
      var weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      var weekdayName = weekdays[dayOfWeek];

      var appointmentElement = document.createElement("div");
      appointmentElement.className = 'appointment';
      appointmentElement.dataset.description = appointment.description;
      appointmentElement.innerHTML = '<h2>' + appointment.date + '</h2><p>' + appointment.time + '</p>';

      var cell = document.querySelector('.calendar .' + weekdayName);
      cell.appendChild(appointmentElement);
    });

    // Re-attach click event listeners after rendering appointments
    document.querySelectorAll('.calendar td').forEach(function(cell) {
      cell.addEventListener('click', function() {
        var appointments = Array.from(cell.querySelectorAll('.appointment'));
        if (appointments.length > 0) {
          var listContent = '';
          appointments.forEach(function(appointment) {
            listContent += '<div class="overlay-appointment" onclick="showDetails(this)" data-description="' + appointment.dataset.description + '">' + appointment.querySelector('h2').innerText + '</div>';
          });
          document.getElementById('appointment-list').innerHTML = listContent;
          document.getElementById('overlay').style.display = 'block';
        }
      });
    });


  }
  
});
function hideOverlay() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('overlay-title').innerText = '';
    document.getElementById('overlay-description').innerText = '';
    document.getElementById('appointment-list').innerHTML = '';
  }

  function showDetails(appointment) {
    document.getElementById('overlay-title').innerText = appointment.innerText;
    document.getElementById('overlay-description').innerText = appointment.dataset.description;
  }
  </script>
</body>
</html>
