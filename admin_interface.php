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
        <title>Admin Interface</title>
        <link rel="stylesheet" href="styling_admin/admin_interface-style.css">
    </head>
    <body>
        
        <div class="fixed-container">
            <h1 class="title">
                National Shrine of St. Michael and the Archangels
            </h1>
            <img class="portrait-image" src="image/background.jpg" alt="Portrait Image">
            <button class="button pamisa-button" id="onlineMassPendingButton">Check Online Mass Pendings</button>
            <button class="button logout-button" id="historyButton">Check Records</button>
            <button class="button logout-button" id="pictureButton">Upload Pictures</button>
            <button class="button logout-button" id="logoutButton">Logout</button>
            <script>
                var onlineMassPendingButton = document.getElementById("onlineMassPendingButton");
                onlineMassPendingButton.addEventListener("click", function() {
                    window.location.href = "admin_interface_2.php";
                });
                var logoutButton = document.getElementById("logoutButton");
                logoutButton.addEventListener("click", function() {
                    window.location.href = "user_data/end_session.php";
                });
                var logoutButton = document.getElementById("historyButton");
                logoutButton.addEventListener("click", function() {
                    window.location.href = "admin_function/records.php";
                });
                var logoutButton = document.getElementById("pictureButton");
                logoutButton.addEventListener("click", function() {
                    window.location.href = "carousel/upload_event.php";
                });
            </script>
        </div>
       <div class="container">
        <div class="content-box">
            <h1 class="welcome">Welcome, <?php echo $_SESSION['admin_username']; ?>! <br> Kumpil</h1>

            <!-- Display pending requests in a table -->
            <?php
            include 'connection.php';

            // Query to select rows where pending is true
            $sql = "SELECT * FROM history WHERE pending = 1";

            // Execute the query
            $result = $conn->query($sql);

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Display the pending requests in a table
                echo "<p>Pending Requests for Kumpil:</p>";
                echo "<table>";
                echo "<tr><th>User Full Name</th><th>Email</th><th>Purpose</th><th>Date of Service</th><th>Age</th><th>Contact Number</th><th>Father's Name</th><th>Mother's Maiden Name</th><th>First Sponsor's Name</th><th>Second Sponsor's Name</th><th>Receipt</th><th>Action</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    // Format the date to "Month Day, Year"
                    $formatted_date = date("F j, Y", strtotime($row['date_column']));
                    echo "<tr>";    
                    echo "<td>" . htmlspecialchars($row['user_full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['purpose_for']) . "</td>";
                    echo "<td>" . htmlspecialchars($formatted_date) . "</td>";
                    echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['father_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mother_maiden_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sponsor_1']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sponsor_2']) . "</td>";
                    // Button to show receipt image in a modal
                    echo "<td><button onclick='openModal(\"g_cash_receipts/" . htmlspecialchars($row['receipt_code']) . "_" . htmlspecialchars($row['receipt']) . "\")' type='button'>Show Receipt</button></td>";
                    // Buttons for approving and declining
                    echo "<td><button type='button' onclick='submitForm(" . htmlspecialchars($row['id']) . ", \"approve\", this)' class='approveButton'>Approve</button>";
                    echo "<button type='button' onclick='submitForm(" . htmlspecialchars($row['id']) . ", \"decline\", this)' class='declineButton'>Decline</button></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                // If no pending requests found
                echo "<p>No pending requests for kumpil at the moment</p>";
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
        </div>
        <script>
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
                // Check if an AJAX request is already in progress
                if (isRequestInProgress) {
                    return;
                }

                // If the action is decline, prompt for a reason
                var reason = "";
                if (action === "decline") {
                    reason = prompt("Please enter the reason for declining:");
                    if (reason === null || reason.trim() === "") {
                        // If no reason is provided, abort the decline action
                        return;
                    }
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
                if (reason) {
                    formData.append('reason', reason);
                }

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById("message").innerHTML = xhr.responseText;
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

                xhr.open('POST', 'admin_function/update_approval.php', true);
                xhr.send(formData);

                // Set the flag to indicate that an AJAX request is in progress
                isRequestInProgress = true;
            }
        </script>

    </body>
    </html>
