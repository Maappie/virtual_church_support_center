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
    <title>Records from records_2 Table</title>
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
          width: px;
  padding: 10px;
  margin: 15px 30px;
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
            table-layout: fixed;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
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
        th:nth-child(5), td:nth-child(5) { width: 10%; }
        th:nth-child(6), td:nth-child(6) { width: 10%; }
        th:nth-child(7), td:nth-child(7) { width: 10%; }

        /* Additional CSS to ensure responsiveness */
        @media screen and (max-width: 768px) {
            th, td {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="../admin_interface_2.php" method="get">
            <button type="submit" class="pamisa-button">Check Online Pamisa Request</button>
        </form>
        <h2>Records for Online Pamisa</h2>
        <table>
            <tr>
                <th>User Email</th>
                <th>Full Name</th>
                <th>Purpose</th>
                <th>Sponsor</th>
                <th>Approval</th>
                <th>Date</th>
                <th>Show Receipt</th>
            </tr>
            <?php
            // Include your database connection file here
            include '../connection.php';

            // Query to select all data from records_2 table
            $sql = "SELECT * FROM records_2";

            // Execute the query
            $result = $conn->query($sql);

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    // Format the date
                    $date = new DateTime($row["date_column_pamisa"]);
                    $formattedDate = $date->format('F j, Y');
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["user_email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["user_full_name_pamisa"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["purpose_for_pamisa"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["sponsor_pamisa"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["approval"]) . "</td>";
                    echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                    // Button to show receipt image in a modal popup
                    echo '<td><button onclick="openReceipt(\'' . htmlspecialchars($row['receipt_code']) . '\', \'' . htmlspecialchars($row['receipt']) . '\')" class="receipt-button">Show Receipt</button></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }
            ?>
        </table>
    </div>

    <!-- Modal for displaying receipt image -->
    <div id="receiptModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeReceiptModal()">&times;</span>
            <img id="receiptImage" src="" alt="Receipt" style="max-width: 100%; max-height: 90vh;">
        </div>
    </div>

    <script>
        function openReceipt(receiptCode, receiptName) {
            var imagePath = "../g_cash_receipts/" + receiptCode + "_" + receiptName;
            document.getElementById("receiptImage").src = imagePath;
            document.getElementById("receiptModal").style.display = "block";
        }

        function closeReceiptModal() {
            document.getElementById("receiptModal").style.display = "none";
        }
    </script>
</body>


</html>