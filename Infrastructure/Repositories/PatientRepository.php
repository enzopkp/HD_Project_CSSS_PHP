<?php
require_once '../Data/DatabaseManager.php';

class PatientRepository
{
  private $databaseManager;
  private $connection;

  public function __construct(DatabaseManager $databaseManager)
  {
    $this->databaseManager = $databaseManager;
    $this->connection = $databaseManager->getPdo();
  }

  public function __destruct()
  {
    // Close the database connection when the object is destroyed
    $this->connection->close();
  }

  public function updatePatient($id, $name, $email, $contactInfo, $personalDetails)
  {
    if (!$this->hasPatientById($id)) {
      throw new Exception("Patient with ID $id does not exist.");
    }

    // Prepare the UPDATE query
    $query = "UPDATE Patients SET name=?, email=?, contactInfo=?, personalDetails=? WHERE id=?";
    $statement = $this->connection->prepare($query);
    $statement->bind_param("ssssi", $name, $email, $contactInfo, $personalDetails, $id);
    $statement->execute();

    // Check if the update was successful
    if ($statement->affected_rows === 0) {
      throw new Exception("Failed to update patient with ID: $id");
    }

    // Close the statement
    $statement->close();
  }

  public function deletePatient($id)
  {
    if (!$this->hasPatientById($id)) {
      throw new Exception("Patient with ID $id does not exist.");
    }
    // Prepare the DELETE query
    $query = "DELETE FROM Patients WHERE id=?";
    $statement = $this->connection->prepare($query);
    $statement->bind_param("i", $id);
    $statement->execute();

    // Check if the delete was successful
    if ($statement->affected_rows === 0) {
      throw new Exception("Failed to delete patient with ID: $id");
    }

    // Close the statement
    $statement->close();
  }

  public function hasPatientById($id)
  {
    // Prepare the SELECT query
    $query = "SELECT COUNT(*) FROM Patients WHERE id=?";

    // Prepare the statement
    $statement = $this->connection->prepare($query);

    // Bind the parameter
    $statement->bind_param("i", $id);

    // Execute the statement
    $statement->execute();

    // Get the result
    $statement->bind_result($count);
    $statement->fetch();

    // Close the statement
    $statement->close();

    // Return true if a patient exists with the given ID, false otherwise
    return $count > 0;
  }

  public function createPatient(Patient $patient)
  {
    $name = $patient->getName();
    $email = $patient->getEmail();
    $password = $patient->getPassword();
    $contactInfo = $patient->getContactInfo();
    $personalDetails = $patient->getPersonalDetails();

    if (!$this->hasPatientById($id)) {
      throw new Exception("Patient with ID $id does not exist.");
    }

    // Prepare the INSERT query
    $query = "INSERT INTO Patients (name, email, password, contactInfo, personalDetails) VALUES (?, ?, ?, ?, ?)";
    $statement = $this->connection->prepare($query);
    $hashedPassword = hash('sha256', $password);
    $statement->bind_param("sssss", $name, $email, $hashedPassword, $contactInfo, $personalDetails);
    $statement->execute();

    // Check if the insert was successful
    if ($statement->affected_rows === 0) {
      throw new Exception("Failed to create a new patient");
    }

    // Get the ID of the newly created patient
    $id = $statement->insert_id;
    $statement->close();
    return $id;
  }

  public function getPatientById($id)
  {

    if (!$this->hasPatientById($id)) {
      throw new Exception("Patient with ID $id does not exist.");
    }

    // Prepare the SELECT query
    $query = "SELECT * FROM Patients WHERE id=?";
    $statement = $this->connection->prepare($query);
    $statement->bind_param("i", $id);
    $statement->execute();

    $result = $statement->get_result();
    $patient = $result->fetch_assoc();
    $statement->close();

    return $patient;
  }

  public function getPatientByEmail($email)
  {

    if (!$this->hasPatientByEmail($email)) {
      throw new Exception("Patient with email $email does not exist.");
    }

    // Prepare the SELECT query
    $query = "SELECT * FROM Patients WHERE email=?";
    $statement = $this->connection->prepare($query);
    $statement->bind_param("i", $email);
    $statement->execute();

    $result = $statement->get_result();
    $patient = $result->fetch_assoc();
    $statement->close();

    return $patient;
  }

  private function hasPatientByEmail($email)
  {
    // Prepare the SELECT query
    $query = "SELECT COUNT(*) FROM Patients WHERE email=?";
    $statement = $this->connection->prepare($query);
    $statement->bind_param("s", $email);
    $statement->execute();

    // Get the result
    $statement->bind_result($count);
    $statement->fetch();
    $statement->close();

    // Return true if a patient exists with the given email, false otherwise
    return $count > 0;
  }
}
?>
