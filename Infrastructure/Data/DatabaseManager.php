<?PHP
require_once __DIR__ . '/DatabaseConnection.php';
require_once __DIR__ . '/DatabaseSchema.php';
class DatabaseManager {
  private $connection;
  private $schema;
  private $host;
  private $db;
  private $user;
  private $pass;
  private $charset;

  public function __construct() {
    $this->host = 'localhost';
    $this->db = 'test';
    $this->user = 'root';
    $this->pass = '';
    $this->charset = 'utf8mb4';

    $this->connection = new DatabaseConnection($this->host, $this->db, $this->user, $this->pass, $this->charset);
    $pdo = $this->connection->getPdo();

    $this->schema = new DatabaseSchema($pdo, $this->db);
    $this->initializeDatabase();
  }

  private function initializeDatabase() {
    $this->schema->createDatabaseIfNotExists();
    $this->schema->createTablesIfNotExists();
  }

  public function getPdo() {
    return $this->connection->getPdo();
  }
}
?>
