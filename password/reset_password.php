<?php
// Start the session
session_start();

// Include the file containing the database connection code
include '../connection.php';

// Initialize variables
$passwordMismatch = false;
$passwordChanged = false;

// Check if the verification code and email are set in the session
if (!isset($_SESSION['verification_code']) || !isset($_SESSION['email'])) {
    // If verification code or email is not set, redirect back to the verification page
    header("Location: ../index.php");
    exit();
}

// Check if the form for changing password is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
    // Retrieve the new password and confirm password entered by the user
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if new password matches confirm password
    if ($newPassword !== $confirmPassword) {
        $passwordMismatch = true; // Set flag to indicate password mismatch
    } else {
        // If passwords match, validate the password against the strong password policy
        if (validatePassword($newPassword)) {
            // If passwords match and meet the strong password policy, hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // If passwords match, update the user's hashed password in the database
            try {
                // Prepare the update statement
                $sql = "UPDATE users_account SET user_password = ? WHERE user_email = ?";
                $stmt = $conn->prepare($sql);

                // Bind parameters and execute the statement
                $stmt->bind_param("ss", $hashedPassword, $_SESSION['email']);
                $stmt->execute();

                // Set flag to indicate password change success
                $passwordChanged = true;

                // End the session
                session_unset();
                session_destroy();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}

// Function to validate password against strong password policy and spaces
function validatePassword($password) {
    // Password policy criteria
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[\W_]@', $password); // Include special characters and underscore

    // Check if all criteria are met
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false; // Password does not meet the criteria
    }

    // Check for spaces
    if (strpos($password, ' ') !== false) {
        return false; // Spaces are not allowed
    }

    return true; // Password meets the criteria
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="reset_password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="password-container">
         <!-- General message -->
  <h1>You can now change your password</h1>
  <br>

  <!-- Conditional messages -->
  <?php if ($passwordMismatch): ?>
      <p class="error">Password does not match.</p>
  <?php endif; ?>

  <?php if ($passwordChanged): ?>
      <p class="success">Password changed successfully.</p>
      <script>
          // Redirect to index.php after 3 seconds
          setTimeout(function() {
              window.location.href = "../index.php";
          }, 1500);
      </script>
  <?php endif; ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validatePassword()">
          <div class="input-group">
              <label for="new_password">New Password:</label><br>
              <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required><br>
              <span class="show"><i class="fa fa-eye-slash"></i></span>
          </div>
          <div class="input-group">
              <label for="confirm_password">Confirm Password:</label><br>
              <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required><br>
              <span class="show"><i class="fa fa-eye-slash"></i></span>
          </div>
          <input type="submit" class="button" value="Change Password">
      </form>
      <div id="passwordConditions" class="paragraph">
          <p>Password must meet the following criteria:</p>
          <ul>
              <li>At least 8 characters long</li>
              <li>Contain at least 1 uppercase letter (A-Z)</li>
              <li>Contain at least 1 lowercase letter (a-z)</li>
              <li>Contain at least 1 number (0-9)</li>
              <li>Contain at least 1 special character (e.g., _, -, +, =, !, @, %, *, &, ", :, ., /)</li>
              <li>No spaces allowed</li>
          </ul>
      </div>
      <p class="error" id="passwordErrorMessage"></p>
      <button onclick="cancelReset()" class="button">Cancel</button>
    </div>

<!-- JavaScript for cancel button and password validation -->
<script>
    //java script for icon button
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

    function cancelReset() {
        if (confirm('Are you sure you want to cancel?')) {
            // Redirect to index.php
            window.location.href = "end_session.php";
        }
    }
    function validatePassword() {
    var newPassword = document.getElementById("new_password").value;
    var passwordErrorMessage = document.getElementById("passwordErrorMessage");

    // Check if new password matches confirm password
    if (newPassword !== document.getElementById("confirm_password").value) {
        passwordErrorMessage.textContent = "Password does not match.";
        return false; // Prevent form submission
    } else {
        passwordErrorMessage.textContent = ""; // Clear error message if passwords match
    }

    // Check if password contains spaces
    if (/\s/.test(newPassword)) {
        passwordErrorMessage.textContent = "Spaces are not allowed in the password.";
        return false; // Prevent form submission
    } else {
        passwordErrorMessage.textContent = ""; // Clear error message if no spaces found
    }

    // Check for uppercase letter
    if (!/[A-Z]/.test(newPassword)) {
        passwordErrorMessage.textContent += "Please include at least 1 uppercase letter.\n";
        return false; // Prevent form submission
    }

    // Check for lowercase letter
    if (!/[a-z]/.test(newPassword)) {
        passwordErrorMessage.textContent += "Please include at least 1 lowercase letter.\n";
        return false; // Prevent form submission
    }

    // Check for number
    if (!/[0-9]/.test(newPassword)) {
        passwordErrorMessage.textContent += "Please include at least 1 number.\n";
        return false; // Prevent form submission
    }

    // Check for special character
    if (!/[\W_]/.test(newPassword)) {
        passwordErrorMessage.textContent += "Please include at least 1 special character.\n";
        return false; // Prevent form submission
    }

    // Check for minimum length
    if (newPassword.length < 8) {
        passwordErrorMessage.textContent += "Password should be at least 8 characters long.\n";
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}

</script>
</body>
</html>