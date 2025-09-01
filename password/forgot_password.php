<?php
include '../connection.php'; 

require '../vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize session
session_start();

// Check if the form for sending verification code is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["forgot_email"])) {
    // Retrieve the email entered by the user
    $email = $_POST["forgot_email"];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT user_email FROM users_account WHERE user_email = ?");
    
    if (!$stmt) {
        // Query preparation failed
        echo "Query preparation failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Email not found in database
        echo 'Username not found.';
        exit();
    }

    // Generate a random 6-digit verification code
    $verificationCode = mt_rand(100000, 999999);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server address (e.g., smtp.gmail.com)
        $mail->SMTPAuth = true;
        $mail->Username = 'junverlymorada@gmail.com'; // Your Gmail address
        $mail->Password = 'rtmn lpcb tnwd cega'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // Your SMTP port

        //Recipients
        $mail->setFrom('junverlymorada@gmail.com', 'Church');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'VERIFICATION NUMBER';
        $mail->Body = "Hi there ($email),<br><br>Here is your verification code: <strong>$verificationCode</strong>. Enter this and change to your new password.";
        
        // Send the email
        if ($mail->send()) {
            // Store the verification code and email in session
            $_SESSION['verification_code'] = $verificationCode;
            $_SESSION['email'] = $email;
            $_SESSION['email_sent'] = true; // Set session variable to indicate email was sent

            // Display success message
            echo 'Email has been sent.';
        } else {
            // Failed to send email, display appropriate error message
            if ($mail->ErrorInfo === 'Invalid address') {
                echo 'Address not found.';
            } else {
                echo 'Failed to send verification code. Please try again later.';
            }
        }

    } catch (Exception $e) {
        echo 'Failed to send verification code. Please try again later.';
        // Log or handle the exception appropriately
    }
} else {
    // If email is not set, show error message
    echo 'Email is required.';
}
?>
