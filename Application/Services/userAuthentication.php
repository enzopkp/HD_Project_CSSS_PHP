<?PHP
class UserAuthentication {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function authenticate($email, $password) {
        $stmt = $this->pdo->prepare('SELECT * FROM Patients WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && hash('sha256', $password) == $user['password']) {
            return $user;
        } else {
            return null;
        }
    }
}
?>
