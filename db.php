<?php
class DatabaseConnection {
    private $pdo;
    private $db;
    private $user;
    private $pass;
    private $charset;

    public function __construct() {
      $host = 'localhost';
      $db   = 'test';
      $user = 'root';
      $pass = '';
      $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $user, $pass, $opt);

        // Create database and table if they don't exist
        $this->pdo->exec("
            CREATE DATABASE IF NOT EXISTS $db;
            USE $db;
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

    public function getPdo() {
        return $this->pdo;
    }
}
?>
