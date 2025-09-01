<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page if not logged in
    header("Location: ../index.php");
    exit();
}

// Include database connection file
include '../connection.php';

// Function to generate a unique ID 
function generateUniqueId() {
    return uniqid();
}

// Function to move uploaded file to the file system
function saveUploadedFile($file, $destinationDirectory) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $uniqueId = generateUniqueId();
        $fileDestination = $destinationDirectory . '/' . $uniqueId . '_' . $fileName;
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            return array('file_name' => $fileName, 'unique_id' => $uniqueId);
        } else {
            // Error handling for file move failure
            return null;
        }
    } else {
        // Error handling for file upload error
        return null;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all form fields are set
    if (isset($_POST["full_name"], $_POST["reason"], $_POST["sponsor_name"], $_POST["chosen_date"], $_FILES['receipt'])) {
        // Retrieve form data
        $fullName = $_POST["full_name"];
        $reason = $_POST["reason"];
        $sponsorName = $_POST["sponsor_name"];
        $chosenDate = $_POST["chosen_date"];
        $userEmail = $_SESSION['user_email'];

        // Check if receipt file is uploaded
        $uploadedReceipt = saveUploadedFile($_FILES['receipt'], '../g_cash_receipts');
        if ($uploadedReceipt !== null) {
            $receiptFileName = $uploadedReceipt['file_name'];
            $receiptUniqueId = $uploadedReceipt['unique_id'];

            // Prepare and bind SQL statement to insert data into the history table
            $sql = "INSERT INTO history (user_email, user_full_name_pamisa, purpose_for_pamisa, sponsor_pamisa, date_column_pamisa, receipt_code, receipt, approval_status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                // Bind parameters to the statement
                $stmt->bind_param("sssssss", $userEmail, $fullName, $reason, $sponsorName, $chosenDate, $receiptUniqueId, $receiptFileName);

                // Execute the statement
                if ($stmt->execute()) {
                    // Set session variable to true after successful insert
                    $_SESSION['receipt_saved'] = true;
                    // Redirect to a success page or display a success message
                    header("Location: ../user_interface_2.php");
                    exit();
                } else {
                    // Data insertion failed
                    echo "Error: Unable to insert data.";
                }
                $stmt->close();
            } else {
                // Statement preparation failed
                echo "Error: Unable to prepare the SQL statement.";
            }
        } else {
            // Error handling for file upload failure
            echo "Error uploading receipt file.";
        }
    } else {
        // Handle case where form data is missing
        echo "Error: Form data is missing.";
    }
} else {
    // If no form submitted, redirect to user_interface.php
    header("Location: ../user_interface.php");
    exit();
}

// Close database connection
$conn->close();
?>
