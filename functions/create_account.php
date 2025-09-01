<?php
session_start();
include '../connection.php'; 

require '../vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to generate a random 6-digit number
function generateRandomNumber() {
    return mt_rand(100000, 999999);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Check if email already exists in the database
    $stmt = $conn->prepare("SELECT user_email FROM users_account WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists.";
        exit();
    }

    // Generate random 6-digit number
    $verificationCode = generateRandomNumber();
    // Set verification code to session variable
    $_SESSION['verification_code'] = $verificationCode;

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server address
        $mail->SMTPAuth = true;
        $mail->Username = 'junverlymorada@gmail.com';
        $mail->Password = 'ierh wmfx ljuj pwjt';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('junverlymorada@example.com', 'Church');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body    = '<p style="color: black;">Hi User,</p>' .
                         '<p style="color: black;">Thanks for signing up for The National Shrine of Saint Michael and the Archangels confirmation and online pamisa service! To complete your account creation and ensure it\'s really you, we\'ve sent a verification code to your email address.</p>' .
                         '<p style="color: black;">Please enter the code below to verify your email and access your new account.</p>' .
                         '<p style="color: black;"><strong>Verification code: ' . $verificationCode . '</strong></p>';

        // Send email
        $mail->send();

        // Save email and password in session variables
        $_SESSION['user_email'] = $email;
        $_SESSION['user_password'] = $password;
        
        echo "Verification code sent to your email. Please check your inbox.";
    } catch (Exception $e) {
        echo "Failed to send verification code. Error: {$mail->ErrorInfo}";
    }
}
?>
