<?php

session_start();

session_unset();
unset($_SESSION['user_token']);
session_destroy();

header("Location: ../login-register");
exit();
?>
