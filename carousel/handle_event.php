<?php
// Include the database connection file
include('../connection.php');

// Initialize response message
$response = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Construct the SQL UPDATE query
    $updateQuery = "UPDATE carousel SET ";

    // Loop through each uploaded file
    for ($i = 1; $i <= 5; $i++) {
        if (isset($_FILES["fileToUpload$i"])) {
            $fileName = $_FILES["fileToUpload$i"]["name"];
            $fileTmp = $_FILES["fileToUpload$i"]["tmp_name"];

            // Check if file is uploaded successfully
            if ($fileName != '') {
                // Generate a unique ID and define the new file name
                $uniqueID = uniqid();
                $newFileName = $uniqueID . "_" . basename($fileName);

                // Define target directory based on the button number
                $targetDir = "event_$i/";
                // Define target file path
                $targetFile = $targetDir . $newFileName;

                // Move uploaded file to target directory
                if (move_uploaded_file($fileTmp, $targetFile)) {
                    $response .= "File $i uploaded successfully.";

                    // Update the corresponding column in the database
                    $columnName = "picture_$i";
                    $updateQuery .= "$columnName = '$newFileName', "; // Save only the new file name
                } else {
                    $response .= "Error uploading file $i.<br>";
                }
            }
        }
    }

    // Remove the trailing comma and space from the update query
    $updateQuery = rtrim($updateQuery, ", ");

    // Execute the update query
    if (mysqli_query($conn, $updateQuery)) {
        $response .= " Carousel Updated.";
    } else {
        $response .= "Error updating carousel: ";
    }
} else {
    // Handle case where form is not submitted
    header('../index.php');
    $response = "No files were submitted.";
}

// Output the response message
echo $response;
?>
