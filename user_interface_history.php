<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}

// Include database connection file
include 'connection.php';

// Get the user's email from the session
$userEmail = $_SESSION['user_email'];

// Prepare and execute the SQL statement to fetch specific user history data
$sql = "SELECT user_full_name, age, father_name, mother_maiden_name, purpose_for, sponsor_1, sponsor_2, date_column, contact_number, receipt_code, receipt FROM history WHERE user_email = ? AND (user_full_name_pamisa IS NULL OR user_full_name_pamisa = '')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows > 0) {
    // Fetch all results as an associative array
    $historyData = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $historyData = [];
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/user_history_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>User Request History</title>
</head>
<body>

<div class="header-container">
    <div class="header">
        <a href="index.php">National Shrine and Parish of Saint Michael and the Archangels</a>
    </div>
    <nav class="nav">
        <a href="user_interface.php" class="Home-link">Home</a>
        <a href="navbar/Aboutus.html" class="AU-link">About Us</a>
        <a href="navbar/Liturgical.html" class="LS-link">Liturgical Services</a>
    </nav>
</div>

<!-- Logout button -->
<div class="logout-container">
    <form action="functions/logout.php" method="post">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>

<h2>Your Request History</h2>

<main>
<form action="user_interface.php" method="get" class="back-button">
        <button type="submit">Back to Requests</button>
    </form>
    <?php if (!empty($historyData)) : ?>
    <table>
        <thead>
            <tr>
                <th>User Full Name</th>
                <th>Age</th>
                <th>Father's Name</th>
                <th>Mother's Maiden Name</th>
                <th>Purpose</th>
                <th>First Sponsor's Name</th>
                <th>Second Sponsor's Name</th>
                <th>Date of Service</th>
                <th>Contact Number</th>
                <th>Receipt</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($historyData as $row) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row['user_full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['age']); ?></td>
            <td><?php echo htmlspecialchars($row['father_name']); ?></td>
            <td><?php echo htmlspecialchars($row['mother_maiden_name']); ?></td>
            <td><?php echo htmlspecialchars($row['purpose_for']); ?></td>
            <td><?php echo htmlspecialchars($row['sponsor_1']); ?></td>
            <td><?php echo htmlspecialchars($row['sponsor_2']); ?></td>
            <td>
                <?php
                    $date = new DateTime($row['date_column']);
                    echo $date->format('F j, Y');
                ?>
            </td>
            <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
            <td>
                <?php 
                    $receiptPath = "g_cash_receipts/" . htmlspecialchars($row['receipt_code']) . "_" . htmlspecialchars($row['receipt']);
                    if (file_exists($receiptPath)) {
                        echo "<img src='" . $receiptPath . "' alt='Receipt' width='100'>";
                    } else {
                        echo "Receipt not found";
                    }
                ?>
            </td>
        </tr>
<?php endforeach; ?>
    </tbody>
    </table>
<?php else : ?>
    <p class="no-data">No history data found.</p>
<?php endif; ?>

    
</main>

<div class="footer-container">
    <a href="index.php" class="title">The National Shrine of Saint Michael and the Archangels</a>
    <a href="index.php">
        <img src="image/logo.jpg">
    </a>
    <div class="social-container">
        <a href="https://www.youtube.com/@nationalshrineofst.michael3316" class="youtube">
            <i style="font-size:24px" class="fa">&#xf16a;</i>
        </a>
     
        <a href="https://www.facebook.com/sanmiguelnationalshrineofficial" class="facebook">
            <i style="font-size:24px" class="fa">&#xf09a;</i>
        </a>
    </div>
</div>

</body>
</html>
