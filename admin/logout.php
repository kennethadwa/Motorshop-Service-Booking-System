<?php
// Start session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login-register.php
header("Location: ../login-register.php");
exit();
?>
