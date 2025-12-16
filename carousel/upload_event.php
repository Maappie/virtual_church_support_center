<?php 
    session_start(); 
    if (!isset($_SESSION['admin_username'])) {
        header("Location: ../index.php"); 
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
            width: 350px; /* Made slightly wider for the new buttons */
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
            opacity: 0.7;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Container for Input + Button */
        .input-group {
            display: flex;
            gap: 5px;
            margin-bottom: 15px;
            align-items: center;
        }

        .input-box {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fafafa;
            flex-grow: 1; /* Takes up remaining space */
        }

        input[type="file"] {
            width: 100%;
            border: none;
            background: none;
            font-size: 12px;
        }

        /* New Default Button Style */
        .default-btn {
            background-color: #ff9800; /* Orange color */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 11px;
            cursor: pointer;
            white-space: nowrap;
        }

        .default-btn:hover {
            background-color: #e68900;
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
            transition: opacity 0.3s;
        }

        input[type="submit"]:hover {
            opacity: 0.7;
        }

        #response {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
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
            
            <label for="fileToUpload1">Carousel 1:</label>
            <div class="input-group">
                <div class="input-box">
                    <input type="file" name="fileToUpload1" id="fileToUpload1" accept=".jpg, .jpeg, .png">
                </div>
                <button type="button" class="default-btn" onclick="setDefault(1)">Set Default</button>
            </div>

            <label for="fileToUpload2">Carousel 2:</label>
            <div class="input-group">
                <div class="input-box">
                    <input type="file" name="fileToUpload2" id="fileToUpload2" accept=".jpg, .jpeg, .png">
                </div>
                <button type="button" class="default-btn" onclick="setDefault(2)">Set Default</button>
            </div>

            <label for="fileToUpload3">Carousel 3:</label>
            <div class="input-group">
                <div class="input-box">
                    <input type="file" name="fileToUpload3" id="fileToUpload3" accept=".jpg, .jpeg, .png">
                </div>
                <button type="button" class="default-btn" onclick="setDefault(3)">Set Default</button>
            </div>

            <label for="fileToUpload4">Carousel 4:</label>
            <div class="input-group">
                <div class="input-box">
                    <input type="file" name="fileToUpload4" id="fileToUpload4" accept=".jpg, .jpeg, .png">
                </div>
                <button type="button" class="default-btn" onclick="setDefault(4)">Set Default</button>
            </div>

            <label for="fileToUpload5">Carousel 5:</label>
            <div class="input-group">
                <div class="input-box">
                    <input type="file" name="fileToUpload5" id="fileToUpload5" accept=".jpg, .jpeg, .png">
                </div>
                <button type="button" class="default-btn" onclick="setDefault(5)">Set Default</button>
            </div>

            <input type="submit" value="Upload Files" name="submit">
        </form>
        <div id="response"></div>
    </div>
</body>

<script>
// Function 1: Upload Files
function uploadFiles(event) {
    event.preventDefault();
    var allowedExtensions = ['jpg', 'jpeg', 'png'];
    var formData = new FormData();
    var hasFiles = false;

    for (var i = 1; i <= 5; i++) {
        var fileInput = document.getElementById('fileToUpload' + i);
        if (fileInput.files.length > 0) {
            hasFiles = true;
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

    if (!hasFiles) {
        alert("Please select a file to upload.");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert(xhr.responseText);
            location.reload();
        }
    };
    xhr.open('POST', 'handle_event.php', true);
    xhr.send(formData);
}

// Function 2: Set to Default
function setDefault(id) {
    if(!confirm("Are you sure you want to reset Carousel " + id + " to the default image?")) {
        return;
    }

    var formData = new FormData();
    formData.append('action', 'setDefault');
    formData.append('id', id);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert(xhr.responseText);
            location.reload();
        }
    };
    xhr.open('POST', 'handle_event.php', true);
    xhr.send(formData);
}
</script>
</html>