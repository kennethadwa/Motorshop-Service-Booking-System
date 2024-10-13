<?php
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
header("Location: ../login-register.php");
exit();
}
?>

<div id="preloader">
    <div class="waviy">
			<div class="d-flex justify-content-center mb-3">
			 <span style="--i:1">S</span>
		   <span style="--i:2">A</span>
		   <span style="--i:3">I</span>
		   <span style="--i:4">R</span>
		   <span style="--i:5">O</span>
		   <span style="--i:6">M</span>
			</div>
		   
			<div class="d-flex justify-content-center mb-3">
			 <span style="--i:7">M</span>
		   <span style="--i:8">O</span>
		   <span style="--i:9">T</span>
		   <span style="--i:10">O</span>
			 <span style="--i:11">R</span>
			 <span style="--i:12">S</span>
			 <span style="--i:13">H</span>
			 <span style="--i:14">O</span>
			 <span style="--i:15">P</span>
			</div>
		   
		</div>
    </div>