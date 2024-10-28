<?php
session_start(); // Start the session

require_once 'User1.php';

// Check if the user is logged in

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $Task = $_POST['Task'];




    $user = new User1();


        if($user->create1($Task)){
        echo "<div class='alert alert-success'>User created successfully!</div>";
        header('Location: User_list1.php');
        exit();
    }
}
$existingImage = false; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body onload="validateAllFields()">
<div class="container">
    <div class="form-container">
        <h2 class="text-center">Create New Task</h2>
        <form action="create1.php" method="post" enctype="multipart/form-data" autocomplete="off">


            <div class="form-group">
                <label for="Task">Task</label>
                <textarea class="form-control" id="Task" name="Task" rows="3" required></textarea>
                <div id="task-error" class="error-message"></div>
            </div>


            <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Add Task</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js" defer></script>
<script>
        // Validate all fields when page loads
        function validateAllFields() {
            validateTask();

            checkSubmitButton();
        }
</script>
</script>
</body>
</html>
