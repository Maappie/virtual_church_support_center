<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="verify_email.css">
</head>
<body>
<?php
session_start();

// Set session timeout to 3 minutes (180 seconds)
$timeout = 180;

// Check if session variables are set
if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_password']) || !isset($_SESSION['verification_code'])) {
    // Redirect to index.php if session variables are not set
    header("Location: ../index.php");
    exit();
}

// Check if session timeout is reached
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();    // Unset all session variables
    session_destroy();  // Destroy the session
    header("Location: ../index.php"); // Redirect to index.php
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();

// Display error message if set
if (isset($_GET['error']) && $_GET['error'] == 1) {
    echo "<p style='color: red;'>Verification code does not match. Please try again.</p>";
}

?>

<!-- Container for the form elements -->
<div class="form">
        <!-- Countdown timer for session timeout -->
        <div id="timeout">Verification expires in: 120 seconds</div>

        <!-- Form for code verification -->
        <form action="verify_code.php" method="post">
            <div class="form-element">
                <label for="verification_code">Enter Verification Code:</label><br>
                <input type="text" id="verification_code" name="verification_code" required>
            </div>
            <div class="form-element">
                <button type="submit" class="verify-button">Verify</button> <!-- Add class for styling -->
            </div>
        </form>

        <!-- Form for cancellation -->
        <form action="logout.php" method="post">
            <div class="form-element">
                <button type="submit" class="cancel-button">Cancel</button> <!-- Add class for styling -->
            </div>
        </form>
    </div>
<script>
// Countdown timer for session timeout
var countdown = <?php echo $timeout; ?>;
var timer = setInterval(function() {
    countdown--;
    document.getElementById("timeout").innerHTML = "Session timeout in: " + countdown + " seconds";
    if (countdown <= 0) {
        clearInterval(timer);
        window.location.href = "../index.php"; // Redirect to index.php after timeout
    }
}, 1000);
</script>

</body>
</html>