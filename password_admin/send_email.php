<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Path to PHPMailer autoload file
include '../connection.php'; // Include database connection file

session_start();

// Check if the email is provided
if (!isset($_POST["forgot_email"])) {
    // Redirect to index.php if email is not provided
    header("Location: ../index.php");
    exit(); // Stop further execution
}

// Retrieve the email address submitted by the user
$email = $_POST["forgot_email"];

// Set the entered email into a session variable
$_SESSION['admin_forgot_email'] = $email;

// Check if the email exists in the database
$emailExists = false;

// Perform database query to check if email exists
$sql = "SELECT * FROM admin_account WHERE admin_username = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $emailExists = true;

    // Generate a random 6-digit verification code
    $verificationCode = sprintf('%06d', mt_rand(100000, 999999));

    // Store the verification code in a session variable
    $_SESSION['verificationCodeAdmin'] = $verificationCode;

    // Send email with the verification code using PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server host
        $mail->SMTPAuth = true;
        $mail->Username = 'junverlymorada@gmail.com'; // Your Gmail address
        $mail->Password = 'rtmn lpcb tnwd cega'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // Your SMTP port

        //Recipients
        $mail->setFrom('junverlymorada@example.com', 'CHURCH'); // Sender's email address and name
        $mail->addAddress($email); // Recipient's email address

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Forgot Password Verification Code';
        $mail->Body = "
        <html>
        <body style='color: black;'>
            <p>Hello Admin!</p>
            <p>You have requested for a password change. Below is your Verification Number:</p>
            <p style='font-weight: bold;'>$verificationCode</p>
        </body>
        </html>
    ";
    
        
        $mail->send();
        echo "Email has been sent.";
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// If email does not exist in the database, show an error message
if (!$emailExists) {
    echo "Admin not found.";
    exit(); // Stop further execution
}
?>
