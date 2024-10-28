<?php
session_start();
require_once 'User1.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Initialize User1 object
$user = new User1();

// Handle search
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Handle pagination
$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch users and total count based on search and pagination
$total_users = $user->countTasks($search);
$total_pages = ceil($total_users / $limit);
$users = $user->fetchTasks($search, $limit, $offset);

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add custom styles for search input */
        input[name="search"] {
            width: 300px; /* Increase width as needed */
            padding: 10px; /* Add some padding for better appearance */
            font-size: 16px; /* Increase font size */
            margin-right: 10px; /* Space between input and button */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Filter Form -->
        <form method="GET" action="">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search" autocomplete="off">
            <button type="submit">Search</button>
        </form>

        <h2>ToDo List</h2>
        
        <a href="create1.php" class="btn">Create New Task</a>
        <a href="login.php" class="btn">Logout</a>

        <!-- User List Table -->
        <table border="1">
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
                        <td><?php echo($user['Task']); ?></td>

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
        
        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>" <?php if ($i == $page) echo 'style="font-weight: bold;"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
