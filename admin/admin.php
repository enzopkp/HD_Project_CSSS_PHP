<?php
session_start();

require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
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
        }

        h1 {
            margin-bottom: 20px;
        }

        .welcome-message {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .user-list {
            margin-bottom: 20px;
        }

        .user-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-list table th,
        .user-list table td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .user-list table th {
            background-color: #f2f2f2;
        }

        .user-list table td.actions {
            text-align: center;
        }

        .user-list table td.actions a {
            margin-right: 5px;
        }

        .user-list table td.actions a:last-child {
            margin-right: 0;
        }

        .create-user-link {
            display: block;
            margin-top: 20px;
        }

        .logout-link {
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>

    <div class="welcome-message">
        Welcome, <?php echo $user['name']; ?>
    </div>

    <div class="user-list">
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td class="actions">
                        <a href="view.php?id=<?php echo $user['id']; ?>">View</a>
                        <a href="edit.php?id=<?php echo $user['id']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $user['id']; ?>">Delete</a>
                    </td>
                </tr>
        </table>
    </div>

    <a class="create-user-link" href="create.php">Create New User</a>
    <a class="logout-link" href="logout.php">Logout</a>
</body>
</html>
