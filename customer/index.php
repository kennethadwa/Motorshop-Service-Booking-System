<?php
session_start();

include('../connection.php');

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php");
    exit();
}

// Query for total employees
$query_employees = "SELECT COUNT(*) AS total_employees FROM employees";
$result_employees = mysqli_query($conn, $query_employees);
$total_employees = mysqli_fetch_assoc($result_employees)['total_employees'];

// Query for total customers
$query_customers = "SELECT COUNT(*) AS total_customers FROM customers";
$result_customers = mysqli_query($conn, $query_customers);
$total_customers = mysqli_fetch_assoc($result_customers)['total_customers'];

// Query for total bookings
$query_bookings = "SELECT COUNT(*) AS total_bookings FROM booking_request"; 
$result_bookings = mysqli_query($conn, $query_bookings);
$total_bookings = mysqli_fetch_assoc($result_bookings)['total_bookings'];

// Query for total schedules
$query_schedules = "SELECT COUNT(*) AS total_schedules FROM schedule"; 
$result_schedules = mysqli_query($conn, $query_schedules);
$total_schedules = mysqli_fetch_assoc($result_schedules)['total_schedules'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sairom Dashboard</title>
	<link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
	<!-- Style CSS -->
    <link href="css/style.css" rel="stylesheet">

	   <style>
	  body{
		background-color: #17153B;
	  }

			::-webkit-scrollbar {
         width: 18px; 
      }

      ::-webkit-scrollbar-track {
          background: #17153B;
      }
      
      ::-webkit-scrollbar-thumb {
          background-color: #DA0C81; 
          border-radius: 10px; 
          border: 2px solid #DA0C81; 
      }

      ::-webkit-scrollbar-thumb:hover {
          background-color: #555;
      }

      .nav-link{
        color: white;
      }
	</style>
</head>
<body>

<!-- Preloader Start -->
<?php include('pre-loader.php'); ?>
<!-- Preloader End-->

<!-- Main wrapper Start -->
<div id="main-wrapper">
    <!-- Nav Header Start -->
    <?php include('nav-header.php'); ?>
    <!-- Nav Header End -->

    <!-- Header Start -->
    <?php include('header.php'); ?>
    <!-- Header End -->

    <!-- Sidebar Start -->
    <?php include('sidebar.php'); ?>
    <!-- Sidebar End -->

	<!-- Content Body Start -->
	<div class="content-body">
		<div class="container-fluid">
			<div class="row invoice-card-row">

                <nav class="navbar navbar-expand-lg py-3">
                     <div class="container-fluid">
                         <a class="navbar-brand" href="/index.html">Sairom Motorshop</a>
                         <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                             data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                             aria-label="Toggle navigation">
                             <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#about">About Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#strength">Strengths</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#question">Frequent Questions</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <!-- end navbar -->
                   <!-- start hero section -->
                   <section class="text-light p-5 text-center text-sm-start" id="home">
                       <div class="container py-5">
                           <div class="d-sm-flex align-items-center justify-content-between py-5">
                               <div>
                                   <h1 style="color: white;">Welcome to<span class="text-warning"> Sairom Motor Shop</span></h1>
                                   <h3 class="my-4" style="color: white;">Book Your Automotive Services with Ease</h3>
                                   <p class="lead my-4">
                                       We offer top-quality motorcycle repair and maintenance services. Schedule your service booking with us today and ensure your motorcycle is in peak condition. We have been serving the community with trusted and reliable services for more than
                                       <br> <span class="text-warning">18+ years</span>.
                                   </p>
                                   <button class="btn btn-lg" style="box-shadow: 1px 1px 10px black; background: blue; color: white;">Contact Us</button>
                               </div>
               
                               <a href="#">
                                   <img src="img/motor.png" class="img-fluid" alt="" width="1000">
                               </a>
                           </div>
                       </div>
                   </section>
                   <!-- end hero section --> 
                    

                   <!-- Start About Us Section -->
                     <section class="p-5" id="about">
                       <div class="container">
                         <div class="row align-items-center">
                          <h2 style="color: white; text-align: center; margin-bottom: 20px;">About Us</h2>
                           <div class="col-md-6">
                             <img src="img/sairom_page.png" alt="About Us" class="img-fluid" style="max-height: 400px; object-fit: cover;                      border-radius: 10px;">
                           </div>
                           <div class="col-md-6">
                             <p style="color: white;">
                               We are dedicated to providing top-notch automotive services with a focus on customer satisfaction. Our team of skilled                      professionals is here to ensure that your vehicle is well taken care of. With more than 18 years of experience and a                      commitment to excellence, we offer a wide range of services tailored to meet your needs.
                             </p>
                             <a href="https://www.facebook.com/Sairom.Motorshop" target="_blank" class="btn d-flex align-items-center                      justify-content-center" style="background-color: #1877F2; border-color: #1877F2; color: white;">
                               <i class="bi bi-facebook me-2" style="font-size: 1.5rem;"></i> 
                               Contact Us on Facebook
                             </a>
                           </div>
                         </div>
                       </div>
                     </section>
                     <!-- End About Us Section -->

                    
                    <!-- start services section -->
                       <section class="p-5" id="strength">
                         <div class="container py-5">
                           <div class="row text-center g-4">
                             <h1 class="w-100" style="color: white; font-family: Segoe; font-weight: 600; margin-bottom: 20px;">Our Key Strengths</h1>
                        
                             <div class="col-md-6 col-lg-4">
                               <div class="d-flex flex-column p-4 h-100" style="color: white; background: #B8001F; border-radius: 10px;">
                                 <div class="card-body text-center flex-grow-1">
                                   <div class="h1 mb-1">
                                     <i class="bi bi-laptop"></i>
                                   </div>
                                   <h3 class="card-title mb-3" style="color: orange;">User-Friendly Interface</h3>
                                   <p class="card-text">
                                     Our website is designed with you in mind. With an intuitive and user-friendly layout, finding the right service and                            booking your appointment has never been easier. Navigate effortlessly and enjoy a seamless experience every step of                            the way.
                                   </p>
                                 </div>
                               </div>
                             </div>
                        
                             <div class="col-md-6 col-lg-4">
                               <div class="d-flex flex-column p-4 h-100" style="color: white; background: #180161; border-radius: 10px;">
                                 <div class="card-body text-center flex-grow-1">
                                   <div class="h1 mb-1">
                                     <i class="bi bi-person"></i>
                                   </div>
                                   <h3 class="card-title mb-3" style="color: orange;">Efficient Scheduling & Tracking</h3>
                                   <p class="card-text">
                                     We value your time. Our advanced scheduling system allows you to book services quickly, choose from available time                            slots, and track your service status in real-time. Get instant confirmations and stay informed with automated                            reminders, making your experience hassle-free.
                                   </p>
                                 </div>
                               </div>
                             </div>
                        
                             <div class="col-md-6 col-lg-4">
                               <div class="d-flex flex-column p-4 h-100" style="color: white; background: #0A6847; border-radius: 10px;">
                                 <div class="card-body text-center flex-grow-1">
                                   <div class="h1 mb-1">
                                     <i class="bi bi-code-slash"></i>
                                   </div>
                                   <h3 class="card-title mb-3" style="color: orange;">Responsive & Mobile-Friendly Design</h3>
                                   <p class="card-text">
                                     Access our services anytime, anywhere. Our website is fully optimized for all devices, ensuring a smooth and                            responsive experience whether you're booking from your phone, tablet, or desktop. Convenient service booking is just                            a tap away.
                                   </p>
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                      </section>


                       <!-- Accordion Section Start -->
                       <div class="container mt-5" id="question">
                          <h2 class="text-center text-white mb-4">Frequently Asked Questions</h2>
                          <div class="accordion" id="accordionExample">
                      
                              <div class="accordion-item" >
                                  <h2 class="accordion-header" id="headingOne">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"                       aria-expanded="true" aria-controls="collapseOne"  style="background: transparent; color: white; font-size: 1.2rem;                      ">
                                          What type of service do you require for your motorcycle?
                                      </button>
                                  </h2>
                                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"                       data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                          Please specify the type of service you need, such as an oil change, tire rotation, brake inspection, or a                       complete motorcycle check-up. This information helps us allocate the right resources and ensure that your                       motorcycle receives the best possible care.
                                      </div>
                                  </div>
                              </div>
                      
                              <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingTwo">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"                       aria-expanded="false" aria-controls="collapseTwo" style="background: transparent; color: white; font-size: 1.2rem;                      ">
                                          What is the make and model of your motorcyle?
                                      </button>
                                  </h2>
                                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"                       data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                          Please provide the make and model of motorcycle. This information is crucial for us to assess your service                       requirements accurately and ensure that we have the necessary parts and equipment available for your specific                       motorcycle.
                                      </div>
                                  </div>
                              </div>
                      
                              <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingThree">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"                       aria-expanded="false" aria-controls="collapseThree" style="background: transparent; color: white; font-size: 1.                      2rem;">
                                          What is your preferred date and time for the service appointment?
                                      </button>
                                  </h2>
                                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"                       data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                          Kindly indicate your preferred date and time for your service appointment. We strive to accommodate your                       schedule and provide you with timely and efficient service. If your requested time is unavailable, we will                       offer alternative options.
                                      </div>
                                  </div>
                              </div>
                      
                              <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingThree">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"                       aria-expanded="false" aria-controls="collapseThree" style="background: transparent; color: white; font-size: 1.                      2rem;">
                                          What is your preferred mode of payment for the service?
                                      </button>
                                  </h2>
                                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"                       data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                          We accept multiple payment methods for your convenience. However, if you prefer to use PayPal, please select                       it as your payment option during the booking process. Utilizing PayPal ensures a secure and efficient                       transaction, allowing you to complete your payment swiftly and easily. Should you have any questions regarding                       the payment process, feel free to reach out for assistance.
                                      </div>
                                  </div>
                              </div>
                      
                          </div>
                       </div>
                       <!-- Accordion Section End -->
                </div>
            </div>
		</div>
	</div>
	<!-- Content Body End -->
</div>
<!-- Main wrapper end -->

<!-- Scripts -->
<!-- Required vendors -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>

<!-- Apex Chart -->
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>

<!-- Dashboard 1 -->
<script src="js/dashboard/dashboard-1.js"></script>

<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>
	
</body>
</html>