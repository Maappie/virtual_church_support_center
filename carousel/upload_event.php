<?php 
    session_start(); // Start session
    // Check if admin is logged in
    if (!isset($_SESSION['admin_username'])) {
        // Redirect to login page if not logged in
        header("Location: ../index.php"); // Adjust the path accordingly
        exit();   
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Event</title>
 <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: rgba(0, 0, 0, 0.7) url('../image/bgimage.jpg');
            background-size: cover;
            background-blend-mode: darken;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            position: relative;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .back-button a {
            background-image: linear-gradient(150deg, #B621fe, #1fd1f9);
            color: white;
            padding: 10px;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            font-size: 10px;
            text-decoration: none;
            transition: background-color 0.3s, opacity 0.3s;
        }

        .back-button a:hover {
            background-image: linear-gradient(-150deg, #B621fe, #1fd1f9);
            opacity: 0.7;
        }

        .back-button a:active {
            opacity: 0.5;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        form {
            display: block;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-box {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            background-color: #fafafa;
        }

        input[type="file"] {
            width: 100%;
            border: none;
            background: none;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-image: linear-gradient(150deg, #B621fe, #1fd1f9);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, opacity 0.3s;
        }

        input[type="submit"]:hover {
            background-image: linear-gradient(-150deg, #B621fe, #1fd1f9);
            opacity: 0.7;
        }

        input[type="submit"]:active {
            opacity: 0.5;
        }

        #response {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="button back-button">
            <a href="../admin_interface.php">&larr;</a>
        </div>
        <h1>Upload Images</h1>
        <form id="uploadForm" onsubmit="uploadFiles(event)" enctype="multipart/form-data">
            <label for="fileToUpload1">Upload File 1:</label>
            <div class="input-box">
                <input type="file" name="fileToUpload1" id="fileToUpload1" accept=".jpg, .jpeg, .png">
            </div>

            <label for="fileToUpload2">Upload File 2:</label>
            <div class="input-box">
                <input type="file" name="fileToUpload2" id="fileToUpload2" accept=".jpg, .jpeg, .png">
            </div>

            <label for="fileToUpload3">Upload File 3:</label>
            <div class="input-box">
                <input type="file" name="fileToUpload3" id="fileToUpload3" accept=".jpg, .jpeg, .png">
            </div>

            <label for="fileToUpload4">Upload File 4:</label>
            <div class="input-box">
                <input type="file" name="fileToUpload4" id="fileToUpload4" accept=".jpg, .jpeg, .png">
            </div>

            <label for="fileToUpload5">Upload File 5:</label>
            <div class="input-box">
                <input type="file" name="fileToUpload5" id="fileToUpload5" accept=".jpg, .jpeg, .png">
            </div>

            <input type="submit" value="Upload Files" name="submit">
        </form>
        <div id="response"></div>
    </div>
</body>
<script>
function uploadFiles(event) {
    event.preventDefault(); // Prevent the default form submission

    // Allowed file extensions
    var allowedExtensions = ['jpg', 'jpeg', 'png'];

    // Create a new FormData object
    var formData = new FormData();

    // Append each file to the FormData object and check the file extension
    for (var i = 1; i <= 5; i++) {
        var fileInput = document.getElementById('fileToUpload' + i);
        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var fileExtension = file.name.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                formData.append('fileToUpload' + i, file);
            } else {
                alert('Only .jpg, .jpeg, and .png files are allowed.');
                return;
            }
        }
    }

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Define the function to be executed when the request receives an answer
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Display the response message in an alert
            alert(xhr.responseText);
            // Reload the page after the alert is closed
            location.reload();
        }
    };

    // Open a connection to the server
    xhr.open('POST', 'handle_event.php', true);

    // Send the request
    xhr.send(formData);
}
</script>
</html>
