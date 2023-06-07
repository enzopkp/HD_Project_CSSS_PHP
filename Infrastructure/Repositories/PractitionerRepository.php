<?php
require_once __DIR__ . '/../Data/DatabaseManager.php';
require_once __DIR__ . '/../../Application/DTO/PractitionerDTO.php';

class PractitionerRepository
{
  private $databaseManager;
  private $connection;

  public function __construct(DatabaseManager $databaseManager)
  {
    $this->databaseManager = $databaseManager;
    $this->connection = $databaseManager->getPdo();
  }

  public function createPractitioner(PractitionerDTO $practitioner)
  {
    if ($this->hasPractitionerByEmail($practitioner->getEmail())) {
        return "There already exists a record with this information. Please try again.";
    }
    $name = $practitioner->getName();
    $email = $practitioner->getEmail();
    $password = $practitioner->getPassword();
    $personalInfo = $practitioner->getPersonalInfo();

    // Prepare the INSERT query
    $query = "INSERT INTO GeneralPractitioners (name, email, password, personalInfo) VALUES (?, ?, ?, ?)";
    $statement = $this->connection->prepare($query);
    $hashedPassword = hash('sha256', $password);
    $statement->bindParam(1, $name);
    $statement->bindParam(2, $email);
    $statement->bindParam(3, $hashedPassword);
    $statement->bindParam(4, $personalInfo);
    $statement->execute();

    // Check if the insert was successful
    if ($statement->rowCount() === 0) {
        return ("Failed to create a new practitioner");
      }
      return "Practitioner created successfully!";
  }

  public function getAllPractitioners()
  {
    // Prepare the SELECT query
    $query = "SELECT * FROM GeneralPractitioners";
    $statement = $this->connection->prepare($query);
    $statement->execute();

    // Get the result
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Transform the result into an array of PractitionerDTO objects
    $practitioners = [];
    foreach ($result as $row) {
      $practitionerData = [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'password' => $row['password'],
        'personalInfo' => $row['personalInfo'],
      ];
      $practitioner = new PractitionerDTO($practitionerData);
      $practitioners[] = $practitioner;
    }

    return $practitioners;
  }

  public function hasPractitionerById($id)
  {
    // Prepare the SELECT query
    $query = "SELECT COUNT(*) FROM GeneralPractitioners WHERE id = ?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $id);
    $statement->execute();

    // Get the result
    $count = $statement->fetchColumn();

    // Return true if a practitioner exists with the given ID, false otherwise
    return $count > 0;
  }

  private function hasPractitionerByEmail($email)
  {
    // Prepare the SELECT query
    $query = "SELECT COUNT(*) FROM GeneralPractitioners WHERE email = ?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $email);
    $statement->execute();

    // Get the result
    $count = $statement->fetchColumn();

    // Return true if a practitioner exists with the given email, false otherwise
    return $count > 0;
  }

  public function getPractitionerById($id)
  {
    // Prepare the SELECT query
    $query = "SELECT * FROM GeneralPractitioners WHERE id = ?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $id);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null; // Practitioner not found
    }

    $practitionerData = [
      'id' => $row['id'],
      'name' => $row['name'],
      'email' => $row['email'],
      'password' => $row['password'],
      'personalInfo' => $row['personalInfo'],
    ];
    $practitioner = new PractitionerDTO($practitionerData);

    return $practitioner;
  }

  public function getPractitionerByEmail($email)
  {
    // Prepare the SELECT query
    $query = "SELECT * FROM GeneralPractitioners WHERE email = ?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $email);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null; // Practitioner not found
    }

    $practitionerData = [
      'id' => $row['id'],
      'name' => $row['name'],
      'email' => $row['email'],
      'password' => $row['password'],
      'personalInfo' => $row['personalInfo'],
    ];
    $practitioner = new PractitionerDTO($practitionerData);

    return $practitioner;
  }

  public function updatePractitioner(PractitionerDTO $practitioner)
{
    if (!$this->hasPractitionerByEmail($practitioner->getEmail())) {
        return "failure";
    }
    
    // Prepare the UPDATE query
    $query = "UPDATE GeneralPractitioners SET name = ?, email = ?, personalInfo = ? WHERE id = ?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $practitioner->getName());
    $statement->bindParam(2, $practitioner->getEmail());
    $statement->bindParam(3, $practitioner->getPersonalInfo());
    $statement->bindParam(4, $practitioner->getId());
    $statement->execute();

    // Check if the update was successful
    if ($statement->rowCount() === 0) {
        return ("failure");
    }
    return "success";
}

  public function deletePractitioner($id)
  {
    if (!$this->hasPractitionerById($id)) {
        return "No practitioner exists with the given ID: $id";
      }
    // Prepare the DELETE query
    $query = "DELETE FROM GeneralPractitioners WHERE id = ?";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(1, $id);
    $statement->execute();

    // Check if the delete was successful
    if ($statement->rowCount() === 0) {
        return "Failed to delete patient with ID: $id";
    }
    return "Practitioner deleted successfully!";
  }
}
?>