<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="login-register.css">
  <title>Login to Sairom</title>
</head>

<body >

<div class="container" id="container">
 
<!-- SIGN UP FORM -->
<div class="form-container sign-up">
  <form action="auth-signup.php" method="post">
    <h1>Sign Up</h1>
    <span>please enter a valid email for registration</span>
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Valid Email Address" required>
    <input type="number" name="contact" placeholder="Phone Number" required>
    <button type="submit">Sign Up</button>
  </form>
</div>
    
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
    <button type="submit">Sign In</button>
  </form>
</div>
    
<!-- TOGGLE PANEL -->
<div class="toggle-container">
  <div class="toggle">
    <div class="toggle-panel toggle-left">
      <h3>Already have an account?</h3>
      <p>Enter your personal details to use all of the site features</p>
      <button class="hidden" id="login">Sign In</button>
    </div>
    <div class="toggle-panel toggle-right">
      <h3>Don't have an account?</h3>
      <p>Register with your personal details to use all of the site features</p>
      <button class="hidden" id="register">Sign Up</button>
    </div>
  </div>
</div>
    
</div>

  <script src="./js/login.js"></script>
  <script src="https://apis.google.com/js/platform.js" async defer></script>

</body>

</html>
