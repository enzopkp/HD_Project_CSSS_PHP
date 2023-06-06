<?PHP
class UserAuthenticationService {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function authenticate($email, $password, $table) {
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user && hash('sha256', $password) == $user['password']) {
            return $user;
        } else {
            return null;
        }
    }
}
?>
