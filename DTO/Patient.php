
<?php
require_once  '../db.php';
class Patient {
    public $id;
    public $name;
    public $email;
    public $password;
    public $contactInfo;
    public $personalDetails;

    public function __construct($id, $name, $email, $password, $contactInfo, $personalDetails) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->contactInfo = $contactInfo;
        $this->personalDetails = $personalDetails;
    }

    public function save() {
        $pdo = (new DatabaseConnection())->getPdo();

        // Check if user already exists before trying to insert
        $stmt = $pdo->prepare("SELECT * FROM Patients WHERE email = :email");
        $stmt->execute([':email' => $this->email]);
        $user = $stmt->fetch();

        if (!$user) {
            $sql = "INSERT INTO Patients (name, email, password, contactInfo, personalDetails)
                    VALUES (:name, :email, :password, :contactInfo, :personalDetails)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    ':name' => $this->name,
                    ':email' => $this->email,
                    ':password' => $this->password,
                    ':contactInfo' => $this->contactInfo,
                    ':personalDetails' => $this->personalDetails
                ]);
                $this->id = $pdo->lastInsertId();
                echo "New patient inserted successfully!";
                return $pdo->lastInsertId(); // Return the ID of the inserted row
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "User with this email already exists.";
        }

        return null; // Return null if the patient was not inserted
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getContactInfo() {
        return $this->contactInfo;
    }

    public function setContactInfo($contactInfo) {
        $this->contactInfo = $contactInfo;
    }

    public function getPersonalDetails() {
        return $this->personalDetails;
    }

    public function setPersonalDetails($personalDetails) {
        $this->personalDetails = $personalDetails;
    }
}
?>
