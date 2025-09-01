<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    // Redirect to login page if not logged in
    header("Location: ../index.php"); // Adjust the path accordingly
    exit();
}

// Include PHPMailer autoload file
require '../vendor/autoload.php';

// Include your database connection file here
include '../connection.php';

// Function to send email
function sendEmail($recipient, $content, $conn)
{
    // Create a new PHPMailer instance
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'junverlymorada@gmail.com';
    $mail->Password = 'ierh wmfx ljuj pwjt';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Sender and recipient settings
    $mail->setFrom('junverlymorada@example.com', 'Church');
    $mail->addAddress($recipient); // Add recipient email

    // Email content
    $mail->isHTML(true); // Set to true to send HTML email
    $mail->Subject = 'Approval Status';

    $mail->Body = "<span style='color: black;'>$content</span>"; // Set email body with black text color

    // Send email
    if ($mail->send()) {
        // Email sent successfully
        return 'Email sent successfully.';
    } else {
        // Error in sending email
        // Revert pending column back to 1 (true)
        $sql = "UPDATE users_account SET approval_status = 1 WHERE user_email = '$recipient'";
        $conn->query($sql);
        return 'Error in sending email: ' . $mail->ErrorInfo;
    }
}

// Function to insert data into records_2 table
function insertIntoRecords($conn, $userName, $purposeFor, $sponsor_pamisa, $dateColumn, $userEmail, $receipt, $receiptCode, $approvalStatus)
{
    // Prepare SQL statement to insert data into records_2 table
    $sql = "INSERT INTO records_2 (user_full_name_pamisa, purpose_for_pamisa, sponsor_pamisa, date_column_pamisa, user_email, receipt, receipt_code, approval) 
            VALUES ('$userName', '$purposeFor', '$sponsor_pamisa', '$dateColumn', '$userEmail', '$receipt', '$receiptCode', '$approvalStatus')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        return "Data inserted into records_2 successfully.";
    } else {
        return "Error inserting data into records_2: " . $conn->error;
    }
}

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the approve button or decline button is clicked
    if (isset($_POST["approve"]) || isset($_POST["decline"])) {
        // Retrieve the selected user ID
        $selectedId = $_POST["selected_id"];

        // Update the pending column to NULL
        $sql = "UPDATE history SET approval_status = NULL WHERE id = '$selectedId'";
        if ($conn->query($sql) === TRUE) {
            // Query to check the value from the database based on selected ID
            $sql = "SELECT * FROM history WHERE id = '$selectedId'";
            $result = $conn->query($sql);

            // Check if there's a result
            if ($result->num_rows > 0) {
                // Fetch the row
                $row = $result->fetch_assoc();
                // Retrieve user details
                $userName = $row['user_full_name_pamisa'];
                $purposeFor = $row['purpose_for_pamisa'];
                $sponsor_pamisa = $row['sponsor_pamisa'];
                $dateColumn = $row['date_column_pamisa'];
                $userEmail = $row['user_email']; // Fetch user_email from history table
                $receipt = $row['receipt']; // Fetch receipt from history table
                $receiptCode = $row['receipt_code']; // Fetch receipt_code from history table
                // Determine the action (approve or decline) and create email content accordingly
                if (isset($_POST["approve"])) {
                    // Format the date to "Month Day, Year"
                    $dateFormatted = date("F j, Y", strtotime($dateColumn));
                    // Add additional information to the email content
                    $content = "Good day to you $userName,<br><br>We received your request for $purposeFor, and we want you to know that we approve of your request for $dateFormatted, which is intended for $sponsor_pamisa.<br><br>You can attend physically for the said date by 6pm.<br><br>Thank you,<br>National Shrine of Saint Michael and the Archangels";
                    // Set approval status
                    $approvalStatus = "approved";
                } elseif (isset($_POST["decline"])) {
                    // Get the decline reason
                    $reason = $_POST["reason"];
                    // Format the date to "Month Day, Year"
                    $dateFormatted = date("F j, Y", strtotime($dateColumn));
                    // Add additional information to the email content
                    $content = "Good day to you $userName,<br><br>We received your request for $purposeFor, but we regret to inform you that we cannot approve it for $dateFormatted, which is intended for $sponsor_pamisa. Reason for decline: $reason. We apologize for any inconvenience this may cause.<br><br>Thank you,<br>National Shrine of Saint Michael and the Archangels";
                    // Set approval status
                    $approvalStatus = "declined";
                }
                // Send email
                $result = sendEmail($userEmail, $content, $conn);

                // Insert data into records_2 table after sending the email
                $insertResult = insertIntoRecords($conn, $userName, $purposeFor, $sponsor_pamisa, $dateColumn, $userEmail, $receipt, $receiptCode, $approvalStatus);

                // Display success message or error for email sending and insertion into records_2
                echo $result . "<br>" . $insertResult;
            } else {
                // If no matching row found
                echo "No matching record found for user ID: $selectedId";
            }
        } else {
            // If there's an error updating the column
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Handle the case when no action is selected
        echo "No action selected.";
    }
} else {
    // If the form is not submitted via POST method
    header("Location: ../admin_interface.php");
    exit(); // Ensure that code execution stops after the redirect
}

// Close the database connection
$conn->close();
?>
