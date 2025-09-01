<?php
session_start(); // Start session
include '../connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the login email and password are set
    if (isset($_POST["admin_email"]) && isset($_POST["admin_password"])) {
        $email = $_POST["admin_email"];
        $password = $_POST["admin_password"];

        // Prepare a SQL statement using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT admin_password FROM admin_account WHERE admin_username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Admin found, fetch the stored hashed password
            $row = $result->fetch_assoc();
            $stored_hashed_password = $row["admin_password"];

            // Verify the password
            if (password_verify($password, $stored_hashed_password)) {
                // Password is correct, login successful
                // Set session variables
                $_SESSION['admin_username'] = $email;

                // Return success message
                echo "success";
            } else {
                // Login failed due to incorrect password
                echo "Invalid password.";
            }
        } else {
            // Admin not found
            echo "Admin not found."; // You can customize the message here
        }

        $stmt->close();
    } else {
        // Handle case where login email or password is not set
        echo "Please enter both email and password.";
    }
}

$conn->close();
?>
