<?php
session_start();
include '../connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve verification code entered by the user
    $enteredCode = $_POST['verification_code'];

    // Retrieve verification code stored in session
    $storedCode = $_SESSION['verification_code'];

    // Check if the entered code matches the stored code
    if ($enteredCode == $storedCode) {
        // Verification code matches, proceed to insert user into database

        // Retrieve email and password from session
        $email = $_SESSION['user_email'];
        $password = password_hash($_SESSION['user_password'], PASSWORD_DEFAULT); // Hash the password

        // Prepare and execute SQL statement to insert new user into database
        $stmt = $conn->prepare("INSERT INTO users_account (user_email, user_password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);

        if ($stmt->execute()) {
            // User inserted successfully

            // Unset and destroy session variables
            session_unset();
            session_destroy();

            // Display success message
            echo "Account created successfully, redirecting to homepage.";
            // Redirect to index.php after displaying the message for a brief moment
            header("refresh:2;url=../index.php");
            exit();
        } else {
            // Error inserting user into database
            echo "Error inserting user. Please try again later.";
        }
    } else {
        // Verification code does not match, redirect with error message
        header("Location: verify_email.php?error=1");
        exit();
    }
} else {
    // If the form is not submitted via POST method, redirect to index.php
    header("Location: ../index.php");
    exit();
}
?>
