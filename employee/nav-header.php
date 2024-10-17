<?php
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 1) {
header("Location: ../login-register.php");
exit();
}
?>

<style>
    .nav-header{
        background-color: #180161;
        box-shadow: none;
    }
</style>

<div class="nav-header">
            <a href="index" class="brand-logo">
				<i class="fa-solid fa-motorcycle" style="color: #ffffff; font-size: 2rem; background-color: transparent;"></i>
                
				<p class="brand-title" width="124px" height="33px"  style="font-size: 30px; color: white;">Employee</p>
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line" style="background-color: white;"></span><span class="line" style="background-color: white;"></span><span class="line" style="background-color: white;"></span>
                </div>
            </div>
        </div>