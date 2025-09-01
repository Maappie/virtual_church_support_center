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
        $sql = "UPDATE history SET pending = 1 WHERE user_email = '$recipient'";
        $conn->query($sql);
        return 'Error in sending email: ' . $mail->ErrorInfo;
    }
}

// Function to insert data into records table
function insertIntoRecords($row, $conn, $approvalStatus)
{
    // Prepare the insert statement
    $sql = "INSERT INTO records (user_email, user_full_name, purpose_for, date_column, sponsor_1, sponsor_2, receipt, receipt_code, age, father_name, mother_maiden_name, contact_number, approval)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $row['user_email'], $row['user_full_name'], $row['purpose_for'], $row['date_column'], $row['sponsor_1'], $row['sponsor_2'], $row['receipt'], $row['receipt_code'], $row['age'], $row['father_name'], $row['mother_maiden_name'], $row['contact_number'], $approvalStatus);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Record inserted into records successfully.";
    } else {
        echo "Error inserting record into records: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the approve or decline button is clicked
    if (isset($_POST["approve"]) || isset($_POST["decline"])) {
        // Retrieve the selected user id
        $selectedId = $_POST["selected_id"];

        // Update the pending column to NULL
        $sql = "UPDATE history SET pending = NULL WHERE id = '$selectedId'";
        if ($conn->query($sql) === TRUE) {
            // Query to check the value from the database based on selected id
            $sql = "SELECT * FROM history WHERE id = '$selectedId'";
            $result = $conn->query($sql);

            // Check if there's a result
            if ($result->num_rows > 0) {
                // Fetch the row
                $row = $result->fetch_assoc();
                // Retrieve user details
                $userEmail = $row['user_email'];
                $userName = $row['user_full_name'];
                $purposeFor = $row['purpose_for'];
                $dateColumn = $row['date_column'];

                // Convert date to "Month day, year" format
                $formattedDate = date("F j, Y", strtotime($dateColumn));

                if (isset($_POST["approve"])) {
                    // Create email content for approval
                    $content = "Good day to you $userName,<br><br>We received your request for $purposeFor, and we want you to know that we approve of your request for $formattedDate. Please bring a hard copy of the requirements for the said date.<br><br>Thank you,<br>National Shrine of Saint Michael and the Archangels";
                    $approvalStatus = "approved";
                } else {
                    // Retrieve the decline reason
                    $reason = $_POST["reason"];
                    // Create email content for decline
                    $content = "Good day to you $userName,<br><br>We received your request for $purposeFor, but we regret to inform you that we cannot approve it for $formattedDate due to the following reason: <br><br> $reason <br><br>We apologize for any inconvenience this may cause.<br><br>Thank you,<br>National Shrine of Saint Michael and the Archangels";
                    $approvalStatus = "declined";
                }

                // Send email
                $result = sendEmail($userEmail, $content, $conn);
                // Display success message or error
                echo $result;

                // Insert data into records table
                insertIntoRecords($row, $conn, $approvalStatus);
            } else {
                // If no matching row found
                echo "No matching record found for user id: $selectedId";
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
