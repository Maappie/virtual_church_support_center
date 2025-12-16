<?php
// Include the database connection file
include('../connection.php');

$response = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ---------------------------------------------------------
    // SCENARIO 1: RESET TO DEFAULT
    // ---------------------------------------------------------
    if (isset($_POST['action']) && $_POST['action'] == 'setDefault') {
        $id = intval($_POST['id']);
        
        // Validation: ID must be between 1 and 5
        if ($id >= 1 && $id <= 5) {
            
            // 1. Get current file name from DB
            $query = "SELECT picture_$id FROM carousel LIMIT 1";
            $result = mysqli_query($conn, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $currentFile = $row["picture_$id"];
                $defaultFile = "carousel_" . $id . ".jpg";

                // 2. If the current file is NOT the default file, delete it
                // (We never want to delete the actual default file from the folder)
                if ($currentFile !== $defaultFile) {
                    $filePath = "event_$id/" . $currentFile;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // 3. Update Database back to default name
                $updateQuery = "UPDATE carousel SET picture_$id = '$defaultFile'";
                if (mysqli_query($conn, $updateQuery)) {
                    echo "Carousel $id reset to default successfully.";
                } else {
                    echo "Error updating database.";
                }
            }
        } else {
            echo "Invalid ID.";
        }
        exit; // Stop here, don't run the upload logic below
    }


    // ---------------------------------------------------------
    // SCENARIO 2: UPLOAD NEW FILES
    // ---------------------------------------------------------
    $updateQuery = "UPDATE carousel SET ";
    $updatesMade = false;

    for ($i = 1; $i <= 5; $i++) {
        if (isset($_FILES["fileToUpload$i"]) && $_FILES["fileToUpload$i"]["error"] == 0) {
            $fileName = $_FILES["fileToUpload$i"]["name"];
            $fileTmp = $_FILES["fileToUpload$i"]["tmp_name"];

            if ($fileName != '') {
                
                // --- CHECK OLD FILE START ---
                $getOldFileQuery = "SELECT picture_$i FROM carousel LIMIT 1";
                $result = mysqli_query($conn, $getOldFileQuery);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $oldFileName = $row["picture_$i"];
                    $defaultFile = "carousel_" . $i . ".jpg";
                    
                    $targetDir = "event_$i/";
                    $oldFilePath = $targetDir . $oldFileName;

                    // SAFETY CHECK: Only delete the old file if it is NOT the default file
                    if (!empty($oldFileName) && file_exists($oldFilePath) && $oldFileName !== $defaultFile) {
                        unlink($oldFilePath); 
                    }
                }
                // --- CHECK OLD FILE END ---

                // Generate new unique name
                $uniqueID = uniqid();
                $newFileName = $uniqueID . "_" . basename($fileName);
                $targetDir = "event_$i/";
                $targetFile = $targetDir . $newFileName;

                if (move_uploaded_file($fileTmp, $targetFile)) {
                    $response .= "File $i uploaded. ";
                    $columnName = "picture_$i";
                    $updateQuery .= "$columnName = '$newFileName', ";
                    $updatesMade = true;
                } else {
                    $response .= "Error uploading file $i. ";
                }
            }
        }
    }

    if ($updatesMade) {
        $updateQuery = rtrim($updateQuery, ", ");
        if (mysqli_query($conn, $updateQuery)) {
            $response .= "Update Successful.";
        } else {
            $response .= "DB Error: " . mysqli_error($conn);
        }
    } else {
        $response .= "No files selected.";
    }

} else {
    header('Location: ../index.php');
    exit();
}

echo $response;
?>