<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>forgot password</title>
  <link rel="stylesheet" href="styling/forgot_password_popup-style.css">
  <link rel="stylesheet" href="styling/forgot_password-style.css"> 
</head>
<body>
  <div class="container">
    <div class="forgot-box">
      <div class="button back-to-main"> 
        <a href="index.php">&larr;</a>
      </div>
      <div class="lock">
        <div>
          FORGOT PASSWORD
        </div>
        <div class="description">
          <p>
            Enter your registered email to reset your password
          </p>
        </div>
      </div>
      <form id="forgotPasswordForm" method="post">
        <div class="textbox">
          <label for="forgot_email"></label>
          <input type="email" id="forgot_email" name="forgot_email" placeholder="Enter email address" required>
        </div>
        <div class="button reset-button">
          <input type="submit" class="resetButton" id="resetButton" value="Send Verification">
        </div>
        <p id="forgotPasswordMessage" style="color: red;"></p> <!-- Display error message -->
      </form>
    </div>
  </div>

  <script>
    document.getElementById("forgotPasswordForm").addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent form submission
      
      var email = document.getElementById("forgot_email").value;
      var resetButton = document.getElementById("resetButton");
      
      if (!email) {
        document.getElementById("forgotPasswordMessage").textContent = "Email is required.";
        return;
      }

      // Disable the button to prevent multiple submissions
      resetButton.disabled = true;

      // Send AJAX request
      fetch('password/forgot_password.php', {
        method: 'POST',
        body: new FormData(this),
      })
      .then(response => response.text())
      .then(data => {
        document.getElementById("forgotPasswordMessage").textContent = data.trim();
        if (data.trim() === 'Email has been sent.') {
          // Redirect after 2 seconds if email is sent successfully
          setTimeout(function() {
            window.location.href = "password/verify_password.php";
          }, 0);
        }
        // Re-enable the button after the request completes
        resetButton.disabled = false;
      })
      .catch(error => {
        console.error('Error:', error);
        // Re-enable the button in case of an error
        resetButton.disabled = false;
      });
    });

    document.querySelectorAll(".close-button").forEach(function(closeButton) {
      closeButton.addEventListener("click", function() {
        this.closest(".popup").classList.remove("active");
      });
    });

  
  </script>
</body>
</html>
