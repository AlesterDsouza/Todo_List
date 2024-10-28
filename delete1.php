<?php

session_start(); // Start the session
require_once 'User1.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$user = new User1();

// Handle deletion
if (isset($_GET['delete1'])) {
    $id = $_GET['delete1'];
    $user->delete1($id);

    header('Location: User_list1.php');
    // exit();
}//If the delete parameter is set in the URL (via a GET request), the corresponding user ID is retrieved, and the delete() method is called to remove the user from the database.

// Fetch all users after deletion
$users = $user->read1();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Management System - Task List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Task List</h1>
        
        <!-- Add the 'Create User' link/button -->
        <a href="create1.php" class="btn">Create Task</a>

        <h2>Task List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo ($user['ID']); ?></td>
                        <td><?php echo ($user['Task']); ?></td>

                        <td>
                            <a href="edit1.php?id=<?php echo $user['ID']; ?>">Edit</a> |
                            <a href="delete1.php?delete1=<?php echo $user['ID']; ?>" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No task found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

