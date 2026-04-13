<!DOCTYPE html>
<html lang="en">
<head>   
</head>
<body style="background-color: #fff;">
    <!--including navbar  -->
<?php include 'navbar.php' ?>
    <div class="hero-slider">
        <div class="slide active" style="background-image: url('images/vaccine14.jpg')">
            <div class="slide-overlay">
                <div class="container slide-content align-items-left">
                <h1 class="slide-title">Book Now</h1>
                <p class="slide-subtitle">Book your home vaccination now.</p>
                <a href="login.php" class="slide-btn">Book Now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonials Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--dark-color);">Our Vaccination Services</h2>

            <div class="row g-4">
                <!-- Childhood Vaccines Card -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-wrapper mb-4" style="color: var(--primary-color);">
                                <i class="fas fa-baby fa-3x"></i>
                            </div>
                            <h3 class="h4 mb-3" style="color: var(--dark-color);">Childhood Vaccines</h3>
                            <p class="mb-4">Childhood vaccines are essential for protecting children from various infectious diseases.</p>
                            <a href="./vaccines.php" class="btn btn-details">Details</a>
                        </div>
                    </div>
                </div>

                <!-- Booking Process Card -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-wrapper mb-4" style="color: var(--primary-color);">
                                <i class="fas fa-calendar-check fa-3x mb-3"></i>
                            </div>
                            <h3 class="h4 mb-3" style="color: var(--dark-color);">Easy Booking Process</h3>
                            <p class="mb-4">Simple 3-step process: Book online → Our team visits your home → Child gets vaccinated safely</p>
                            <a href="./login.php" class="btn btn-book">Book Now</a>
                        </div>
                    </div>
                </div>

                <!-- Home Vaccination Benefits Card -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-wrapper mb-4" style="color: var(--primary-color);">
                                <i class="fas fa-home fa-3x mb-3"></i>
                            </div>
                            <h3 class="h4 mb-3" style="color: var(--dark-color);">Home Vaccination Benefits</h3>
                            <p class="mb-4">Safe, convenient, and stress-free vaccination in the comfort of your home by certified professionals.</p>
                            <a href="./login.php" class="btn btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fixed Quote Section -->
    <section class="py-5" style="background-color: #148ba9;">
        <div class="container">
            <div class="text-center text-white py-4">
                <!-- Quote Icon -->
                <i class="fas fa-quote-left fa-3x mb-4" style="opacity: 0.3; color: white;"></i>

                <!-- Quote Text -->
                <p class="fs-4 fst-italic fw-light mb-4" style="color: white;">
                    "Excellent service in these days of pandemic, got my child vaccinated at home. The doctor came in proper PPE. Highly recommended."
                </p>

                <!-- Author -->
                <h4 class="fw-bold" style="color: white;">- Ali</h4>
            </div>
        </div>
    </section>


    <!-- Testimonials Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Testimonial 1: Free Consultation -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-wrapper mb-4" style="color: #148ba9;">
                                <i class="fas fa-comment-medical fa-3x"></i>
                            </div>
                            <h3 class="h4 mb-3" style="color: #002d38;">Free Consultation</h3>
                            <p class="mb-4">Consult your vaccine schedule with our Healthcare Worker. It is important that you know your kids next vaccines.</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2: WHO Standards -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-wrapper mb-4" style="color: #148ba9;">
                                <i class="fas fa-certificate fa-3x"></i>
                            </div>
                            <h3 class="h4 mb-3" style="color: #002d38;">WHO Standards</h3>
                            <p class="mb-4">From procurement to storage and from base point to your kids, we follow WHO standards to maintain and administer vaccines.</p>

                        </div>
                    </div>
                </div>

                <!-- Testimonial 3: Digital Certificates -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-wrapper mb-4" style="color: #148ba9;">
                                <i class="bi bi-file-earmark-medical fa-3x mb-3"></i>
                            </div>
                            <h3 class="h4 mb-3" style="color: #002d38;">Digital Certificates</h3>
                            <p class="mb-4">Get official digital vaccination certificates for school admission and medical records. Download anytime from your dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FAQs Section -->
    <section class="faq-section py-5 bg-white">
        <div class="container-fluid">
            <div class="container">
                <div class="d-flex flex-column align-items-center mb-5">
                    <div class="vertical-line mb-4" style="width: 4px; height: 60px; background-color: #148ba9;"></div>
                    <!-- Header -->
                    <div class="faq-header text-center mb-5">
                        <h1 class="fw-bold">FAQs</h1>
                        <p class="text-muted">Frequently Asked Questions</p>
                    </div>
                </div>

                <div class="row">
                    <!-- Left Column - Accordion -->
                    <div class="col-lg-6">
                        <div class="accordion" id="faqAccordion">
                            <!-- Question 1 -->
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-light rounded shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        <i class="bi bi-plus me-2"></i> How do I schedule a home vaccination?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        You can schedule a home vaccination through our website by registering yourself & selecting your preferred date and time.
                                    </div>
                                </div>
                            </div>

                            <!-- Question 2 -->
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-light rounded shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        <i class="bi bi-plus me-2"></i> What safety measures do you follow?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Our healthcare professionals follow strict safety protocols including wearing full PPE.
                                    </div>
                                </div>
                            </div>

                            <!-- Question 3 -->
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-light rounded shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        <i class="bi bi-plus me-2"></i> Which vaccines are available?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        We provide all standard childhood immunizations.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Column - Features -->
                    <div class="col-lg-6">
                        <div class="row g-4">
                            <!-- Row 1 -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-chat-square-text fs-4 me-3" style="color: #148ba9;"></i>
                                    <div>
                                        <h5 class="fw-bold">Free Consultation</h5>
                                        <p class="text-muted small">Get professional advice</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle fs-4 me-3" style="color: #148ba9;"></i>
                                    <div>
                                        <h5 class="fw-bold">Refined Quality</h5>
                                        <p class="text-muted small">Highest standard supplies</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-shield-check fs-4 me-3" style="color: #148ba9;"></i>
                                    <div>
                                        <h5 class="fw-bold">Authorized Resources</h5>
                                        <p class="text-muted small">Approved vaccines only</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-globe fs-4 me-3" style="color: #148ba9;"></i>
                                    <div>
                                        <h5 class="fw-bold">WHO Standards</h5>
                                        <p class="text-muted small">International guidelines</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-house fs-4 me-3" style="color: #148ba9;"></i>
                                    <div>
                                        <h5 class="fw-bold">Home Vaccinations</h5>
                                        <p class="text-muted small">Convenient service</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-calendar-check fs-4 me-3" style="color: #148ba9;"></i>
                                    <div>
                                        <h5 class="fw-bold">Online Scheduling</h5>
                                        <p class="text-muted small">Book appointments 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Consultation Section -->
    <section class="consultation-section py-5" style="background-color: #f8f9fa;">
        <div class="container-fluid">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <!-- First Column - Heading -->
                    <div class="col-md-4 px-4 py-3">
                        <h3 class="fw-bold mb-1">Free Consultation!</h3>
                        <p class="text-muted mb-0">From Child Specialist</p>
                    </div>

                    <!-- Second Column - Email -->
                    <div class="col-md-4 px-4 py-3">
                        <a href="mailto:consult@kvbs.pk" class="email-link" style="color: #148ba9; font-size: 1.1rem; text-decoration: none;">
                            <i class="bi bi-envelope-fill me-2"></i> consult@kvbs.pk
                        </a>
                    </div>

                    <!-- Third Column - Book Now Button -->
                    <div class="col-md-4 px-4 py-3">
                        <a href="./login.php" class="btn btn-book bi bi-calendar-check me-2"> BOOK NOW </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Three Column Section -->
    <section class="info-section py-5 bg-white">
        <div class="container-fluid">
            <div class="container">
                <div class="d-flex flex-column align-items-center mb-5">
                    <div class="vertical-line mb-4" style="width: 4px; height: 60px; background-color: #148ba9;"></div>
                    <!-- Header -->
                    <div class="faq-header text-center mb-5">
                        <h1 class="fw-bold">How we work</h1>
                        <p class="text-muted">Our work is our trademark!</p>
                    </div>
                </div>

                <!-- First Row -->
                <div class="row mb-4">
                    <div class="col-md-8 mb-4 mb-md-0">
                        <img src="images/vaccine41.jpg" alt="Vaccination Process" class="img-fluid rounded shadow w-100" style="height: 300px; object-fit: cover;">
                    </div>

                    <!-- Column 3 - Card -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body p-4">
                                <h3 class="display-4 fw-bold" style="color: #148ba9;">01</h3>
                                <h4 class="mb-3">Check Your Schedule</h4>
                                <p class="mb-0">It is always important that you check your vaccine schedule, if it is due. If you need any help or have any questions please ask us. Consultation is FREE.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row - Cards -->
                <div class="row">
                    <!-- Card 02 -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body p-4">
                                <h3 class="display-4 fw-bold" style="color: #148ba9;">02</h3>
                                <h4 class="mb-3">Book Appointment</h4>
                                <p class="mb-0">Parents are facing difficulties regarding their kids' vaccination. But now it is not a thing of worry. Choose the time of your choice and make an appointment now.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 03 -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body p-4">
                                <h3 class="display-4 fw-bold" style="color: #148ba9;">03</h3>
                                <h4 class="mb-3">Keep The Kid Ready</h4>
                                <p class="mb-0">Vaccination is always considered a process of stress and discomfort. But at home kids always feel less stress. You just need to keep your kid ready.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 04 -->
                    <div class="col-md-4">
                        <div class="card border-0 h-100" style="background-color: #148ba9;">
                            <div class="card-body p-4">
                                <h3 class="display-4 fw-bold" style="color: rgba(255,255,255,0.8);">04</h3>
                                <h4 class="mb-3 text-white">Finish Vaccination</h4>
                                <p class="mb-0 text-white" style="opacity: 0.8;">Experienced healthcare staff will finish the vaccination of kid with minimal contact and maximum protection ensuring your comfort and calm.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Stay Safe Section -->
    <section class="stay-safe-section py-5 bg-white">
        <div class="container-fluid">
            <div class="container">
                <div class="row align-items-center">
                    <!-- First Column - Headings -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h3 class="fw-bold mb-3" style="color: #148ba9;">While you are staying home!</h3>
                        <h2 class="fw-bold mb-4">We are making sure that you stay safe and stay immunized.</h2>
                    </div>

                    <!-- Second Column - Text Paragraphs -->
                    <div class="col-lg-6">
                        <p class="text-muted mb-4" style="color: rgba(0, 0, 0, 0.7);">
                            All our vaccines are sourced from multinational companies. All vaccines are stored and transported as per WHO standards from points of origin.
                        </p>
                        <p class="text-muted mb-4" style="color: rgba(0, 0, 0, 0.7);">
                            All vaccines are consulted with experienced child specialists and administered by vaccination experts.
                        </p>
                        <p class="text-muted" style="color: rgba(0, 0, 0, 0.7);">
                            Vaccination schedules and cards are issued with strong post vaccination followup.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section with Column Spacing -->
    <footer class="footer-section py-5" style="background-color: #148ba9;">
        <div class="container-fluid">
            <div class="container">
                <div class="row justify-content-center">
                    <!-- First Column - Heading -->
                    <div class="col-md-4 mb-4 mb-md-0 px-lg-4 px-xl-5">
                        <h3 class="text-white" style="opacity: 0.8; font-size: 1.5rem;">KVBS</h3>
                        <h2 class="text-white fw-bold mt-2">Home Vaccination!</h2>
                    </div>

                    <!-- Second Column - Text -->
                    <div class="col-md-4 mb-4 mb-md-0 px-lg-4 px-xl-5 d-flex align-items-center">
                        <p class="text-white mx-auto" style="opacity: 0.8; max-width: 400px;">
                            No need to travel all the way to the hospital and wait for your turn. At KVBS, we are providing you quality vaccination services at your door step!
                        </p>
                    </div>

                    <!-- Third Column - Email & Button -->
                    <div class="col-md-4 px-lg-4 px-xl-5">
                        <div class="d-flex flex-column align-items-center">
                            <a href="#" class="text-white mb-3" style="opacity: 0.8; text-decoration: none; font-size: 1.1rem;">
                                info@kvbs.com
                            </a>
                            <a href="login.php" class="btn btn-light">
                                <i class="bi bi-envelope me-2"></i> Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php include 'footer.php'?>

    <script>
        // Accordion Icon Toggle Script
document.addEventListener('DOMContentLoaded', function () {
    const accordionButtons = document.querySelectorAll('.accordion-button');

    accordionButtons.forEach(button => {
        button.addEventListener('click', function () {
            const icon = this.querySelector('.bi');
            if (this.classList.contains('collapsed')) {
                icon.classList.remove('bi-plus');
                icon.classList.add('bi-dash');
            } else {
                icon.classList.remove('bi-dash');
                icon.classList.add('bi-plus');
            }
        });
    });
});
    </script>

</body>

</html>