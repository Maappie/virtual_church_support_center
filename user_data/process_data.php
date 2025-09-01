<?php 
session_start(); // Start session
include '../connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page if not logged in
    header("Location: ../index.php");
    exit();
}

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (isset($_POST["full_name"]) && !empty($_POST["full_name"]) &&
        isset($_POST["age"]) && !empty($_POST["age"]) &&
        isset($_POST["contact_number"]) && !empty($_POST["contact_number"]) &&
        isset($_POST["sponsor_name"]) && !empty($_POST["sponsor_name"]) &&
        isset($_POST["father_name"]) && !empty($_POST["father_name"]) &&
        isset($_POST["mother_maiden_name"]) && !empty($_POST["mother_maiden_name"]) &&
        isset($_POST["purpose"]) && !empty($_POST["purpose"]) &&
        isset($_POST["chosen_date"]) && !empty($_POST["chosen_date"])) {
        
        // Start a transaction
        $conn->begin_transaction();

        // Prepare and bind parameters to prevent SQL injection for user information insertion
        $stmt = $conn->prepare("INSERT INTO history (user_full_name, age, contact_number, sponsor_1, sponsor_2, father_name, mother_maiden_name, purpose_for, date_column, user_email, receipt_code, receipt, pending) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sissssssssss", $fullName, $age, $contactNumber, $sponsorName, $secondSponsorName, $fatherName, $motherMaidenName, $purpose, $chosenDate, $_SESSION['user_email'], $receiptUniqueId, $receiptFileName);
        
        // Set parameters for user information insertion
        $fullName = $_POST["full_name"];
        $age = $_POST["age"];
        $contactNumber = $_POST["contact_number"];
        $sponsorName = $_POST["sponsor_name"];
        $secondSponsorName = isset($_POST["second_sponsor_name"]) ? $_POST["second_sponsor_name"] : NULL;
        $fatherName = $_POST["father_name"];
        $motherMaidenName = $_POST["mother_maiden_name"];
        $purpose = $_POST["purpose"];
        $chosenDate = $_POST["chosen_date"];

        // Handle receipt upload
        if (isset($_FILES['receipt'])) {
            $uploadedReceipt = saveUploadedFile($_FILES['receipt'], '../g_cash_receipts');
            if ($uploadedReceipt !== null) {
                $receiptFileName = $uploadedReceipt['file_name'];
                $receiptUniqueId = $uploadedReceipt['unique_id'];
            } else {
                // Error handling for file upload failure
                echo "Error uploading receipt file.";
                exit(); // Exit if receipt upload fails
            }
        }

        // Execute prepared statement for user information insertion
        if ($stmt->execute()) {
            // Set session variable to true after successful receipt insert
            $_SESSION['receipt_saved'] = true;
            // Commit the transaction
            $conn->commit();
            // Redirect to a success page or display a success message
            header("Location: ../user_interface.php");
            exit();
        } else {
            // Error handling for user information insertion failure
            echo "Error inserting user information.";
            $conn->rollback(); // Rollback the transaction if insertion fails
            exit();
        }
    } else {
        // If any required field is missing, redirect back to the form page with an error message
        header("Location: user_interface.php?error=missing_fields");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the form page
    header("Location: ../user_interface.php");
    exit();
}
?>
