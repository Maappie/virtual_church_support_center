<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link rel="stylesheet" href="verify_password.css">
</head>
<body>

<?php
// Start the session
session_start();
$session_timeout = 300; // Timeout in seconds (adjust as needed)

// Check if last activity time is set
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Unset all session variables
    session_unset();
    session_destroy();
}

// Check if 'email' session variable is not set
if (!isset($_SESSION['email'])) {
    // Unset all session variables
    session_unset();
    // Redirect to index page
    header("Location: ../index.php");
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Check if verification code is not set in session
if (!isset($_SESSION['verification_code'])) {
    // Redirect to index page if verification code is not set
    header("Location: ../index.php"); // Adjust the path accordingly
    exit();
}

// Initialize the variable to hold the verification status
$verification_status = "";

// Check if the form for verifying the code is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verification_code"])) {
    // Retrieve the verification code entered by the user
    $enteredCode = $_POST["verification_code"];

    // Check if entered code matches the code stored in the session
    if ($_SESSION['verification_code'] == $enteredCode) {
        // Redirect to reset password page
        header("Location: reset_password.php");
        exit();
    } else {
        // Set verification status to indicate failure
        $verification_status = "Verification failed. Please try again.";
    }
}
?>

<div class="verification-container">
        <!-- Display verification status message -->
        <p><?php echo $verification_status; ?></p>

        <!-- Display countdown timer -->
        <p id="countdown">Verification expires in 120 seconds</p>

        <!-- Form for inputting verification code -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="verification_code">Verification Code:</label>
            <input type="text" id="verification_code" name="verification_code" placeholder="Enter verification code" required>
            <input type="submit" id="verifyButton" class="button" value="Verify Code"> 
        </form>

        <!-- Cancel button -->
        <button onclick="cancelReset()" class="button">Cancel</button>  
    </div>
<!-- JavaScript for countdown timer and cancel button -->
<script>
    // Set the countdown duration in seconds
    var countdownDuration = <?php echo $session_timeout; ?>;

    // Function to update the countdown timer
    function updateCountdown() {
        // Calculate remaining time
        var minutes = Math.floor(countdownDuration / 60);
        var seconds = countdownDuration % 60;

        // Display the countdown timer
        document.getElementById("countdown").textContent = "Session timeout in: " + minutes + " minutes " + seconds + " seconds";

        // Update countdown duration
        countdownDuration--;

        // If countdown duration reaches 0, redirect to end session
        if (countdownDuration < 0) {
            window.location.href = "end_session.php";
        }
    }

    // Call updateCountdown function every second
    setInterval(updateCountdown, 1000);

    // Function to handle cancel button click
    function cancelReset() {
        if (confirm('Are you sure you want to cancel?')) {
            // Redirect to end session
            window.location.href = "end_session.php";
        }
    }
</script>
</body>
</html>