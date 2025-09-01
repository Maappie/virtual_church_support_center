    <?php
    session_start();

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
        // Check if receipt file is uploaded
        if (isset($_FILES['receipt'])) {
            $uploadedReceipt = saveUploadedFile($_FILES['receipt'], '../g_cash_receipts');
            if ($uploadedReceipt !== null) {
                $receiptFileName = $uploadedReceipt['file_name'];
                $receiptUniqueId = $uploadedReceipt['unique_id'];

                // Save the file name and unique ID in the database
                $sql = "UPDATE users_account SET receipt_code = ?, receipt = ? WHERE user_email = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("sss", $receiptUniqueId, $receiptFileName, $_SESSION['user_email']);
                    if ($stmt->execute()) {
                        // Set session variable to true after successful insert
                        $_SESSION['receipt_saved'] = true;
                    } else {
                        // Error handling for database execution error
                    }
                    $stmt->close();
                } else {
                    // Error handling for database preparation error
                }
            } else {
                // Error handling for file upload failure
                echo "Error uploading receipt file.";
            }
        }

        // Close database connection
        $conn->close();

        // Redirect back to the user page
        header("Location: ../user_interface.php");
        exit();
    } else {
        // If no form submitted, redirect to user_interface.php
        header("Location: ../user_interface.php");
        exit();
    }
    ?>
