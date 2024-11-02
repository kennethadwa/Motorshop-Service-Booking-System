<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sairom Motor Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(15, 20, 35);
            margin: 0;
            padding: 0;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-nav .nav-link {
            font-size: 1rem;
            margin: 0 5px;
        }
        .hero {
            background-color: #f8f9fa;
            padding: 60px 20px;
            text-align: center;
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }
        .footer p {
            margin: 0;
            font-size: 0.9rem;
        }
        .about-img {
            max-width: 100%;
            height: auto;
        }
        .team-member {
            text-align: center;
        }
        .team-member img {
            max-width: 100%;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top" style="background: rgb(15, 20, 35);">
    <div class="container">
        <a class="navbar-brand" href="#" style="color: white;">Sairom Motor Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home" style="color: white;">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about" style="color: white;">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#services" style="color: white;">Why Us?</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq" style="color: white;">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact" style="color: white;">Contact</a></li>
                &nbsp;
                <li class="nav-item"><a class="btn btn-outline-primary me-2" href="login-register.php">Sign In</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="home" class="hero" style="background-image: url('./images/sairom.png'); height: auto; height: 100%;">
    <div class="container" style="height: 500px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <div style="background: rgba(0, 0, 0, 0.7); padding: 15px; border-radius: 10px;">
        <h1 style="font-family: segoe; color: white; text-shadow: 2px 2px 10px black; font-weight: bold; font-size: 3rem;">Welcome to Sairom Motor Shop</h1>
        <p style="font-family: segoe; color: white; text-shadow: 2px 2px 10px black; font-size: 1rem;">Your trusted partner in automotive services and repairs.</p>
    </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5 mt-5" style="height:auto; width: 100%; background: rgb(15, 20, 35); color: white;">

    <div class="container" style="height: auto;">
         <h2 class="section-title" style="text-align: center;">About Us</h2>

        <div class="row align-items-center" style="display: flex; justify-content: center;">

            <div class="col-md-6" style="height: 450px; display: flex; justify-content: center;">
                <img src="./images/about.png" alt="About Us" class="about-img" style="height: 100%; width: 80%;">
            </div>


            <div class="col-md-6" style="display: flex; height: 450px; flex-direction: column; justify-content: center; line-height: 3;">
                <p>We are dedicated to providing top-notch automotive services with a focus on customer satisfaction. Our team of skilled professionals is here to ensure that your vehicle is well taken care of. With more than 18 years of experience and a commitment to excellence, we offer a wide range of services tailored to meet your needs.</p>
            </div>


        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5 mt-5" style="height: auto; width: 100%; background: rgb(15, 20, 35); color: white;">
    <div class="container" style="height: auto">
        <h1 class="section-title" style="font-weight: bold;">Our Services</h1>
        <br>
        <br>
        <div id="servicesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
            <div class="carousel-inner">
                <div class="carousel-item active" style="height: auto;">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="service-card" style="border: 1px solid rgba(255, 0, 0, 1); background: rgba(255, 0, 0, 0.1); height: 100%; max-width: 700px; padding: 15px;">
                            <h2 style="text-align:center; font-family: segoe;">User-Friendly Interface</h2>
                            <br>
                            <p style="text-align:center; font-family: segoe; font-size: 1.5rem;">Our website is designed with you in mind. With an intuitive and user-friendly layout, finding the right service and booking your appointment has never been easier. Navigate effortlessly and enjoy a seamless experience every step of the way.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="height: auto;">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="service-card" style="border: 1px solid rgba(20, 255, 0, 1); background: rgba(0, 255, 0, 0.1); height: 100%; max-width: 700px; padding: 15px;">
                            <h2 style="text-align:center; font-family: segoe;">Efficient Scheduling & Tracking</h2>
                            <br>
                            <p style="text-align:center; font-family: segoe; font-size: 1.5rem;">We value your time. Our advanced scheduling system allows you to book services quickly, choose from available time slots, and track your service status in real-time. Get instant confirmations and stay informed with automated reminders, making your experience hassle-free.</p>
                        </div>
                    </div>
                </div>


                <div class="carousel-item" style="height: auto;">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="service-card" style="border: 1px solid rgba(0, 0, 255, 1); background: rgba(0, 0, 255, 0.1); height: 100%; max-width: 700px; padding: 15px;">
                            <h2 style="text-align:center; font-family: segoe;">Responsive & Mobile-Friendly Design</h2>
                            <br>
                            <p style="text-align:center; font-family: segoe; font-size: 1.5rem;">Access our services anytime, anywhere. Our website is fully optimized for all devices, ensuring a smooth and responsive experience whether you're booking from your phone, tablet, or desktop. Convenient service booking is just a tap away.</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>   
            </button>
        </div>
    </div>
</section>


<!-- FAQ Section -->
<section id="faq" class="py-5 mt-5" style="background: rgb(15, 20, 35); height: 500px;">
    <div class="container">
        <h1 class="section-title" style="color: white;">Frequently Asked Questions</h1>
        <br>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h4>What type of service do you require for your motorcycle?</h4>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Please specify the type of service you need, such as an oil change, tire rotation, brake inspection, or a complete motorcycle check-up. This information helps us allocate the right resources and ensure that your motorcycle receives the best possible care.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4>What is the make and model of your motorcyle?</h4>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Please provide the make and model of motorcycle. This information is crucial for us to assess your service requirements accurately and ensure that we have the necessary parts and equipment available for your specific motorcycle.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4>What is your preferred date and time for the service appointment?</h4>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Kindly indicate your preferred date and time for your service appointment. We strive to accommodate your schedule and provide you with timely and efficient service. If your requested time is unavailable, we will offer alternative options.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4>What is your preferred mode of payment for the service?</h4>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>We accept multiple payment methods for your convenience. However, if you prefer to use PayPal, please select it as your payment option during the booking process. Utilizing PayPal ensures a secure and efficient transaction, allowing you to complete your payment swiftly and easily. Should you have any questions regarding the payment process, feel free to reach out for assistance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Contact Section -->
<section id="contact" class="py-5 mt-5" style="background: rgb(15, 20, 35);">
    <div class="container">
        <h2 class="section-title" style="color: white; font-weight: bold;">Contact Us</h2>
        <a href="https://www.facebook.com/Sairom.Motorshop" target="_blank" class="btn d-flex align-items-center justify-content-center" style="background-color: #1877F2; padding: 15px 0; width: auto; border-color: #1877F2;color: white;"><i class="fa-brands fa-facebook"></i>&nbsp; &nbsp;Contact us on our Facebook Page</a>
    </div>
</section>

<!-- Footer -->
<footer class="footer" style="background: black;">
    <div class="container">
        <p>&copy; 2024 Sairom Motor Shop. All rights reserved.</p>
    </div>
</footer>

<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
