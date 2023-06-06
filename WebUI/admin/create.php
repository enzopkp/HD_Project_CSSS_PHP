<?php
session_start();

require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
}

if ($_POST) {
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([$_POST['name'], $_POST['email'], hash('sha256', $_POST['password']), $_POST['role']]);
    header("Location: admin.php");
}

?>

<form method="POST">
    Name: <input type="text" name="name">
    Email: <input type="email" name="email">
    Password: <input type="password" name="password">
    Role: <input type="text" name="role">
    <input type="submit" value="Create User">
</form>
