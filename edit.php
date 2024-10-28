<?php
session_start();

// Check if user is logged in; redirect to login if not
if (!isset($_SESSION['is_logged_in'])) {
    header('Location: index.php');
    exit();
}

require_once 'User.php';

$user = new User();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $existingUser = $user->find($id);
}

if (isset($_POST['submit'])) {
    $id = $_POST['ID'];
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];

    if ($Password !== $ConfirmPassword) {
        echo "<div class='alert alert-danger'>Passwords do not match.</div>";
    } else {
        if ($user->update($id, $UserName, $Password)) {
            header('Location: User_list.php');
            exit();
        } else {
            echo "<div class='alert alert-danger'>Failed to update user.</div>";
        }
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Edit User</h2>
            <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="ID" value="<?php echo $existingUser['ID']; ?>">

                <div class="form-group">
                    <label for="UserName">UserName:</label>
                    <input type="text" class="form-control" id="UserName" name="UserName" 
                           value="<?php echo htmlspecialchars($existingUser['UserName']); ?>" 
                           required oninput="validateUsername()">
                    <div id="username-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="password" class="form-control" id="Password" name="Password" 
                           required oninput="validatePassword()">
                    <div id="password-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="ConfirmPassword">Confirm Password:</label>
                    <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" 
                           required oninput="validateConfirmPassword()">
                    <div id="confirm-password-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Update User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function restrictUsernameInput(event) {
            event.target.value = event.target.value.replace(/[^a-zA-Z]/g, ''); 
            validateUsername();
        }

        function validateUsername() {
            const usernameInput = document.getElementById('UserName');
            const username = usernameInput.value;
            const usernameError = document.getElementById('username-error');

            if (username.length === 0) {
                usernameError.textContent = 'Username is required';
                usernameError.classList.add('error');
            } else if (username.length < 3) {
                usernameError.textContent = 'Username must be at least 3 characters long';
                usernameError.classList.add('error');
            } else {
                usernameError.textContent = '';
                usernameError.classList.remove('error');
            }

            checkSubmitButton();
        }

        function restrictPasswordInput(event) {
            event.target.value = event.target.value.replace(/[^a-zA-Z0-9]/g, '');
            validatePassword();
        }

        function validatePassword() {
            const passwordInput = document.getElementById('Password');
            const password = passwordInput.value;
            const passwordError = document.getElementById('password-error');

            if (password.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters long and contain only letters and numbers.';
                passwordError.classList.add('error');
            } else {
                passwordError.textContent = '';
                passwordError.classList.remove('error');
            }

            checkSubmitButton();
        }

        function restrictConfirmPasswordInput(event) {
            event.target.value = event.target.value.replace(/[^a-zA-Z0-9]/g, '');
            validateConfirmPassword();
        }

        function validateConfirmPassword() {
            const password = document.getElementById('Password').value;
            const confirmPassword = document.getElementById('ConfirmPassword').value;
            const confirmPasswordError = document.getElementById('confirm-password-error');

            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                confirmPasswordError.classList.add('error');
            } else {
                confirmPasswordError.textContent = '';
                confirmPasswordError.classList.remove('error');
            }

            checkSubmitButton();
        }

        function checkSubmitButton() {
            const username = document.getElementById('UserName').value;
            const password = document.getElementById('Password').value;
            const confirmPassword = document.getElementById('ConfirmPassword').value;
            const submitBtn = document.getElementById('submitBtn');

            submitBtn.disabled = !(username && password.length >= 6 && password === confirmPassword);
        }

        document.getElementById('UserName').addEventListener('input', restrictUsernameInput);
        document.getElementById('Password').addEventListener('input', restrictPasswordInput);
        document.getElementById('ConfirmPassword').addEventListener('input', restrictConfirmPasswordInput);
    </script>
</body>
</html>
