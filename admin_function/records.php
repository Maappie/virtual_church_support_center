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
    <title>Records Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: rgba(0, 0, 0, 0.7) url('../image/bgimage.jpg');
            background-size: cover;
            background-blend-mode: darken;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        .pamisa-button {
            width: 300px;
            padding: 15px;
            margin: 15px 30px;
            font-size: 16px;
            color: #fff;
            background-image: linear-gradient(150deg, #B621fe, #1fd1f9);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .pamisa-button:hover {
            background-image: linear-gradient(-150deg, #B621fe, #1fd1f9);
            opacity: 0.7;
        }

        .pamisa-button:active {
            opacity: 0.5;
        }

        .receipt-button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #B621fe;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .receipt-button:hover {
            opacity: 0.7;
        }

        .receipt-button:active {
            opacity: 0.5;
        }
        .container {
            width: 100%;
            max-width: 100%;
            margin: 20px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Ensures the table respects the specified column widths */
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            word-wrap: break-word; /* Ensures content wraps within the cell */
        }
        th {
            background-color: #f2f2f2;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.9);
        }
        .modal-content {
            margin: 5% auto;
            padding: 20px;
            width: 80%;
            max-width: 700px;
        }
        .close {
            color: #ccc;
            float: right;
            font-size: 30px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        /* Set specific widths for each column */
        th:nth-child(1), td:nth-child(1) { width: 20%; }
        th:nth-child(2), td:nth-child(2) { width: 20%; }
        th:nth-child(3), td:nth-child(3) { width: 20%; }
        th:nth-child(4), td:nth-child(4) { width: 20%; }
        th:nth-child(5), td:nth-child(5) { width: 8%; }
        th:nth-child(6), td:nth-child(6) { width: 15%; }
        th:nth-child(7), td:nth-child(7) { width: 20%; }
        th:nth-child(8), td:nth-child(8) { width: 20%; }
        th:nth-child(9), td:nth-child(9) { width: 15%; }
        th:nth-child(10), td:nth-child(10) { width: 22%; }
        th:nth-child(11), td:nth-child(11) { width: 15%; }
        th:nth-child(12), td:nth-child(12) { width: 20%; }

        /* Additional CSS to ensure responsiveness */
        @media screen and (max-width: 1500px) {
            th, td {
                font-size: 8px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="../admin_interface.php" method="get">
            <button type="submit" class="pamisa-button">Check Kumpil Request</button>
        </form>
        <h2>Records for Kumpisal</h2>
        <table>
            <tr>
                <th>User Email</th>
                <th>User Full Name</th>
                <th>Sponsor 1</th>
                <th>Sponsor 2</th>
                <th>Age</th>
                <th>Date</th>
                <th>Father's Name</th>
                <th>Mother's Maiden Name</th>
                <th>Purpose</th>
                <th>Contact Number</th>
                <th>Approval</th>
                <th>Action</th>
            </tr>
            <?php
            // Include your database connection file here
            include '../connection.php';

            // Query to select data from the records table
            $sql = "SELECT user_email, user_full_name, sponsor_1, sponsor_2, age, date_column, father_name, mother_maiden_name, purpose_for, contact_number, CONCAT(receipt_code, '_', receipt) AS receipt, approval FROM records";

            // Execute the query
            $result = $conn->query($sql);

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["user_email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["user_full_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["sponsor_1"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["sponsor_2"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["age"]) . "</td>";
                    // Format the date
                    $date = new DateTime($row["date_column"]);
                    $formattedDate = $date->format('F j, Y');
                    echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                    echo "<td>" . htmlspecialchars($row["father_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["mother_maiden_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["purpose_for"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["contact_number"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["approval"]) . "</td>";
                    echo "<td><button onclick='showReceipt(\"../g_cash_receipts/" . htmlspecialchars($row["receipt"]) . "\")' class='receipt-button'>Show Receipt</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No data found in the records table.</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </table>
    </div>

    <!-- Modal for displaying receipt image -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="receiptImage" src="" alt="Receipt" style="max-width: 100%; max-height: 90vh;">
        </div>
    </div>

    <script>
        function showReceipt(imageSrc) {
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("receiptImage");
            modal.style.display = "block";
            modalImg.src = imageSrc;
        }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>
</body>
</html>
