<?php 
session_start(); // Start session
// Check if user is logged in
if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="choose_request.css">
</head>
<body>
    <div class="header-container">
        <div class="header">
            <a href="../index.php" class="header-link">National Shrine and Parish of St.Michael and the Archangels</a>
        </div>
        <nav class="nav">
            <a href="../index.php" class="Home">Home</a>
            <a href="../navbar/Aboutus.html">About Us</a>
            <a href="../navbar/Liturgical.html">Liturgical Services</a>
        </nav>
    </div>

    <div class="banner-container">
      <h1>Welcome</h1>
    </div>

    <div class="content-container">
        <div class="user-container">
            <div class="slideshow-container">
                <div class="mySlide fade">
                    <div class="numbertext">1 / 5</div>
                    <img src="../image/carousel_1.jpg" style="width: 100%">
                    <div class="Caption Text">Mass Schedule</div>
                </div>
                <div class="mySlide fade">
                    <div class="numbertext">2 / 5</div>
                    <img src="../image/carousel_2.jpg" style="width: 100%">
                    <div class="Caption Text">Liturgical Service</div>
                </div>
                <div class="mySlide fade">
                    <div class="numbertext">3 / 5</div>
                    <img src="../image/carousel_3.jpg" style="width: 100%">
                    <div class="Caption Text">Liturgical Service</div>
                </div>
                <div class="mySlide fade">
                    <div class="numbertext">4 / 5</div>
                    <img src="../image/carousel_4.jpg" style="width: 100%">
                    <div class="Caption Text">Social Media (facebook)</div>
                </div>
                <div class="mySlide fade">
                    <div class="numbertext">5 / 5</div>
                    <img src="../image/carousel_5.jpg" style="width: 100%">
                    <div class="Caption Text">Social Media (youtube)</div>
                </div>
            
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>
            <div style="text-align: center;">
                <span class="dot" onclick="currentSlides(1)"></span>
                <span class="dot" onclick="currentSlides(2)"></span>
                <span class="dot" onclick="currentSlides(3)"></span>
                <span class="dot" onclick="currentSlides(4)"></span>
                <span class="dot" onclick="currentSlides(5)"></span>
            </div>

            <h1>Our History</h1>
            <div class="wrapper">
                <div class="horizontal-line"></div>
            </div>
            <div class="history-paragraph">
                <div class="text-content">
                    <p>
                        Possibly the first parish in the Philippines to be dedicated to the Archangel is that of San Miguel de Manila, 
                        established in the 1620s, in the quarter known as Dilao, east of Intramuros.
                    </p>
                    <p>
                        San Miguel de Manila has had quite the history, founded in the left bank of the Pasig, 
                        it would cross the river and relocate itself in an area that was a become regal, 
                        because there would rise El Palacio de Malacañang, prime symbol in the Philippines of power and authority.
                    </p>
                    <button class="read-more-btn">Read More</button>
                </div>
                <img src="../image/SU_image.jpg" alt="Historic Image" class="history-image">
            </div>

            <div class="Liturgical">
              <h1>Liturgical Services</h1>
              <div class="Horizontal">
                <div class="Horizontal-line"></div>
              </div>
            </div>

            <div class="first">
              <div class="first-container">
                <h2>Confimation (kumpil)</h2>
                <div class="first-horizontal"></div>
              </div>
            </div>
            <div class="image-content">
              <div class="first-content">
                <img src="../image/picture_info_1.jpg" class="liturgical-image">
                <div class="vertical-line"></div>
                <div class="paragraph liturgical-paragraph">
                  <p>
                    The "Holy Sacrament of Confirmation" refers to the sacrament of Confirmation in the Catholic Church, 
                    particularly in Filipino culture. In the sacrament of Confirmation, 
                    baptized individuals are strengthened by the Holy Spirit through the laying on of hands by a bishop or priest, 
                    and they receive the gifts of the Holy Spirit. This sacrament is considered one of the three sacraments of initiation, 
                    along with Baptism and Eucharist, completing the grace of Baptism.
                  </p>
                  <p>
                    In the Philippines, the term "Kumpil" is often used to refer to Confirmation, especially in colloquial language. 
                    It's an important rite of passage for Catholic individuals, typically occurring during adolescence, 
                    where they affirm and deepen their commitment to the Catholic faith.
                  </p>
                </div>
              </div>
            </div>

            <div class="second">
              <div class="second-container">
                <h2>Online Pamisa</h2>
                <div class="second-horizontal"></div>
              </div>
            </div>
            <div class="image-content">
              <div class="second-content">
                <img src="../image/picture_info_2.jpg" class="liturgical-image">
                <div class="vertical-line"></div>
                <div class="paragraph liturgical-paragraph">
                  <p>
                    "Pamisa" is a Filipino term that refers to a Mass or a religious service, 
                    particularly in the context of commemorating or praying for the souls of the departed. 
                    It's often associated with the Catholic tradition in the Philippines, where families or communities hold Masses for deceased loved ones, 
                    especially during anniversaries of their passing or during special occasions like All Souls' Day.
                  </p>
                  <p>
                    The term "pamisa" is derived from the Spanish word "misa," which means Mass. In the Philippine context, it may also be referred to as "pa-misa" or "pa-siyam," 
                    particularly when a series of nine Masses are offered for the deceased, known as a novena. These Masses are seen as a way to pray for the souls of the departed and to offer comfort and support to their families.
                  </p>
                </div>
              </div>
            </div>

            <div class="request request-container">
              <h2>Proceed with the request:</h2>
              <div class="request-button">
                <a href="../user_interface.php" class="button">Confirmation (kumpil)</a>
                <a href="../user_interface_2.php" class="button">Online Pamisa</a>
              </div>
              <p>Or</p>
              <a href="logout.php" class="button cancel">Log out</a>
            </div>
        </div>
    </div>
    <div class="footer-container">
      <a href="../index.php" class="title">The National Shrine of Saint Michael and the Archangels</a>
      <a href="../index.php">
        <img src="../image/logo.jpg">
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
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>

</body>
</html>