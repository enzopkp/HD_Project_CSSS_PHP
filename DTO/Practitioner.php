<?php
require_once  '../db.php';
class GeneralPractitioner {
    public $id;
    public $name;
    public $email;
    public $password;
    public $personalInfo;

    public function __construct($id, $name, $email, $password, $personalInfo) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->personalInfo = $personalInfo;
    }

    public function save() {
        $pdo = (new DatabaseConnection())->getPdo();

        // Check if user already exists before trying to insert
        $stmt = $pdo->prepare("SELECT * FROM GeneralPractitioners WHERE email = :email");
        $stmt->execute([':email' => $this->email]);
        $user = $stmt->fetch();

        if (!$user) {
            $sql = "INSERT INTO GeneralPractitioners (name, email, password, personalInfo)
                    VALUES (:name, :email, :password, :personalInfo)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    ':name' => $this->name,
                    ':email' => $this->email,
                    ':password' => $this->password,
                    ':personalInfo' => $this->personalInfo
                ]);
                $this->id = $pdo->lastInsertId();
                echo "New general practitioner inserted successfully!";
                return $pdo->lastInsertId(); // Return the ID of the inserted row
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "User with this email already exists.";
        }

        return null; // Return null if the general practitioner was not inserted
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

    public function getPersonalInfo() {
        return $this->personalInfo;
    }

    public function setPersonalInfo($personalInfo) {
        $this->personalInfo = $personalInfo;
    }
}
?>
