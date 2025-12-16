<?php 
session_start(); // Start session
// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    // Redirect to login page if not logged in
    header("Location: index.php"); // Adjust the path accordingly
    exit();   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface 2</title>
    <link rel="stylesheet" href="styling_admin/admin_interface-style.css">
</head>
<body>
    <div class="fixed-container">
        <h1 class="title">
            National Shrine of St. Michael and the Archangels
        </h1>
        <img class="portrait-image" src="image/background.jpg" alt="Portrait Image">
        <button class="button pamisa-button" id="onlineMassPendingButton">Check Request for Kumpil</button>
        <button class="button logout-button" id="historyButton2">Check Records</button>      
        <button class="button logout-button" id="pictureButton">Upload Pictures</button> 
        <button class="button logout-button" id="logoutButton">Logout</button>
    </div>

    <div class="content-box">
        <h1 class="welcome">Welcome, <?php echo $_SESSION['admin_username']; ?>! <br> Online Mass</h1>

        <!-- Display pending requests in a table -->
        <?php
        include 'connection.php';

        // Query to select rows where approval_status is 1 (pending)
        $sql = "SELECT * FROM history WHERE approval_status = 1";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Display the pending requests in a table
            echo "<p>Pending Requests for Online Pamisa:</p>";
            echo "<table class='pending-requests-table'>";
            echo "<tr><th>Email</th><th>Full Name</th><th>Purpose</th><th>Sponsor</th><th>Date</th><th>Receipt</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                // Format the date
                $date = new DateTime($row['date_column_pamisa']);
                $formattedDate = $date->format('F j, Y');
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['user_full_name_pamisa']) . "</td>";
                echo "<td>" . htmlspecialchars($row['purpose_for_pamisa']) . "</td>";
                echo "<td>" . htmlspecialchars($row['sponsor_pamisa']) . "</td>";
                echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                // Button to show receipt image in a modal
                echo "<td><button onclick='openModal(\"g_cash_receipts/" . htmlspecialchars($row['receipt_code']) . "_" . htmlspecialchars($row['receipt']) . "\")' type='button'>Show Receipt</button></td>";
                // Buttons for approving and declining
                // Buttons for approving and declining (Stacked Vertically)
                echo "<td>";
                // Added 'display: block' and 'margin: 0 auto' to center and stack them
                // Added 'margin-bottom: 5px' to put a small gap between the buttons
                echo "<button type='button' onclick='submitForm(" . htmlspecialchars($row['id']) . ", \"approve\", this)' class='approveButton' style='display: block; margin: 0 auto 5px auto; width: 80px;'>Approve</button>";
                echo "<button type='button' onclick='submitForm(" . htmlspecialchars($row['id']) . ", \"decline\", this)' class='declineButton' style='display: block; margin: 0 auto; width: 80px;'>Decline</button>";
                echo "</td>";             
                echo "</tr>";
            }
            echo "</table>";

        } else {
            // If no pending requests found
            echo "<p>No pending requests for online pamisa at the moment</p>";
        }

        // Close the connection
        $conn->close();
        ?>

        <!-- Modal for displaying receipt image -->
        <div id="myModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-content">
                <img id="receiptImage" src="" alt="Receipt">
            </div>
        </div>

        <div id="message"></div>
    </div>

    <script>
    var onlineMassPendingButton = document.getElementById("onlineMassPendingButton");
    onlineMassPendingButton.addEventListener("click", function() {
        window.location.href = "admin_interface.php";
    });
    var historyButton2 = document.getElementById("historyButton2");
    historyButton2.addEventListener("click", function() {
        window.location.href = "admin_function/records_2.php";
    });
    var logoutButton = document.getElementById("logoutButton");
    logoutButton.addEventListener("click", function() {
        window.location.href = "user_data/end_session.php";
    });
    var logoutButton = document.getElementById("pictureButton");
    logoutButton.addEventListener("click", function() {
        window.location.href = "carousel/upload_event.php";
    });
    // Flag to track whether an AJAX request is in progress
    var isRequestInProgress = false;

    function openModal(imageSrc) {
        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("receiptImage");
        modal.style.display = "block";
        modalImg.src = imageSrc;
    }

    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    function submitForm(id, action, button) {
        // If the action is decline, prompt for a reason
        var reason = "";
        if (action === "decline") {
            reason = prompt("Please enter the reason for declining:");
            if (reason === null || reason.trim() === "") {
                // If no reason is provided, abort the decline action
                return;
            }
        }
        
        // Check if an AJAX request is already in progress
        if (isRequestInProgress) {
            return;
        }
     
        // Disable the buttons to prevent multiple clicks
        var approveButtons = document.querySelectorAll('.approveButton');
        var declineButtons = document.querySelectorAll('.declineButton');
        approveButtons.forEach(function(button) {
            button.disabled = true;
        });
        declineButtons.forEach(function(button) {
            button.disabled = true;
        });

        var formData = new FormData();
        formData.append('selected_id', id);
        formData.append(action, 'true');
        formData.append('reason', reason);  // Add the reason to the form data

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("message").innerHTML = xhr.responseText;
                    // Reload the page after successful submission
                    window.location.reload();
                } else {
                    console.error('Error:', xhr.status);
                }
                // Re-enable the buttons after the AJAX request completes
                approveButtons.forEach(function(button) {
                    button.disabled = false;
                });
                declineButtons.forEach(function(button) {
                    button.disabled = false;
                });
                // Reset the flag
                isRequestInProgress = false;
            }
        };

        xhr.open('POST', 'admin_function/update_approval_2.php', true);
        xhr.send(formData);

        // Set the flag to indicate that an AJAX request is in progress
        isRequestInProgress = true;
    }
    </script>
</body>
</html>
