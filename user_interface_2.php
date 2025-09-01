<?php 
session_start(); // Start session
// Check if user is logged in
if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User online pamisa</title>
    <link rel="stylesheet" href="user_interface_2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="header-container">
    <div class="header">
        <a href="index.php">National Shrine and Parish of Saint Michael and the Archangels</a>
    </div>
    <nav class="nav">
        <a href="index.php" class="Home-link">Home</a>
        <a href="navbar/Aboutus.html" class="AU-link">About Us</a>
        <a href="navbar/Liturgical.html" class="LS-link">Liturgical Services</a>
    </nav>
</div>

<main>
    <section class="welcome-section">
        <section class="left-section">
            <h2>Welcome</h2>
            <p>Requirements:</p>
            <ul>
                Send love offering via Gcash
            </ul>
        </section>
    </section>

    <section class="form-section">
    <form action="user_interface_history_2.php" method="get">
            <button type="submit" class="logout-button">Check Request History</button>
        </form>
        <form action="user_interface.php" method="get">
            <button type="submit" class="logout-button">Request for Online Pamisa</button>
        </form>
        <div class="online_pamisa">
            <h2>Online Pamisa Request Form</h2>
            <hr>
        </div>

        <!-- Combined form -->
        <form id="userDataForm" action="user_data/process_data_2.php" method="post" enctype="multipart/form-data" class="data-form">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" placeholder="Your full name" required>
            </div>
            <div class="form-group">
                <label for="reason">For what reason:</label>
                <select id="reason" name="reason" required>
                    <option value="">Select Reason</option>
                    <option value="Thanksgiving">Thanksgiving</option>
                    <option value="Special Intentions">Special Intentions</option>
                    <option value="Souls">Souls</option>
                </select>
            </div>
            <div class="form-group" id="beneficiaryFields">
                <label for="sponsor_name">Primary Beneficiary Full Name:</label>
                <input type="text" id="sponsor_name" name="sponsor_name" placeholder="1st sponsor's name (required)" required>
            </div>
            <div class="form-group">
                <label for="chosen_date">Choose a Date:</label>
                <input type="date" id="chosen_date" name="chosen_date" required>
            </div>
            
            <!-- Add the image after the date input -->
            <img src="image/qr_code.jpg" alt="Image Description" class="date-image">

            <!-- Receipt upload -->
            <div class="form-group">
                <label for="receipt">Upload Gcash Receipt (Required) 09772409731:</label>
                <input type="file" id="receipt" name="receipt" accept=".png, .jpg, .jpeg" required>
            </div>

            <!-- Submit button -->
            <button id="submitButton" type="submit" class="logout-button">Submit</button>
        </form>
        
       
        <!-- Logout button -->
        <form action="functions/logout.php" method="post">
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </section>
</main>

<div class="footer-container">
    <a href="website.html" class="title">The National Shrine of Saint Michael and the Archangels</a>
    <a href="website.html">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current date in the user's timezone
        var currentDate = new Date();
        
        // Get the UTC offset for the Philippines (UTC+8)
        var utcOffset = 8;
        
        // Adjust the current date by adding the UTC offset
        var philippinesDate = new Date(currentDate.getTime() + (utcOffset * 60 * 60 * 1000));
        
        // Format the date as YYYY-MM-DD
        var formattedDate = philippinesDate.toISOString().split('T')[0];
        
        // Set the min attribute of the date input to the adjusted date
        document.getElementById("chosen_date").setAttribute("min", formattedDate);
    });
</script>
</body>
</html>
