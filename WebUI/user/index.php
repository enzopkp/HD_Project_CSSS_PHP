<?php
session_start();

require '../db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            color: #666;
        }

        .admin-links {
            margin-bottom: 20px;
            text-align: center;
        }

        .admin-links a {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .admin-links a:hover {
            background-color: #45a049;
        }

        .logout-link {
            display: block;
            text-align: center;
            font-size: 14px;
            color: #666;
            text-decoration: none;
        }

        .logout-link:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>

        <p class="welcome-message">Welcome, <?php echo $user['name']; ?></p>

        <div class="admin-links">
            <a href="view.php?id=<?php echo $user['id']; ?>">View My Information</a>
            <a href="edit.php?id=<?php echo $user['id']; ?>">Edit My Information</a>
        </div>

        <a class="logout-link" href="logout.php">Logout</a>
    </div>
</body>
</html>
