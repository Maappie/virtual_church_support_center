<?php
// Start the session
session_start();

// Check if the verification code session variable is not set
if (!isset($_SESSION['verificationCodeAdmin'])) {
    header("Location: ../index.php"); // Redirect to index.php
    exit(); // Stop further execution
}

// Check if the session timeout is reached
$sessionTimeout = 180; // 3 minutes in seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $sessionTimeout)) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../index.php"); // Redirect to index.php
    exit(); // Stop further execution
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();

// Check if the form for verifying the code is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verification_code"])) {
    // Retrieve the verification code entered by the user
    $enteredCode = $_POST["verification_code"];

    // Check if entered code matches the code stored in the session
    if ($_SESSION['verificationCodeAdmin'] == $enteredCode) {
        // Redirect to reset password page
        header("Location: reset_passwordAdmin.php");
        exit();
    } else {
        // Verification failed
        $verificationFailed = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link rel="stylesheet" href="verify_code.css">
</head>
<body>




<div class="verification-container">
    <!-- Display verification failed message -->
<?php if (isset($verificationFailed) && $verificationFailed): ?>
    <p style="color: red;">Verification failed. Please try again.</p>
<?php endif; ?>

<!-- Display countdown timer -->
<p id="countdown"></p>     

<!-- Form for inputting verification code -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="verification_code">Verification Code:</label>
            <input type="text" id="verification_code" name="verification_code" placeholder="Enter verification code" required>
            <input type="submit" value="Verify Code">
        </form>

        <!-- Button to end session -->
        <button onclick="endSession()" class="cancel-button">Cancel</button>
    </div>

<!-- JavaScript for countdown timer -->
<script>
    // Set the countdown duration in seconds
    var countdownDuration = <?php echo $sessionTimeout; ?>;

    // Function to update the countdown timer
    function updateCountdown() {
        // Calculate remaining time
        var minutes = Math.floor(countdownDuration / 60);
        var seconds = countdownDuration % 60;

        // Display the countdown timer
        document.getElementById("countdown").textContent = "Session timeout in: " + minutes + " minutes " + seconds + " seconds";

        // Update countdown duration
        countdownDuration--;

        // If countdown duration reaches 0, redirect to index.php
        if (countdownDuration < 0) {
            window.location.href = "../index.php";
        }
    }

    // Call updateCountdown function every second
    setInterval(updateCountdown, 1000);

    // Function to end session
    function endSession() {
        // Redirect to end_session.php
        window.location.href = "end_session.php";
    }
</script>

</body>
</html>