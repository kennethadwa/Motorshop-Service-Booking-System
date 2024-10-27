<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="login-register.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <title>Login to Sairom</title>
  <script>
    function enableSignInButton(){
      document.getElementById("signinBtn").disabled = false;
    }
  </script>
  <style>
    #signinBtn:disabled {
      background-color: lightgray;
      color: darkgray; 
      cursor: not-allowed; 
      opacity: 0.7;
      border: none; 
    }
  </style>
</head>

<body>
<div class="container" id="container">
 
<!-- SIGN IN FORM -->
<div class="form-container sign-in">
  <form action="auth-login.php" method="post">
    <h1>Sign In</h1>
    <div class="social-icons">
      <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
      <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
    </div>
    <span>or use your email password</span>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <a href="forget_password.php">Forget Your Password?</a>
    <button type="submit" id="signinBtn" disabled="disabled" style="background: blue;">Sign In</button>
    <br>
    <br>
    <div class="g-recaptcha" data-sitekey="6LddpWYqAAAAAATb2j9nEwQHOoKbO7_Zpn4RNblC" data-callback="enableSignInButton"></div>
  </form>
</div>

</div>

<script src="./js/login.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>

</body>
</html>
