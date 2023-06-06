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

$user = $_SESSION['user'];
$email = $user['email']; // Define email from user session
$patient = $patientRepository->getPatientByEmail($email);

$userFromDb = $patient;

if ($_POST) {
    $data = [
        'id' => $user['id'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => null,
        'contactInfo' => $_POST['contactInfo'],
        'personalDetails' => $_POST['personalDetails']
    ];

    $patient = new PatientDTO($data);
    $patientRepository->updatePatient($patient);
    $userFromDb = $patientRepository->getPatientByEmail($_POST['email']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <script src="../scripts/hamburger.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Pre-fill the form with user's details
            const user = <?php echo json_encode($userFromDb); ?>;
            document.getElementById('name').value = user.name;
            document.getElementById('email').value = user.email;
            document.getElementById('contact-info').value = user.contactInfo;
            document.getElementById('personal-details').value = user.personalDetails;
        });
    </script>
    <style>
        body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(45deg, #f3ec78, #af4261);
  color: #333;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
  padding: 0;
}

.container {
  width: 50%;
  max-width: 70%;
  background: #FFFFFF;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  display: grid;
  grid-gap: 20px;
}

h1 {
  font-size:2.5rem; 
  color: #333;
  text-align: center;
}

.edit-form {
  display: flex;
  flex-direction: column;
  align-items: stretch;
}

.edit-form input,
.edit-form textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

.edit-form button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  margin: 20px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  text-align: center;
}

.edit-form button:hover {
  background-color: #45a049;
}

.alert {
  color: green;
  margin-bottom: 15px;
  text-align: center;
  padding: 10px;
  border-radius: 4px;
  background-color: #f8f8f8;
}

.logout-link {
  display: block;
  text-align: center;
  font-size: 14px;
  color: #666;
  text-decoration: none;
}

.logout-link:hover {
  color: #333;
}

@media (max-width: 800px) {
  .container {
    width: fit-content;
  }

  .edit-form {
    align-items: center;
  }
}
        </style>
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="container">
        <h1>Edit User</h1>
        <?php if ($_POST && !empty($_POST)) { ?>
            <div class="alert">
                User details updated successfully!
            </div>
        <?php } ?>
        <form method="POST" id="edit-form" class="edit-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="contact-info">Contact Info:</label>
        <input type="text" id="contact-info" name="contactInfo">
        
        <label for="personal-details">Personal Details:</label>
        <textarea id="personal-details" name="personalDetails"></textarea>

        <input class="update-user" type="submit" value="Update User">
        </form>
        <a class="logout-link" href="../logout.php">Logout</a>
    </div>
</body>
</html>
