<?php
session_start(); // Start session
include '../connection.php';

// Redirect to ../index.php if the request method is not POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../index.php");
    exit();
}

// Retrieve form data from AJAX request
$login_email = $_POST["login_email"];
$login_password = $_POST["login_password"];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL statement to retrieve user data based on email
$stmt = $conn->prepare("SELECT * FROM users_account WHERE user_email = ?");
$stmt->bind_param("s", $login_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // User found, fetch the user data
    $row = $result->fetch_assoc();

    // Verify the hashed password
    if (password_verify($login_password, $row['user_password'])) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the unique identifier
        $_SESSION['user_email'] = $row['user_email'];

        // Return success message
        echo "Login successful";
    } else {
        // Incorrect password
        echo "Invalid password.";
    }
} else {
    // User not found
    echo "User not found.";
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();

// Stop further execution
exit;
?>
