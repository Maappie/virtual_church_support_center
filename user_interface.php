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
    <link rel="stylesheet" href="user_interface.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>User</title>
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
<section class="left-section">
        <h2>Welcome</h2>
        <p>Requirements:</p>
        <ul>
            <li>Recently issued two (2) copies of Baptismal Certificates within six (6) months</li>
            <li>First communion done</li>
            <li>Fully accomplished registration form</li>
            <li>Send love offering via Gcash</li>
        </ul>
        <p>FOR AGES 12-21 YEARS OLD WHO ARE NOT RESIDING IN THE PHILIPPINES ADDITIONAL:</p>
        <ul>
            <li>Permission letter from the current parish priest</li>
            <li>Certificate of attendance for catechism</li>
            <li>Baptismal certificate with annotation for confession</li>
        </ul>
    </section>

    <section class="form-section">
    <div class="confirmation">
    <form action="user_interface_history.php" method="get">
            <button type="submit" class="logout-button">Check Request History</button>
        </form> 
    <form action="user_interface_2.php" method="get">
            <button type="submit" class="logout-button">Request for Online Pamisa</button>
        </form> <h2>Confirmation Request Form</h2>
       
    <hr>
</div>

        <!-- Main form -->
        <form id="userDataForm" action="user_data/process_data.php" method="post" enctype="multipart/form-data" class="data-form">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" placeholder="Your full name" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="text" id="age" name="age" required min="0">
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" pattern="[0-9]{11}" required>
                <small>Enter a 11-digit phone number</small>
            </div>
            <div class="form-group">
                <label for="sponsor_name">Sponsor's Full Name:</label>
                <input type="text" id="sponsor_name" name="sponsor_name" placeholder="1st sponsor's name(required)" required>
            </div>
            <div class="form-group">
                <label for="second_sponsor_name">Second Sponsor's Full Name:</label>
                <input type="text" id="second_sponsor_name" name="second_sponsor_name" placeholder="2nd sponsor's name(optional)" >
            </div>
            <div class="form-group">
                <label for="father_name">Father's Name:</label>
                <input type="text" id="father_name" name="father_name" placeholder="Your father's name" required>
            </div>
            <div class="form-group">
                <label for="mother_maiden_name">Mother's Maiden Name:</label>
                <input type="text" id="mother_maiden_name" name="mother_maiden_name" placeholder="Your mother's name" required>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose of Request:</label>
                <select id="purpose" name="purpose" required>
                    <option value="">Select Purpose</option>
                    <option value="confirmation purpose">Confirmation Purpose</option>
                    <option value="marriage purpose">Marriage Purpose</option>
                </select>
            </div>
            <div class="form-group">
                <label for="chosen_date">Choose a Date (Sunday):</label>
                <input type="date" id="chosen_date" name="chosen_date" required>
            </div>
            <img src="image/qr_code.jpg" alt="Image Description" class="date-image">

            <div class="form-group">
                <label for="receipt">Upload Gcash Receipt (Required) 09772409731:</label>
                <input type="file" id="receipt" name="receipt" accept=".png, .jpg, .jpeg" required>
            </div>
            
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

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get today's date
        var today = new Date();
        // Calculate the date after seven days
        var sevenDaysLater = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000);
        // Calculate the next Sunday after seven days
        var nextSunday = new Date(sevenDaysLater);
        nextSunday.setDate(sevenDaysLater.getDate() + (7 - nextSunday.getDay()));
        
        // Set the minimum date to be seven days later
        var minDate = sevenDaysLater.toISOString().split("T")[0];
        document.getElementById("chosen_date").min = minDate;

        // Function to check if a given date is Sunday
        function isSunday(date) {
            return date.getDay() === 0; // 0 represents Sunday
        }

        // Function to set the selected date to the next Sunday
        function setToNextSunday(input) {
            var selectedDate = new Date(input.value);
            // Check if the selected date is Sunday, if not, clear and set it to the next Sunday
            if (!isSunday(selectedDate)) {
                alert("Please choose a Sunday.");
                input.value = "";
            }
        }

        // Add event listener to the chosen_date input to enforce Sunday selection
        document.getElementById("chosen_date").addEventListener("change", function () {
            setToNextSunday(this);
        });

        // Set the initial value of the chosen date input to the next Sunday
        document.getElementById("chosen_date").value = nextSunday.toISOString().split("T")[0];
    });
</script>

</body>
</html>


