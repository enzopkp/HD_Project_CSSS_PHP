<?php
require '../DTO/Appointment.php';
require '../DTO/Patient.php';
require '../DTO/Practitioner.php';


// Create an array to hold the patient records
// $patients = [
//   new Patient(1, 'John Smith', 'johnsmith@example.com', hash('sha256', 'password1'), '1234567890', 'Male, 35 years old'),
//   new Patient(2, 'Emily Johnson', 'emilyjohnson@example.com', hash('sha256', 'password2'), '0987654321', 'Female, 28 years old'),
//   new Patient(3, 'Michael Brown', 'michaelbrown@example.com', hash('sha256', 'password3'), '9876543210', 'Male, 45 years old'),
//   new Patient(4, 'Sophia Davis', 'sophiadavis@example.com', hash('sha256', 'password4'), '0123456789', 'Female, 31 years old'),
//   new Patient(5, 'William Wilson', 'williamwilson@example.com', hash('sha256', 'password5'), '2345678901', 'Male, 50 years old'),
//   new Patient(6, 'Olivia Anderson', 'oliviaanderson@example.com', hash('sha256', 'password6'), '7654321098', 'Female, 27 years old'),
//   new Patient(7, 'James Thompson', 'jamesthompson@example.com', hash('sha256', 'password7'), '4567890123', 'Male, 40 years old'),
//   new Patient(8, 'Emma Martinez', 'emmamartinez@example.com', hash('sha256', 'password8'), '9012345678', 'Female, 33 years old'),
//   new Patient(9, 'Alexander Adams', 'alexanderadams@example.com', hash('sha256', 'password9'), '6789012345', 'Male, 29 years old'),
//   new Patient(10, 'Ava Clark', 'avaclark@example.com', hash('sha256', 'password10'), '3456789012', 'Female, 36 years old')];
//
// // Create an array to hold the general practitioner records
// $generalPractitioners = [
//     new GeneralPractitioner(NULL, 'Dr. Richard Harris', 'richardharris@example.com', hash('sha256', 'password11'), 'Experienced GP with 15 years in the field.'),
//     new GeneralPractitioner(NULL, 'Dr. Elizabeth Turner', 'elizabethturner@example.com', hash('sha256', 'password12'), 'Specializes in family medicine.'),
//     new GeneralPractitioner(NULL, 'Dr. Christopher Martinez', 'christophermartinez@example.com', hash('sha256', 'password13'), 'Expert in diagnosing complex medical conditions.'),
//     new GeneralPractitioner(NULL, 'Dr. Samantha Baker', 'samanthabaker@example.com', hash('sha256', 'password14'), 'Dedicated to providing compassionate care.'),
//     new GeneralPractitioner(NULL, 'Dr. Benjamin Walker', 'benjaminwalker@example.com', hash('sha256', 'password15'), 'Passionate about promoting overall wellness.'),
//     new GeneralPractitioner(NULL, 'Dr. Victoria Adams', 'victoriaadams@example.com', hash('sha256', 'password16'), 'Practices evidence-based medicine.'),
//     new GeneralPractitioner(NULL, 'Dr. Daniel Cooper', 'danielcooper@example.com', hash('sha256', 'password17'), 'Specializes in geriatric care.'),
//     new GeneralPractitioner(NULL, 'Dr. Emily Wright', 'emilywright@example.com', hash('sha256', 'password18'), 'Focuses on preventive medicine.'),
//     new GeneralPractitioner(NULL, 'Dr. Matthew Hill', 'matthewhill@example.com', hash('sha256', 'password19'), 'Expertise in managing chronic conditions.'),
//     new GeneralPractitioner(NULL, 'Dr. Ava Adams', 'avaadams@example.com', hash('sha256', 'password20'), 'Provides comprehensive primary care services.')
// ];

$appointments = [];
$appointments[] = new Appointment(1, '09:00:00', '2023-06-07', 101, 'Regular check-up', 1, 1);
$appointments[] = new Appointment(2, '10:00:00', '2023-06-08', 102, 'Dental cleaning', 2, 2);
$appointments[] = new Appointment(3, '11:00:00', '2023-06-09', 103, 'Orthopedic consultation', 3, 3);
$appointments[] = new Appointment(4, '14:00:00', '2023-06-10', 104, 'Eye examination', 4, 4);
$appointments[] = new Appointment(5, '15:00:00', '2023-06-11', 105, 'Skin consultation', 5, 5);
$appointments[] = new Appointment(6, '09:00:00', '2023-06-12', 106, 'Psychiatric session', 6, 6);
$appointments[] = new Appointment(7, '10:00:00', '2023-06-13', 107, 'Blood pressure monitoring', 7, 7);
$appointments[] = new Appointment(8, '11:00:00', '2023-06-14', 108, 'Diabetes consultation', 8, 8);
$appointments[] = new Appointment(9, '14:00:00', '2023-06-15', 109, 'Vaccination', 9, 9);
$appointments[] = new Appointment(10, '15:00:00', '2023-06-16', 110, 'Prenatal check-up', 10, 10);
$appointments[] = new Appointment(11, '09:00:00', '2023-06-17', 101, 'Postnatal check-up', 1, 1);
$appointments[] = new Appointment(12, '10:00:00', '2023-06-18', 102, 'Pediatric check-up', 2, 2);
$appointments[] = new Appointment(13, '11:00:00', '2023-06-19', 103, 'Radiology appointment', 3, 3);
$appointments[] = new Appointment(14, '14:00:00', '2023-06-20', 104, 'Nutrition consultation', 4, 4);
$appointments[] = new Appointment(15, '15:00:00', '2023-06-21', 105, 'Psychological counseling', 5, 5);
$appointments[] = new Appointment(16, '09:00:00', '2023-06-22', 106, 'Cardiology appointment', 6, 6);
$appointments[] = new Appointment(17, '10:00:00', '2023-06-23', 107, 'Gastroenterology appointment', 7, 7);
$appointments[] = new Appointment(18, '11:00:00', '2023-06-24', 108, 'Pulmonology consultation', 8, 8);
$appointments[] = new Appointment(19, '14:00:00', '2023-06-25', 109, 'ENT check-up', 9, 9);
$appointments[] = new Appointment(20, '15:00:00', '2023-06-26', 110, 'Neurology consultation', 10, 10);
$appointments[] = new Appointment(21, '09:00:00', '2023-06-27', 101, 'Urology appointment', 1, 1);
$appointments[] = new Appointment(22, '10:00:00', '2023-06-28', 102, 'Nephrology consultation', 2, 2);
$appointments[] = new Appointment(23, '11:00:00', '2023-06-29', 103, 'Dermatology check-up', 3, 3);
$appointments[] = new Appointment(24, '14:00:00', '2023-06-30', 104, 'Endocrinology appointment', 4, 4);
$appointments[] = new Appointment(25, '15:00:00', '2023-06-30', 105, 'Orthopedic follow-up', 5, 5);
$appointments[] = new Appointment(26, '16:00:00', '2023-06-30', 106, 'Hematology appointment', 6, 6);
$appointments[] = new Appointment(27, '17:00:00', '2023-06-30', 107, 'Immunology consultation', 7, 7);
$appointments[] = new Appointment(28, '18:00:00', '2023-06-30', 108, 'Rheumatology appointment', 8, 8);
$appointments[] = new Appointment(29, '19:00:00', '2023-06-30', 109, 'Genetic counseling', 9, 9);
$appointments[] = new Appointment(30, '20:00:00', '2023-06-30', 110, 'Allergy and immunology check-up', 10, 10);
$appointments[] = new Appointment(31, '08:00:00', '2023-06-07', 101, 'Regular check-up', 1, 1);
$appointments[] = new Appointment(32, '12:00:00', '2023-06-08', 102, 'Dental cleaning', 2, 2);
$appointments[] = new Appointment(33, '13:00:00', '2023-06-09', 103, 'Orthopedic consultation', 3, 3);
$appointments[] = new Appointment(34, '16:00:00', '2023-06-10', 104, 'Eye examination', 4, 4);
$appointments[] = new Appointment(35, '08:30:00', '2023-06-11', 105, 'Skin consultation', 5, 5);
$appointments[] = new Appointment(36, '12:30:00', '2023-06-12', 106, 'Psychiatric session', 6, 6);
$appointments[] = new Appointment(37, '13:30:00', '2023-06-13', 107, 'Blood pressure monitoring', 7, 7);
$appointments[] = new Appointment(38, '16:30:00', '2023-06-14', 108, 'Diabetes consultation', 8, 8);
$appointments[] = new Appointment(39, '08:00:00', '2023-06-15', 109, 'Vaccination', 9, 9);
$appointments[] = new Appointment(40, '12:00:00', '2023-06-16', 110, 'Prenatal check-up', 10, 10);
$appointments[] = new Appointment(41, '13:00:00', '2023-06-17', 101, 'Postnatal check-up', 1, 1);
$appointments[] = new Appointment(42, '16:00:00', '2023-06-18', 102, 'Pediatric check-up', 2, 2);
$appointments[] = new Appointment(43, '08:30:00', '2023-06-19', 103, 'Radiology appointment', 3, 3);
$appointments[] = new Appointment(44, '12:30:00', '2023-06-20', 104, 'Nutrition consultation', 4, 4);
$appointments[] = new Appointment(45, '13:30:00', '2023-06-21', 105, 'Psychological counseling', 5, 5);
$appointments[] = new Appointment(46, '16:30:00', '2023-06-22', 106, 'Cardiology appointment', 6, 6);
$appointments[] = new Appointment(47, '08:00:00', '2023-06-23', 107, 'Gastroenterology appointment', 7, 7);
$appointments[] = new Appointment(48, '12:00:00', '2023-06-24', 108, 'Pulmonology consultation', 8, 8);
$appointments[] = new Appointment(49, '13:00:00', '2023-06-25', 109, 'ENT check-up', 9, 9);
$appointments[] = new Appointment(50, '16:00:00', '2023-06-26', 110, 'Neurology consultation', 10, 10);
$appointments[] = new Appointment(51, '08:30:00', '2023-06-27', 101, 'Urology appointment', 1, 1);
$appointments[] = new Appointment(52, '12:30:00', '2023-06-28', 102, 'Nephrology consultation', 2, 2);
$appointments[] = new Appointment(53, '13:30:00', '2023-06-29', 103, 'Dermatology check-up', 3, 3);
$appointments[] = new Appointment(54, '16:30:00', '2023-06-30', 104, 'Endocrinology appointment', 4, 4);
$appointments[] = new Appointment(55, '08:00:00', '2023-06-30', 105, 'Orthopedic follow-up', 5, 5);
$appointments[] = new Appointment(56, '12:00:00', '2023-06-30', 106, 'Hematology appointment', 6, 6);
$appointments[] = new Appointment(57, '13:00:00', '2023-06-30', 107, 'Immunology consultation', 7, 7);
$appointments[] = new Appointment(58, '16:00:00', '2023-06-30', 108, 'Rheumatology appointment', 8, 8);
$appointments[] = new Appointment(59, '08:30:00', '2023-06-30', 109, 'Genetic counseling', 9, 9);
$appointments[] = new Appointment(60, '12:30:00', '2023-06-30', 110, 'Allergy and immunology check-up', 10, 10);



// foreach ($patients as $patient) {
//   $patient->save();
// }
//
// foreach ($generalPractitioners as $gp) {
//     $gp->save();
// }
$i = 0;

foreach ($appointments as $appointment) {

    $appointment->save();
    $i=$i+1;
    echo $i . "<br>";
}

function fetchAllAppointments() {
    global $pdo;

    $sql = "SELECT * FROM Appointments";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$appointments = fetchAllAppointments();


?>
<div class="appointments">
<h2>Upcoming Appointments</h2>

<?php foreach ($appointments as $appointment): ?>
    <div class="appointment">
        <h3><?php echo date('l, F j', strtotime($appointment['date'])); ?></h3>
        <p><?php echo $appointment['description']; ?></p>
    </div>
<?php endforeach; ?>

<a href="calendar.php" class="calendar-link">View Full Calendar</a>
</div>
