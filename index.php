<?php
// Include the connection file
include 'connection.php';

// Define the SQL query
$sql = "SELECT picture_1, picture_2, picture_3, picture_4, picture_5 FROM carousel WHERE id = 1";

// Execute the SQL query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the data from the result set
    $row = $result->fetch_assoc();
    
    
} else {
    // Display an error message if the query fails
    echo "Error: " . $connection->error;
}

// Close the database connection
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website</title>
    <link rel="stylesheet" href="styling/index-style.css"> 
    <link rel="stylesheet" href="styling/index_pop-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body>
  <div class="section1">
    <div class="header-container">
      <div class="header">
        <a href="index.php" class="header-link">National Shrine and Parish of St.Michael and the Archangels</a>
      </div>
      <nav>
        <a href="index.php" class="Home">Home</a>
        <a href="navbar/Aboutus.html">About Us</a>
        <a href="navbar/Liturgical.html">Liturgical Services</a>
      </nav>
    </div>
    
  <h1 class="title">The National Shrine of Saint Michael and the Archangels</h1>

  <div class="button Request-button">
    <button id="loginButton">
      Log In
    </button>
  </div>
  <div class="popup request-form">
    <div class="close-button">&times;</div>
    <div class="form">
        <h2>Log In</h2>
        <div class="form-element">
            <p>to/as</p>
        </div>
        <div class="form-element button-container">
            <button id="requestButton" class="request-button">Request</button>
            <button id="adminButton" class="admin-button">Admin</button>
        </div>
        
    </div>
  </div>

  <p class="signup">
      Don't have an account? <span><a href="signup.php" class="sign-up">Sign up</a></span> here.
  </p>
  <div class="slideshow-container">
    <div class="mySlide fade">
      <div class="numbertext">1 / 5</div>
      <img src="carousel/event_1/<?php echo $row['picture_1']; ?>" style="width: 100%">
      <div class="Caption Text">Mass Schedule</div>
    </div>
    <div class="mySlide fade">
      <div class="numbertext">2 / 5</div>
      <img src="carousel/event_2/<?php echo $row['picture_2']; ?>" style="width: 100%">
      <div class="Caption Text">Event</div>
    </div>
    <div class="mySlide fade">
      <div class="numbertext">3 / 5</div>
      <img src="carousel/event_3/<?php echo $row['picture_3']; ?>" style="width: 100%">
      <div class="Caption Text">Liturgical Service</div>
    </div>
    <div class="mySlide fade">
      <div class="numbertext">4 / 5</div>
      <img src="carousel/event_4/<?php echo $row['picture_4']; ?>" style="width: 100%">
      <div class="Caption Text">Social Media (facebook)</div>
    </div>
    <div class="mySlide fade">
      <div class="numbertext">5 / 5</div>
      <img src="carousel/event_5/<?php echo $row['picture_5']; ?>" style="width: 100%">
      <div class="Caption Text">Social Media (youtube)</div>
    </div>

    <a class="prev" onclick="plusSlides(-1)">&#10094</a>
    <a class="next" onclick="plusSlides(1)">&#10095</a>

  </div>
  <br>
  <div style="text-align: center;">
    <span class="dot" onclick="currentSlides(1)"></span>
    <span class="dot" onclick="currentSlides(2)"></span>
    <span class="dot" onclick="currentSlides(3)"></span>
    <span class="dot" onclick="currentSlides(4)"></span>
    <span class="dot" onclick="currentSlides(5)"></span>
  </div>

  <div class="contain">
    <div class="contact-container">
      <h3>Contact Us</h3>
      <div class="horizontal-line"></div>
      <div class="contact-content">
        <div class="info-element">
          <strong>&#9742;:</strong> (02) 8736 1105 / 09772409731
        </div>
        <div class="info-element">
          <strong>&#9993;:</strong> sanmiguelfgod@gmail.com
        </div>
      </div>
    </div>
    <div class="map-container">
      <h3>Location</h3>
      <div class="horizontal-line"></div>
      <img src="image/maps.jpg" class="map-image">
      <div class="horizontal-line"></div>
      <div class="info-element">
        <strong><span class="fas fa-map-marker-alt"></span>:</strong> 1000 J . P. Laurel St, corner Gen. Solano St, San Miguel, Manila, Metro Manila
      </div>
    </div>
  </div>
</div>

  <div class="footer-container">
    <a href="index.php" class="Title">The National Shrine of Saint Michael and the Archangels</a>
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
  
    
    <script>
        document.querySelector("#loginButton").addEventListener("click", function() {
          document.querySelector(".request-form").classList.add("active");
        });

        document.querySelectorAll(".close-button").forEach(function(closeButton) {
          closeButton.addEventListener("click", function() {
            this.closest(".popup").classList.remove("active");
          });
        });

        document.getElementById("requestButton").addEventListener("click", function() {
          window.location.href = "LoginRequest.html";
        });

        document.getElementById("adminButton").addEventListener("click", function() {
          window.location.href = "LoginAdmin.html";
        });


        
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlides(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlide");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) { slideIndex = 1}
      if (n < 1) {slideIndex = slides.length }
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) { 
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
    }

        
        document.querySelector("#contactUsButton").addEventListener("click", function() {
          document.querySelector(".contact-popup").classList.add("active");
        });

        document.querySelectorAll(".close-Button").forEach(function(closeButton) {
          closeButton.addEventListener("click", function() {
            this.closest(".Popup").classList.remove("active");
          });
        });

 
        
      </script>
</body>
</html>