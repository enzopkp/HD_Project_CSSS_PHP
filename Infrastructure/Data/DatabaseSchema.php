<?PHP
class DatabaseSchema {
    private $pdo;
    private $db;

    public function __construct(PDO $pdo, $db) {
        $this->pdo = $pdo;
        $this->db = $db;
    }

    public function createDatabaseIfNotExists() {
        $this->pdo->exec("CREATE DATABASE IF NOT EXISTS {$this->db}");
    }

    public function createTablesIfNotExists() {
        $this->pdo->exec("USE {$this->db}");

        // Create the tables if they don't exist
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS Patients (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password CHAR(64) NOT NULL,
                contactInfo VARCHAR(255),
                personalDetails TEXT
            );

            CREATE TABLE IF NOT EXISTS GeneralPractitioners (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password CHAR(64) NOT NULL,
                personalInfo TEXT
            );

            CREATE TABLE IF NOT EXISTS Appointments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                time TIME NOT NULL,
                date DATE NOT NULL,
                room INT NOT NULL,
                description TEXT,
                practitioner INT,
                patient INT,
                FOREIGN KEY(practitioner) REFERENCES GeneralPractitioners(id),
                FOREIGN KEY(patient) REFERENCES Patients(id),
                UNIQUE KEY (time, date, room),
                UNIQUE KEY (time, date, practitioner),
                UNIQUE KEY (time, date, patient)
            );
        ");
    }
}
?>
