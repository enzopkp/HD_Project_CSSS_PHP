<?PHP
class DatabaseConnection {
    private $pdo;

    public function __construct($host, $db, $user, $pass, $charset) {
        $dsn = "mysql:host=$host;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    public function getPdo() {
        return $this->pdo;
    }
}
?>
