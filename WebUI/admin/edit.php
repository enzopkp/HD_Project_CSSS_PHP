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

$patients = $patientRepository->getAllPatients();
$practitioners = $practitionerRepository->getAllPractitioners();
$errors = [];
if (isset($_GET['result']) && $_GET['result'] == 'success') {
    $errors[] = "Successfully updated user details!";
} elseif (isset($_GET['result']) && $_GET['result'] == 'failure') {
    $errors[] = "Failed to update user details!";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin User Lookup</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../scripts/hamburger.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/hamburger.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="container">
        <h1>Admin User Lookup</h1>
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
        <div id="userDetails"></div>
        <h2>Patients</h2>
        <ul>
            <?php foreach ($patients as $patient) { ?>
                <li><a href="#" onclick="fetchUserDetails('patient', <?php echo $patient->id; ?>)"><?php echo $patient->name; ?></a></li>
            <?php } ?>
        </ul>

        <h2>Practitioners</h2>
        <ul>
            <?php foreach ($practitioners as $practitioner) { ?>
                <li><a href="#" onclick="fetchUserDetails('practitioner', <?php echo $practitioner->id; ?>)"><?php echo $practitioner->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <script>
        function fetchUserDetails(type, id) {
        fetch('../../Application/Services/GetUserDetailsService.php?type=' + type + '&id=' + id)
            .then(function(response) {
                console.log(response);
                if (!response.ok) {
                    throw new Error('HTTP error ' + response.status);
                }
                return response.text(); // Get the response as text
            })
            .then(function(responseText) {
                console.log(responseText); // Log the response text
                var userDetails = JSON.parse(responseText); // Attempt to parse the response as JSON
                renderUserDetails(userDetails);
            })
            .catch(function(error) {
                console.log('Fetch failed: ', error);
            });
        }

        function renderUserDetails(userDetails) {
            var userDetailsDiv = document.getElementById('userDetails');
            userDetailsDiv.innerHTML = '';

            var formHTML = '<form id="updateForm" method="post" action="../../Application/Services/UpdateUserDetailsService.php">';

            for (var key in userDetails) {
                formHTML += '<label for="' + key + '">' + key + ':</label>';
                formHTML += '<input type="text" id="' + key + '" name="' + key + '" value="' + userDetails[key] + '"><br>';
            }

            formHTML += '<input type="hidden" name="type" value="' + userDetails.type + '">';
            console.log(userDetails.type);
            formHTML += '<input type="hidden" name="id" value="' + userDetails.id + '">';
            formHTML += '<input type="submit" value="Update">';
            formHTML += '</form>';

            userDetailsDiv.innerHTML += formHTML;
        }
    </script>
</body>
</html>
