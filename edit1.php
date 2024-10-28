<?php

session_start();
require_once 'User1.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    // exit;
}

$user = new User1();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $existingUser = $user->find1($id);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $Task = $_POST['Task'];
    

    // // Handle profile picture upload
    // $profilePic = $existingUser['ProfilePic']; // Keep existing profile pic if no new one is uploaded
    // if ($_FILES['ProfilePic']['name']) {
    //     $profilePic = time() . '_' . $_FILES['ProfilePic']['name'];
    //     move_uploaded_file($_FILES['ProfilePic']['tmp_name'], 'uploads/' . $profilePic);
    // }

    // Update user information
    if ($user->update1($id, $Task)) {
        header('Location: User_list1.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Failed to update task.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles1.css">
    <script src="script.js" defer></script>



    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }

    </style>
</head>
<body onload="validateAllFields()">
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Edit Task</h2>
            <form action="edit1.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" autocomplete="off" id="editUserForm">
                <input type="hidden" name="ID" value="<?php echo $existingUser['ID']; ?>">


                <div class="form-group">
                    <label for="Task">Task:</label>
                    <textarea class="form-control" id="Task" name="Task" required autocomplete="off" oninput="validateTask()"><?php echo htmlspecialchars($existingUser['Task']); ?></textarea>
                    <div id="task-error" class="error-message"></div>
                </div>


                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Update Task</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Validate all fields when page loads
        function validateAllFields() {
            validateTask();
            checkSubmitButton();
        }
    </script>
</body>
</html>
