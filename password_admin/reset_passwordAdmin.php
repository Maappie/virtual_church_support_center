<?php
session_start();

// Check if the email session variable is set
if (!isset($_SESSION['admin_forgot_email'])) {
    // Redirect back to index.php if session variable is not set
    header("Location: ../index.php");
    exit(); // Stop further execution
}

// Include database connection file
include '../connection.php';

// Initialize flag for password reset success
$passwordResetSuccess = false;

// Function to validate the password against specified requirements
function validatePassword($password) {
    // Password regex pattern to match requirements
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s\\~<>])([^\s]){8,}$/";
    return preg_match($pattern, $password);
}

// Check if the form for resetting password is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
    // Retrieve new password and confirm password from the form
    $newPassword = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Validate the new password against requirements
    if (!validatePassword($newPassword)) {
        // Password does not meet requirements, display error message
        $passwordErrorMessage = "Password must meet the following requirements:<br>" .
            "<li>At least 8 characters long</li>" .
            "<li>Contain at least 1 uppercase letter (A-Z)</li>" .
            "<li>Contain at least 1 lowercase letter (a-z)</li>" .
            "<li>Contain at least 1 number (0-9)</li>" .
            "<li>Contain at least 1 special character (e.g., _, -, +, =, !, @, %, *, &, \", :, ., /)</li>" .
            "<li>No spaces allowed</li>";
    } elseif ($newPassword !== $confirmPassword) {
        // Check if new password matches the confirm password
        $passwordErrorMessage = "Passwords do not match.";
    } else {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Retrieve email from session variable
        $email = $_SESSION['admin_forgot_email'];

        // Update password in the database
        $sql = "UPDATE admin_account SET admin_password = ? WHERE admin_username = ?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            // Query preparation failed
            echo "Query preparation failed: (" . $conn->errno . ") " . $conn->error;
            exit();
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ss", $hashedPassword, $email);
        $stmt->execute();

        // Check if password update was successful
        if ($stmt->affected_rows > 0) {
            // Password updated successfully
            $passwordResetSuccess = true;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="reset_passwordAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="password-container">
        <h2>Reset Password</h2>

        <?php if ($passwordResetSuccess): ?>
            <p style="color: green;">Password changed successfully.</p>
        <?php endif; ?>

        <!-- Form for resetting password -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="input-group">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password" required>
                <span class="show"><i class="fa fa-eye-slash"></i></span>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                <span class="show"><i class="fa fa-eye-slash"></i></span>
            </div>
            <div class="button-wrapper">
                <button type="submit" class="button">Reset Password</button>
                <button type="reset" class="button">Clear</button>
            </div>
        </form>

        <!-- Displaying error message -->
        <p class="error-message"><?php echo isset($passwordErrorMessage) ? $passwordErrorMessage : ''; ?></p>

        <!-- Button to confirm ending session -->
        <button onclick="confirmEndSession()" class="button">Cancel</button>
    </div>

    <script>
        // JavaScript for icon button
        document.addEventListener('DOMContentLoaded', function() {
            var showButtons = document.querySelectorAll('.input-group .show');
            showButtons.forEach(function(showButton) {
                showButton.addEventListener('click', function() {
                    var input = this.parentElement.querySelector('input');
                    if (input.type === "password") {
                        input.type = "text";
                        this.innerHTML = '<i class="fa fa-eye"></i>';
                    } else {
                        input.type = "password";
                        this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                    }
                });
            });
        });
    </script>
<script>
    // Redirect to index.php after 2 seconds if password reset was successful
    <?php if ($passwordResetSuccess): ?>
    setTimeout(function() {
        window.location.href = "../index.php";
    }, 2000);
    <?php endif; ?>
</script>
<!-- JavaScript for confirmation dialog -->
<script>
    // Function to confirm ending session
    function confirmEndSession() {
        if (confirm('Are you sure you want to end the session?')) {
            // If user confirms, redirect to end_session.php
            window.location.href = "end_session.php";
        }
    }
</script>

</body>
</html>
