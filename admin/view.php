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

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$userPulledFromDb = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 400px;
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

        .profile-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }

        .go-back-link {
            display: block;
            text-align: center;
            font-size: 14px;
            color: #666;
            text-decoration: none;
        }

        .go-back-link:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>

        <div class="profile-info">
            <p><strong>Name:</strong> <?php echo $userPulledFromDb['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $userPulledFromDb['email']; ?></p>
        </div>

        <a class="go-back-link" href="index.php">Go Back</a>
    </div>
</body>
</html>
