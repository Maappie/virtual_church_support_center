<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="styling/signup-style.css" />
</head>
<body>
  <div class="container">
    <div class="signup-box">
      <div class="button back-to-main">
        <a href="index.php">&larr;</a>
      </div>
      <div class="title">CREATE ACCOUNT</div>

      <form id="createAccountForm" action="functions/create_account.php" method="post">
        <div class="textbox">
          <label for="user_email"></label>
          <input type="email" id="user_email" name="user_email" pattern="[a-zA-Z0-9._%+-]+@gmail\.com$" placeholder="Email" required />
        </div>
        <div class="textbox">
          <label for="user_password"></label>
          <input
            name="user_password"
            class="password"
            type="password"
            placeholder="Password"
            id="user_password"
            required
          />
          <span class="show">&#128065;</span>
        </div>
        <div class="textbox">
          <label for="confirm_password"></label>
          <input
            class="password"
            type="password"
            placeholder="Confirm Password"
            name="confirm_password"
            id="confirm_password"
            required
          />
          <span class="show">&#128065;</span>
        </div>
        <div class="button create-account">
          <input
            type="submit"
            class="createAccount"
            id="createAccount"
            value="Sign Up"
          />
        </div>
        <p id="message"></p>
      </form>
    </div>
  </div>

  <script>
    var shows = document.querySelectorAll(".textbox .show");
    shows.forEach(function (show) {
      show.addEventListener("click", function () {
        var input = this.previousElementSibling;

        if (input.type === "password") {
          input.type = "text";
          this.innerHTML = "&#128065;";
        } else {
          input.type = "password";
          this.innerHTML = "&#128065;";
        }
      });
    });

    // JavaScript for creating user account
    document.getElementById("createAccountForm").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent form submission

      var signupButton = document.getElementById("createAccount");
      signupButton.disabled = true; // Disable signup button

      var password = document.getElementById("user_password").value;
      var confirmPassword = document.getElementById("confirm_password").value;

      // Password validation regex
      var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s\\~<>])([^\s]){8,}$/;

      if (password !== confirmPassword) {
        document.getElementById("message").textContent = "Passwords do not match. Please Verify";
        signupButton.disabled = false; // Enable signup button
        return;
      }

      // Check if password length is less than 8 characters
      if (password.length < 8) {
        document.getElementById("message").textContent = "Password should be at least 8 characters long";
        signupButton.disabled = false; // Enable signup button
        return;
      }

      if (!passwordRegex.test(password)) {
        if (!/(?=.*[a-z])/.test(password)) {
          document.getElementById("message").textContent = "Please put at least 1 lowercase letter";
          signupButton.disabled = false; // Enable signup button
          return;
        }

        if (!/(?=.*[A-Z])/.test(password)) {
          document.getElementById("message").textContent = "Please put at least 1 uppercase letter";
          signupButton.disabled = false; // Enable signup button
          return;
        }

        if (!/(?=.*\d)/.test(password)) {
          document.getElementById("message").textContent = "Please put at least 1 number";
          signupButton.disabled = false; // Enable signup button
          return;
        }

        if (!/(?=.*[^\w\d\s\\~<>])/.test(password)) {
          // Check for invalid special characters
          var invalidSpecialChars = /[\s\\~<>]/.test(password);
          if (invalidSpecialChars) {
            document.getElementById("message").textContent = "Invalid special character";
          } else {
            document.getElementById("message").textContent = "Please put at least 1 special character";
          }
          signupButton.disabled = false; // Enable signup button
          return;
        }
      }

      // Check for spaces within the password
      if (/\s/.test(password)) {
        document.getElementById("message").textContent = "Password should not contain spaces";
        signupButton.disabled = false; // Enable signup button
        return;
      }

      var form = this;
      var formData = new FormData(form);

      // Send AJAX request
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "functions/create_account.php", true);
      xhr.onload = function() {
        if (xhr.status == 200) {
          document.getElementById("message").innerHTML = xhr.responseText;
          // Check if verification was sent successfully, then redirect
          if (xhr.responseText.trim() === "Verification code sent to your email. Please check your inbox.") {
            window.location.href = "functions/verify_email.php";
          }
          signupButton.disabled = false; // Enable signup button
        }
      };
      xhr.send(formData); 
    });
  </script>
</body>
</html>
