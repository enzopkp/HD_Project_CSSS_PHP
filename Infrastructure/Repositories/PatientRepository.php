<?php
require_once __DIR__ . '/../Data/DatabaseManager.php';
require_once __DIR__ . '/../../Application/DTO/PatientDTO.php';

class PatientRepository
{
  private $databaseManager;
  private $connection;

  public function __construct(DatabaseManager $databaseManager)
  {
    $this->databaseManager = $databaseManager;
    $this->connection = $databaseManager->getPdo();
  }
  
  public function createPatient(PatientDTO $patient)
  {
    if ($this->hasPatientByEmail($patient->getEmail())) {
      return "There already exists a record with this information. Please try again.";
    }
    $name = $patient->getName();
    $email = $patient->getEmail();
    $password = $patient->getPassword();
    $contactInfo = $patient->getContactInfo();
    $personalDetails = $patient->getPersonalDetails();
  
    // Prepare the INSERT query
    $query = "INSERT INTO Patients (name, email, password, contactInfo, personalDetails) VALUES (?, ?, ?, ?, ?)";
    $statement = $this->connection->prepare($query);
    $hashedPassword = hash('sha256', $password);
    $statement->bindParam(1, $name);
    $statement->bindParam(2, $email);
    $statement->bindParam(3, $hashedPassword);
    $statement->bindParam(4, $contactInfo);
    $statement->bindParam(5, $personalDetails);
    $statement->execute();

    // Check if the insert was successful
    if ($statement->rowCount() === 0) {
      return ("Failed to create a new patient");
    }
    
    return "Patient created successfully!";
  }

  public function getAllPatients()
  {
    // Prepare the SELECT query
    $query = "SELECT * FROM Patients";
    $statement = $this->connection->prepare($query);
    $statement->execute();

    // Get the result
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Transform the result into an array of PatientDTO objects
    $patients = [];
    foreach ($result as $row) {
      $patientData = [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'password' => $row['password'],
        'contactInfo' => $row['contactInfo'],
        'personalDetails' => $row['personalDetails'],
      ];
      $patient = new PatientDTO($patientData);
      $patients[] = $patient;
    }

    return $patients;
  }

  public function hasPatientById($id)
  {
    // Prepare the SELECT query
    $query = "SELECT COUNT(*) FROM Patients WHERE id=?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $id);
    $statement->execute();

    // Get the result
    $count = $statement->fetchColumn();

    // Return true if a patient exists with the given ID, false otherwise
    return $count > 0;
  }

  private function hasPatientByEmail($email)
  {
    // Prepare the SELECT query
    $query = "SELECT COUNT(*) FROM Patients WHERE email= ?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $email);
    $statement->execute();

    // Get the result
    $count = $statement->fetchColumn();

    // Return true if a patient exists with the given email, false otherwise
    return $count > 0;
  }

  public function getPatientById($id)
  {
    // Prepare the SELECT query
    $query = "SELECT * FROM Patients WHERE id= ?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $id);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null; // Patient not found
    }

    $patientData = [
      'id' => $row['id'],
      'name' => $row['name'],
      'email' => $row['email'],
      'password' => $row['password'],
      'contactInfo' => $row['contactInfo'],
      'personalDetails' => $row['personalDetails'],
    ];
    $patient = new PatientDTO($patientData);

    return $patient;
  }

  public function getPatientByEmail($email)
  {
    // Prepare the SELECT query
    $query = "SELECT * FROM Patients WHERE email=?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $email);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null; // Patient not found
    }

    $patientData = [
      'id' => $row['id'],
      'name' => $row['name'],
      'email' => $row['email'],
      'password' => $row['password'],
      'contactInfo' => $row['contactInfo'],
      'personalDetails' => $row['personalDetails'],
    ];
    $patient = new PatientDTO($patientData);

    return $patient;
  }

  public function updatePatient(PatientDTO $patient)
  {
    if (!$this->hasPatientByEmail($patient->getEmail())) {
      return "failure";
    }
    // Prepare the UPDATE query
    $query = "UPDATE Patients SET name=?, email=?, contactInfo=?, personalDetails=? WHERE id=?";
    $statement = $this->connection->prepare($query);
    $name = $patient->getName();
    $email = $patient->getEmail();
    $contactInfo = $patient->getContactInfo();
    $personalDetails = $patient->getPersonalDetails();
    $id = $patient->getId();

    $statement->bindParam(1, $name);
    $statement->bindParam(2, $email);
    $statement->bindParam(3, $contactInfo);
    $statement->bindParam(4, $personalDetails);
    $statement->bindParam(5, $id);
    $statement->execute();

    // Check if the update was successful
    if ($statement->rowCount() === 0) {
      return "failure";
    } 
    return "success";
  }

  public function deletePatient($id)
  {
    if (!$this->hasPatientById($id)) {
      return "There are no records matching this information. Please try again.";
    }
    // Prepare the DELETE query
    $query = "DELETE FROM Patients WHERE id=?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $id);
    $statement->execute();

    // Check if the delete was successful
    if ($statement->rowCount() === 0) {
      return ("Failed to delete patient with ID: $id");
    }
    return "Patient deleted successfully!";
  }
}
?>