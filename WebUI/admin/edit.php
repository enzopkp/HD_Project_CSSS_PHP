<?php
session_start();

require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user = $_SESSION['user'];
$user_id = $_GET['id'];

if ($user['role'] != 'admin' && $user['id'] != $user_id) {
    die("You don't have permission to access this page");
}

if ($_POST) {
    $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?');
    $stmt->execute([$_POST['name'], $_POST['email'], hash('sha256', $_POST['password']), $_POST['role'], $user_id]);
    header("Location: admin.php");
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

?>

<form method="POST">
    Name: <input type="text" name="name" value="<?= $user['name'] ?>">
    Email: <input type="email" name="email" value="<?= $user['email'] ?>">
    Password: <input type="password" name="password">
    Role: <input type="text" name="role" value="<?= $user['role'] ?>">
    <input type="submit" value="Update User">
</form>
