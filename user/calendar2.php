<!DOCTYPE html>
<html>
<head>
  <title>Week Calendar</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    var timeSlotsContainer = document.getElementById("time-slots");
    var currentDate = new Date();

    // Display the current week initially
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

    // Create time slots for each hour of the week
    function createWeekSlots(startDate) {
      timeSlotsContainer.innerHTML = "";

      for (var hour = 0; hour < 24; hour++) {
        var timeSlot = document.createElement("div");
        timeSlot.className = "time-slot";
        timeSlot.innerText = formatTime(hour) + " - " + formatTime(hour + 1);
        timeSlotsContainer.appendChild(timeSlot);

        for (var day = 0; day < 7; day++) {
          var dayColumn = document.createElement("div");
          dayColumn.className = "day-column";
          timeSlotsContainer.appendChild(dayColumn);
        }
      }
    }

    function formatDate(date) {
      var day = date.getDate();
      var month = date.getMonth() + 1; // Months are zero-based in JavaScript
      var year = date.getFullYear();

      if (day < 10) {
        day = '0' + day;
      }
      if (month < 10) {
        month = '0' + month;
      }

      return `${year}-${month}-${day}`;
    }

    // Display appointments on the calendar
    function displayAppointments(appointments) {
      appointments.forEach(function(appointment) {
        var appointmentDate = new Date(appointment.date);
        var dayOfWeek = appointmentDate.getDay();
        var hour = parseInt(appointment.time.substring(0, 2)); // Assuming the time is stored in the format "HH:mm:ss"
        var dayColumn = timeSlotsContainer.children[dayOfWeek * 25 + hour + 1];
        var appointmentElement = document.createElement("div");
        appointmentElement.className = "appointment";
        appointmentElement.innerText = appointment.patient_name;
        dayColumn.appendChild(appointmentElement);
      });
    }

    // Fetch appointments for the specified date from the server
    function getAppointments(date) {
      fetch('get_appointments.php?start=' + formatDate(getStartOfWeek(date)) + '&end=' + formatDate(getEndOfWeek(date)))
      .then(function(response) {
        if (!response.ok) {
          throw new Error('HTTP error ' + response.status);
        }
        updateDateRangeDisplay(formatDate(getStartOfWeek(date)), formatDate(getEndOfWeek(date)));
        return response.json();
      })
      .then(function(appointments) {
        displayAppointments(appointments);
      })
      .catch(function(error) {
        console.log('Fetch failed: ', error);
      });
    }

    // Display the week based on the given date
    function displayWeek(date) {
      createWeekSlots(date);

      getAppointments(date)

    }

    function formatTime(hour) {
      return (hour < 10 ? "0" : "") + hour + ":00";
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

    function updateDateRangeDisplay(startDate, endDate) {
      const startDateFormatted = startDate;
      const endDateFormatted = endDate;
      const dateRangeDisplay = document.getElementById('date-range-display');
      dateRangeDisplay.textContent = `${startDateFormatted} - ${endDateFormatted}`;
    }
  });
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="../scripts/hamburger.js"></script>
  <style>

  #calendar {
    width: 800px;
    margin: 20px auto;
    border: 1px solid #ccc;
    padding: 10px;
  }

  .header {
    text-align: center;
    margin-bottom: 10px;
  }

  #time-slots {
    display: grid;
    grid-template-columns: 100px repeat(7, 1fr);
    grid-gap: 10px;
  }

  .day-column {
    border: 1px solid #ccc;
    padding: 10px;
  }

  .appointment {
    background-color: #f2f2f2;
    border-radius: 5px;
    padding: 5px;
    margin-bottom: 5px;
    }</style>
  </head>
  <body>
    <div class="hamburger">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>

    <div class="menu">
      <a href="index.php">Home</a>
      <a href="calendar.php">Calendar</a>
      <a href="settings.php">Settings</a>
      <a href="logout.php">Log Out</a>
    </div>
    <div id="calendar">
      <div class="header">
        <h2>Week Calendar</h2>
        <p id="date-range-display"></p>
        <div class="navigation">
          <button id="prev-week">Previous Week</button>
          <button id="next-week">Next Week</button>
        </div>
      </div>
      <div id="time-slots"></div>
    </div>
  </body>
  </html>
