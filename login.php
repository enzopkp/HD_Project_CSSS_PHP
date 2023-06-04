<?php
session_start();

require 'db.php';

$errors = [];

if ($_POST) {
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Email Validation (PHP)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Password Validation (PHP)
    if (strlen($password) < 8 || strlen($password) > 40) {
        $errors[] = "Password must be between 8 and 40 characters";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT * FROM Patients WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && hash('sha256', $password) == $user['password']) {
            $_SESSION['user'] = $user;
            header("Location: user/index.php");
            exit;
        } else {
            $errors[] = "Invalid email or password";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Patient Login</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:400,500,700">
    <link rel="stylesheet" type="text/css" href="/css/login.css">
    <script src="scripts/login.js"></script>
</head>
<body>
    <div class="container">
        <h1>Patient Login</h1>
        <?php
        // Display PHP validation errors
        if (!empty($errors)) {
            echo '<div class="error-message">';
            foreach ($errors as $error) {
                // escape the error message
                echo '<p>' . htmlspecialchars($error, ENT_QUOTES) . '</p>';
            }
            echo '</div>';
        }
        ?>

        <div id="errorDiv" class="error-message"></div>

        <form id="loginForm" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login">
        </form>

        <a class="admin-login-link" href="adminLogin.php">Admin Login</a>
    </div>
</body>
</html>
